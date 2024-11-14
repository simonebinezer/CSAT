<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnswerListModel;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;
use App\Models\ExternalcontactsModel;
use App\Models\CreatecontactsModel;
use App\Models\SurveyResponseModel;
use App\Models\MailScheduleModel;
use DateInterval;
use \Exception;

class SurveyResponseController extends BaseController
{
    public function index()
    {
        $selectedSurvey = null;
        $getfullcollection = array();
        $surveyList = array();
        $dbname="";

        $tenantId = ($this->request->getGet("tenantId") != '') ? $this->request->getGet("tenantId") :  session()->get('tenant_id');
        $selectedSurveyId = $this->request->getMethod() == 'get' ? $this->request->getGet("surveyId") : 0;


        $defaultQandA = $this->GetDefaultQueAndAns();
        $defaultQuestions = $defaultQandA["questions"];
        $defaultAnswerList = $defaultQandA["answers"];

        $model = new TenantModel();
        //echo($model->db->database);
        $getTenantdata = $model->findall();
        if ($tenantId > 1) {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            $dbname = "nps_" . $tenant['tenant_name'];

            //$model->db->setDatabase($dbname);
            //echo($model->db->database);
            $db = db_connect();
            $db->query('USE ' . $dbname);
        }
        $selectTenant = $tenantId;
        $userId = array();
        $model = new UserModel();
        $userlist = $model->where('tenant_id', $tenantId)->findall();
        foreach ($userlist as $userarray) {
            array_push($userId, $userarray['id']);
        }
        $surveyResponseList = array();

        //get suvery List
        $model = new SurveyModel();
        $surveyList = $model->whereIn('user_id', $userId)->where('sent_status', '0')->where('status', '1')->find();
        if (count($surveyList) > 0) {
            if ($selectedSurveyId == 0) {
                $lastSurvey = end($surveyList);
                $selectedSurveyId = $lastSurvey['campaign_id'];
                $selectedSurvey = $lastSurvey;
            } else {
                foreach ($surveyList as $survey) {
                    if ($survey['campaign_id'] == $selectedSurveyId) {
                        $selectedSurvey = $survey;
                        break;
                    }
                }
            }
        }
	$recipientList= array();
        if ($selectedSurveyId > 0) {
            //get the survey response of the surveyId
            $model = new SurveyResponseModel();
            $multiClause = array('campaign_id' => $selectedSurveyId);
            $surveyResponseList = $model->whereIn('user_id', $userId)->where($multiClause)->orderBy('created_at', 'DESC')->find();
            $recipientList =  $this->GetRecipientList($selectedSurveyId,$dbname);

            foreach ($surveyResponseList as $key => $surveyResponse) {

                $response = $this->GetSurveyResponse($surveyResponse, $selectedSurvey, $defaultQuestions, $defaultAnswerList);

                $model = new CreatecontactsModel();
                $res = $model->where('survey_id', $surveyResponse['campaign_id'])->like('email_list', $surveyResponse['email'], 'both')->first();

                $sendDate = new \DateTime($res['created_at']);
                $respondedDate = new \DateTime($surveyResponse['created_at']);
                $timeInterval = date_diff($sendDate, $respondedDate);

                $getSurveycollection = [
                    //"survey_id" => $surveyResponse['id'],
                    "campaign_id" => $surveyResponse['campaign_id'],
                    "campaign_name" => $selectedSurvey['campaign_name'],
                    //"ip_details" => $surveyResponse['ip_details'],
                    "location" => $surveyResponse['location'],
                    "answer_id1" => $surveyResponse['answer_id'],
                    "answer_id2" => $response["answers"],
                    "created_at_time" => date("h:m:s", strtotime($surveyResponse["created_at"])),
                    "created_at_date" => date("l, m, d, Y", strtotime($surveyResponse["created_at"])),
                    "timeInterval" => $timeInterval->format('%H:%I:%S'),
                    "questiondata" => $response["questions"],
                    "userdata" => $response["contact"]

                ];
                array_push($getfullcollection, $getSurveycollection);
            }
        }
        return view('admin/surveyresponselist', ['getSurveyData' =>  $getfullcollection, "getsurveylist" => $surveyList, "selectsurvey" => $selectedSurvey, "getTenantdata" => $getTenantdata, "selectTenant" => $selectTenant, "recipientList" => $recipientList]);
    }

    public function GetSurveyResponse($surveyResponse, $survey, $defaultQuestions, $defaultAnswerList)
    {
        //get question data
        //$model = new QuestionModel();
        $question_id = [$surveyResponse['question_id'], $surveyResponse['question_id2']];
        //$getquestionData = $model->whereIn('question_id', $question_id)->find();

        $questions = array();

        //bind the placeholder name
        $defaultQuestions[0]["question_name"] = str_replace("[Our Company/Product/Service Name]", $survey["placeholder_name"], $defaultQuestions[0]["question_name"]);
        array_push($questions, $defaultQuestions[0], $defaultQuestions[$question_id[1] - 1]);

        //get answer data
        $answer_id2 = $surveyResponse['answer_id2'];
        $answer_id2Array = explode(',', $answer_id2);
        $model = new AnswerListModel();
        $answer2_List = $model->whereIn('answer_id', $answer_id2Array)->find();

        foreach ($answer_id2Array as $key => $value) {
            foreach ($defaultAnswerList as $key2 => $value2) {
                if ($value == $value2['answer_id']) {
                    array_push($answer2_List, $value2);
                    break;
                }
            }
        }

        $answer2_Str = "";
        $answer2_names = array();
        foreach ($answer2_List as $key2 => $answer2) {
            array_push($answer2_names, $answer2["answer_name"]);
        }
        $answer2_Str = implode(",", $answer2_names);

        //get external contacts
        $model = new ExternalcontactsModel();
        $condition = array('email_id' => $surveyResponse['email']); //, 'status' => 1);
        $contact = $model->where($condition)->first();

        $response = ["contact" => $contact, "questions" => $questions, "answers" => $answer2_Str];

        return $response;
    }

    private function GetRecipientList(int $surveyId, string $tenantDbName)
    {
        $model = new CreatecontactsModel();
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
        $emailTempController = new EmailTemplateController();
        $dbName = "nps_shared";
        $emailTempController->ConnectDB($dbName);
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
        $emailTempController->ConnectDB($tenantDbName);
        return $recipientList;
    }

    public function GetDefaultQueAndAns()
    {
        $model = new AnswerListModel();
        $defaultAnswerList = $model->find();

        $model = new QuestionModel();
        $defaultQuestions = $model->find();

        $defaultQandA = ["questions" => $defaultQuestions, "answers" => $defaultAnswerList];

        return $defaultQandA;
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
                    $title = array("", "", "", "Campaign Name:", $response["survey_name"]);
                    fputcsv($fp, $title);
                    $headers = array("Campaign sent time", "Campaign sent date", "Time Interval", "Location", "Customer Name", "Phone Number", "Mail Id", "First Question", "Response", "Second Question", "Response");
                    fputcsv($fp, $headers);
                    $flag = false;
                }
                $row = array($response["created_at_time"], $response["created_at_date"], $response["timeInterval"], $response["location"], $response["userdata"]["name"], $response["userdata"]["contact_details"], $response["userdata"]["email_id"], $response["questiondata"][0]["question_name"], $response["answer_id1"], $response["questiondata"][1]["question_name"], $response["answer_id2"]);
                fputcsv($fp, $row);
            }

            fclose($fp);
        }
        exit();
    }
}
