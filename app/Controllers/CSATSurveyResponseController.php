<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CSATEmailSendListModel;
use App\Models\CSATSurveyModel;
use App\Models\CSATSurveyResponseModel;
use App\Models\ExternalcontactsModel;
use App\Models\MailScheduleModel;
use App\Models\ModelHelper;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;

class CSATSurveyResponseController extends BaseController
{

    private $modelHelper;

    public function __construct()
    {
        $this->modelHelper = new ModelHelper();
    }
    public function SurveyResponse()
    {
        $selectedSurvey = null;
        $getfullcollection = array();
        $surveyList = array();
        $dbname = "";

        
        $tenantId = ($this->request->getGet("tenantId") != '') ? $this->request->getGet("tenantId") :  session()->get('tenant_id');
        $selectedSurveyId = $this->request->getMethod() == 'get' ? $this->request->getGet("surveyId") : 0;

        if ($tenantId > 1) {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            $dbname = "nps_" . $tenant['tenant_name'];
        }
        $model = new TenantModel();
        //echo($model->db->database);
        $getTenantdata = $model->findall();

        $questionController = new CSATQandAController();
        $questionList = $questionController->GetAllQuestions();


        $selectTenant = $tenantId;

        $surveyResponseList = array();

        //get suvery List
        $model = new CSATSurveyModel();
        $condition = ['sent_status' => '0', 'status' => '1'];
        $surveyList = $this->modelHelper->GetAllDataUsingWhere($model, $condition);

        if (count($surveyList) > 0) {
            if ($selectedSurveyId == 0) {
                $lastSurvey = end($surveyList);
                $selectedSurveyId = $lastSurvey['survey_id'];
                $selectedSurvey = $lastSurvey;
            } else {
                foreach ($surveyList as $survey) {
                    if ($survey['survey_id'] == $selectedSurveyId) {
                        $selectedSurvey = $survey;
                        break;
                    }
                }
            }
        }
        $recipientList = array();
        if ($selectedSurveyId > 0) {
            //get the survey response of the surveyId
            $model = new CSATSurveyResponseModel();
            $multiClause = array('survey_id' => $selectedSurveyId);
            $surveyResponseList = $model->where($multiClause)->orderBy('created_at', 'DESC')->find();
            $recipientList =  $this->GetRecipientList($selectedSurveyId, $dbname);

            foreach ($surveyResponseList as $key => $surveyResponse) {

                $response = $this->GetSurveyResponse($surveyResponse, $questionList);

                $model = new CSATEmailSendListModel();
                $res = $model->where('survey_id', $surveyResponse['survey_id'])->like('email_list', $surveyResponse['email'], 'both')->first();

                $sendDate = new \DateTime($res['created_at']);
                $respondedDate = new \DateTime($surveyResponse['created_at']);
                $timeInterval = date_diff($sendDate, $respondedDate);

                $getSurveycollection = [
                    //"survey_id" => $surveyResponse['id'],
                    "campaign_id" => $surveyResponse['survey_id'],
                    "campaign_name" => $selectedSurvey['survey_name'],
                    //"ip_details" => $surveyResponse['ip_details'],
                    "location" => $surveyResponse['location'],
                    "answerData" => $response["answers"],
                    "created_at_time" => date("h:m:s", strtotime($surveyResponse["created_at"])),
                    "created_at_date" => date("l, m, d, Y", strtotime($surveyResponse["created_at"])),
                    "timeInterval" => $timeInterval->format('%H:%I:%S'),
                    "questionData" => $response["questions"],
                    "userdata" => $response["contact"]

                ];
                array_push($getfullcollection, $getSurveycollection);
            }
        }
        return view('csat/surveyresponselist', ['surveyData' =>  $getfullcollection, "surveyList" => $surveyList, "selectsurvey" => $selectedSurvey, "getTenantdata" => $getTenantdata, "selectTenant" => $selectTenant, "recipientList" => $recipientList]);
    }

    public function GetSurveyResponse($surveyResponse, $questions)
    {
        //get question data
        $questionIdList = [$surveyResponse['question_id'], $surveyResponse['question_id_2'], $surveyResponse['question_id_3'], $surveyResponse['question_id_4'], $surveyResponse['question_id_5'], $surveyResponse['question_id_6']];
        $surveyQuestions = array();
        $surveyAnswers=array();
        foreach ($questionIdList as $key => $questionId) {
            $index=($key==0 )? "":"_".$key+1 ;
            if ($questionId != 0) {
                $question = $this->FindElement($questions, "question_id", $questionId);
                array_push($surveyQuestions, $question);
                array_push($surveyAnswers, $surveyResponse['answer'.$index]);

            }
        }

        //get external contacts
        $model = new ExternalcontactsModel();
        $condition = array('email_id' => $surveyResponse['email']); //, 'status' => 1);
        $contact = $model->where($condition)->first();

        $response = ["contact" => $contact, "questions" => $surveyQuestions,"answers"=>$surveyAnswers ];

        return $response;
    }
    private function GetRecipientList(int $surveyId, string $tenantDbName)
    {
        $model = new CSATEmailSendListModel();
        $selectArray = ['email_list'];
        $result = $model->select($selectArray)->where('survey_id', $surveyId)->findAll();
        $emailStr = "";
        $count = 0;
        foreach ($result as  $emailList) {
            $emailStr = ($count == 1) ? $emailStr . ', ' : $emailStr;
            $emailStr = $emailStr . "$emailList[email_list]";
            $count = 1;
        }
        $emailArray = explode(', ', $emailStr);
        $emailUnique = array_unique($emailArray);

        $model = new ExternalcontactsModel();
        $selectArray = ['name', 'email_id'];
        $recipientList = $model->select($selectArray)->whereIn('email_id', $emailUnique)->findAll();
        $dbName = "nps_shared";
       $db=  $this->modelHelper->ConnectDB($dbName);
        $model = new MailScheduleModel();
        $condition = ["tenant_id" => session()->get('tenant_id'), "survey_id" => $surveyId];
        $scheduleList = $model->where($condition)->whereIn("customer_mail", $emailUnique)->findColumn('customer_mail');
        if ($scheduleList) {
            $uniqueSchedList = array_unique($scheduleList);
            for ($i = 0; $i < count($recipientList); $i++) {
                if (in_array($recipientList[$i]['email_id'], $uniqueSchedList)) {
                    # code...
                    $recipientList[$i]['send_status'] = "In Progress";
                } else {
                    $recipientList[$i]['send_status'] = "sent";
                }
            }
        } else {
            for ($i = 0; $i < count($recipientList); $i++) {
                $recipientList[$i]['send_status'] = "sent";
            }
        }
        //$dbName = "";
        $db=  $this->modelHelper->ConnectDB($tenantDbName);
        return $recipientList;
    }
    private function FindElement($searchArr, $searchKey, $searchValue)
    {

        foreach ($searchArr as $index => $value) {

            if ($value[$searchKey] == $searchValue) {
                return $value;
            }
        }
    }

    public function DownloadCsv()
    {
        $postData = $this->request->getPost();
        if (!empty($postData['req'])) {

            //$fp = fopen('../public/csvfile/SurveyData.csv', 'w');
            $fp = fopen('php://output', 'w');

            $flag = true;
            foreach ($postData['req'] as $response) {
                if ($flag) {
                    $title = array("", "", "", "Campaign Name:", $response["campaign_name"]);
                    fputcsv($fp, $title);
                    $headers = array("Campaign sent time", "Campaign sent date", "Time Interval", "Location", "Customer Name", "Phone Number", "Mail Id", "Rating Question", "Response", "First Question", "Response", "Second Question", "Response", "Third Question","Response", "Fourth Question","Response","Fifth Question","Response");
                    fputcsv($fp, $headers);
                    $flag = false;
                }
                $row = array($response["created_at_time"], $response["created_at_date"], $response["timeInterval"], $response["location"], $response["userdata"]["name"], $response["userdata"]["contact_details"], $response["userdata"]["email_id"]);
                for ($i=0; $i < count($response["questionData"]); $i++) { 
                    $question=$response["questionData"][$i]["question"];
                    $answer= $response["answerData"][$i];
                    array_push($row,$question,$answer);
                }
                
                fputcsv($fp, $row);
            }

            fclose($fp);
        }
        exit();
    }
}
