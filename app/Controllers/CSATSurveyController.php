<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CSATAnswerModel;
use App\Models\CSATEmailSendListModel;
use App\Models\CSATQuestionModel;
use App\Models\CSATSurveyModel;
use App\Models\CSATSurveyResponseModel;
use App\Models\ExternalcontactsModel;
use App\Models\ModelHelper;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\SurveyModel;
use App\Libraries\EnumsAndConstants\AnswerColumn;

require_once APPPATH . 'Libraries/EnumsAndConstants/Enums.php';

class CSATSurveyController extends BaseController
{

    private $modelHelper;

    public function __construct()
    {
        $this->modelHelper = new ModelHelper();
    }
    public function index()
    {
        //print_r($_SESSION);
        //exit;
        $QuestionListController = new QandAController();
        // $questiondata=$QuestionListController->QuestionList1();
        // $questionList=$questiondata[1];
        $questionList = $QuestionListController->QuestionList1();
        $tenantData = $this->GetTenantData();
        $AnswerlistController = new AnswerlistController;
        // $answerdata = $AnswerlistController->AnswerList();
        // $answerList = $answerdata[0];
        $answerList = $AnswerlistController->AnswerList1();
        $a = session()->get("survey_Id");
        //$allAnswers = $AnswerlistController->GetPreviousAnswers();

        // $data = ["survey_Id" => ""];
        // session()->set($data);
        $reset = ["survey_Id" => 0];
        session()->set($reset);
        $optionsCountArray = [5, 7];
        $answerLimit = [5, 20];
        $tenantData = $this->GetTenantData();
        return view('admin/CreateSurvey', ["getQuestData" => $questionList, "answerList" => $answerList, "tenantData" => $tenantData, "optionsCount" => $optionsCountArray, "answerLimit" => $answerLimit]);
    }
    public function GetTenantData($tenantId = null)
    {
        $tenantId = $tenantId ? $tenantId : session()->get('tenant_id');
        $model = new TenantModel();
        $tenantData = $model->where('tenant_id', $tenantId)->first();
        return $tenantData;
    }

    public function AddOrUpdateSurvey()
    {
        // Log post data for debugging
        error_log(print_r($this->request->getPost(), true));

        $model = new CSATSurveyModel();

        // Handle GET request (loading the form)
        if ($this->request->getMethod() == 'get') {
            $QuestionListController = new CSATQandAController();
            $questionList = $QuestionListController->GetAllQuestionsByGroup();

            $answerList = [1 => "Numeric", 2 => "Emoji", 3 => "Text"];
            $survey = null;
            $request = $this->request->getGet();

            if (isset($request["surveyId"])) {
                $condition = ["survey_id" => $request["surveyId"]];
                $survey = $this->modelHelper->GetSingleData($model, $condition);
            }
            return view("csat/createSurvey2", [
                "survey" => $survey,
                "mainQuestionList" => $questionList[0],
                "followupQuestionList" => $questionList[1],
                "answerList" => $answerList
            ]);
        }

        // Handle POST request (form submission)
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'survey_name' => 'required|min_length[5]|max_length[200]',
                'company_service' => 'required|min_length[3]|max_length[200]',
                'main_question' => 'required'
            ];

            $errors = [
                'survey_name' => [
                    'required' => 'Survey name is required.',
                    'min_length' => 'Please enter at least 5 letters.',
                    'max_length' => 'Maximum 200 letters are allowed for survey name.'
                ],
                'company_service' => [
                    'required' => 'Survey question is required.',
                    'min_length' => 'Please enter at least 3 characters.',
                    'max_length' => 'Maximum 200 characters are allowed for the survey question.'
                ],
                'main_question' => [
                    'required' => 'Please choose a rating style.'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $output = $this->validator->getErrors();
                return json_encode([
                    'success' => false,
                    'csrf' => csrf_hash(),
                    'error' => $output
                ]);
            }

            // Collect form data after validation
            $userId = session()->get('id');
            $postData = $this->request->getPost();

            $data = [
                "survey_name" => $postData["survey_name"],
                "company_service" => $postData["company_service"],
                "main_question" => $postData["main_question"],
                "updated_by" => $userId
            ];

            $dbname = session()->get("db_name");
            $db = $this->modelHelper->ConnectDB($dbname);

            if (isset($postData["survey"])) {
                // Update existing survey
                $result = $this->modelHelper->UpdateData($model, $postData["survey"], $data);
            } else {
                // Create new survey
                $data["created_by"] = $userId;
                $result = $this->modelHelper->InsertData($model, $data);
            }

            return json_encode([
                'success' => true,
                // 'csrf' => csrf_hash(),
                session()->setFlashdata('response', "Survey Added Successfully"),
                "url" => base_url("csat/surveyList")
            ]);
        }
    }

    // public function Deletesurvey()
    // {
    //     $request = $this->request->getPost();
    //     $model = new CSATSurveyModel();
    //     $dbname = session()->get("db_name");
    //     $db = $this->modelHelper->ConnectDB($dbname);


    //     $data = ['status' => '0'];
    //     $this->modelHelper->UpdateData($model, $request["surveyId"], $data);
    //     session()->setFlashdata('response', "Survey deleted Successfully");
    //     return redirect()->to(base_url('csat/surveyList'));
    // }
    public function Deletesurvey()
    {
        $request = $this->request->getPost();
        $model = new CSATSurveyModel();
        $dbname = session()->get("db_name");
        $db = $this->modelHelper->ConnectDB($dbname);

        // Ensure surveyId is provided in the request
        if (!isset($request["surveyId"])) {
            session()->setFlashdata('error', "Survey ID is missing.");
            return redirect()->to(base_url('csat/surveyList'));
        }

        // Delete the survey from the database
        $condition = ["survey_id" => $request["surveyId"]];
        $result = $this->modelHelper->DeleteData($model, $condition); // Assuming DeleteData performs a delete query
        $data = ['status' => '0'];
        $this->modelHelper->UpdateData($model, $request["surveyId"], $data);
        if ($result) {
            session()->setFlashdata('response', "Survey deleted successfully.");
        } else {
            session()->setFlashdata('error', "Failed to delete the survey.");
        }

        return redirect()->to(base_url('csat/surveyList'));
    }

    public function GetSurveyList()
    {

        //new DB creation for Tenant details

        $tenant = session()->get('tenant_id');
        if ($tenant == 1) {
            $model = new SurveyModel();
            $surveyList = $model->orderBy('created_at', 'DESC')->find();
        } else {
            $dbname = session()->get("db_name");
            $db = $this->modelHelper->ConnectDB($dbname);
            $model = new CSATSurveyModel();
            $condition = [
                "status" => "1"
            ];
            $surveyList = $this->modelHelper->GetAllDataUsingWhere($model, $condition);
        }

        return $surveyList;
    }
    public function SurveyList()
    {
        $surveyList = $this->GetSurveyList();
        // $surveyList = $surveyListData;
        return view('csat/surveyList', ["surveyList" => $surveyList]); //, "tenant" => $surveyListData[0]]);
    }
    public function getSurvey($survey_id)
    {

        $survey = null;
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', session()->get('tenant_name'))->first();
        if ($tenant['tenant_id'] == 1) {
            $model = new SurveyModel();
            $survey = $model->where('campaign_id', $survey_id)->find();
        }

        return $survey;
    }

    public function escapeString($val)
    {
        $db = db_connect();
        $connectionId = $db->connID;
        $val = mysqli_real_escape_string($connectionId, $val);
        return $val;
    }

    public function SendSurvey()
    {

        $surveyList = $this->GetSurveyList();
        $contactList = $this->GetContactData();
        $surveyEmail = session()->get("survey_email");
        $from = strlen($surveyEmail) > 0 ? $surveyEmail : "support@cxanalytix.com";


        if ($this->request->getMethod() == 'post' && !($this->request->getPost("email_id"))) {

            $rules = [
                'From' => 'required|min_length[6]|max_length[50]|valid_email',
                'Name' => 'required|min_length[3]|max_length[50]',
                'To' => 'ValidateRecipientList[To]'
            ];
            $errors = [

                'From' =>
                    [
                        'valid_email' => 'Please check the From field. It does not appear to be valid email.',
                    ],
                'Name' =>
                    [
                        'min_length' => 'Please enter atleast 3 letters.',
                        'max_length' => 'Please enter less than 50 letters.'
                    ],
                'To' =>
                    [
                        'ValidateRecipientList' => 'Please choose a customer to send mail.'
                    ]

            ];
            if (!$this->validate($rules, $errors)) {
                $a = $this->validator->getErrors();
                return view('csat/emailtemplate', ["validation" => $this->validator, "getSurvey" => $surveyList, "externalList" => $contactList, "from" => $from]);
            } else {

                $userId = session()->get('id');
                $tenant = [
                    "tenant_id" => session()->get('tenant_id'),
                    "tenant_name" => session()->get('tenant_name')
                ];
                $postData = $this->request->getPost();
                $toList = json_decode($postData["To"]);
                $postData["emailList"] = $toList[0];

                $customerController = new CustomerController();

                if ($tenant['tenant_id'] != 1) {
                    $db_name = session()->get("db_name");
                    $this->modelHelper->ConnectDB($db_name);
                    $segmentsMailList = $customerController->GetEmailsFromSegments($toList[1]);
                    $mailList = array_merge($toList[0], $segmentsMailList);
                    $uniqueMailList = array_unique($mailList);
                    $postData["emailList"] = $uniqueMailList;
                    $this->InsertEmailSendList($postData, $userId, $tenant);
                }

                // $model = new SurveyModel();
                // $surveyData = $model->where('campaign_id', $postData["survey"])->first();
                // $postData["placeholder_name"] = $surveyData["placeholder_name"];

                //$emailstatus = $this->createTemplateForSurvey($postData, $userId, $postData['checkoutemail'], $tenant);



                $emailTemplateController = new EmailTemplateController();

                $emailstatus = $emailTemplateController->ScheduleMail($postData, $userId, $postData["emailList"], $tenant, true);

                //exit();
                $db_name = session()->get("db_name");
                $this->modelHelper->ConnectDB($db_name);
                $model = new CSATSurveyModel();
                $updateValue = ['sent_status' => '0'];
                $model->update($postData["survey"], $updateValue);
                session()->setFlashdata('response', $emailstatus);
                return redirect()->to(base_url('csat/sendSurvey'));
            }
        }
        return view('csat/emailtemplate', ["getSurvey" => $surveyList, "externalList" => $contactList, "to" => $this->request->getPost("email_id"), "from" => $from]);
    }

    public function GetContactData()
    {
        $tenant = session()->get('tenant_id');
        $contactList = [];
        if ($tenant != 1) {
            $dbname = session()->get("db_name");
            $db = $this->modelHelper->ConnectDB($dbname);

            $model = new ExternalcontactsModel();
            $condition = ["status" => "1"];
            $contactList = $this->modelHelper->GetAllDataUsingWhere($model, $condition);
            //$db->close();

        }
        return $contactList;
    }

    public function InsertEmailSendList($postData, $userId, $tenant)
    {
        $List = implode(', ', $postData["emailList"]);
        $data = [
            "subject" => $postData['subject'] ? $postData['subject'] : "What did you think about NPS",
            "survey_id" => $postData["survey"],
            "email_list" => $List,
            "message" => $postData["editor"],
            "created_by" => $userId
        ];

        $model = new CSATEmailSendListModel();
        $this->modelHelper->InsertData($model, $data);
    }

    public function GetSurveyQuestion($customerId, $surveyId, $userId, $tenantId)
    {

        if ($tenantId > 1) {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            $dbname = "nps_" . $tenant['tenant_name'];

            $db = $this->modelHelper->ConnectDB($dbname);
            $condition = ["id" => $customerId];
            $model = new ExternalcontactsModel();
            $customer = $this->modelHelper->GetSingleData($model, $condition);

            $survey = $this->CheckSurvey($surveyId);
            $isSurveyPresent = $survey ? true : false;
            if ($isSurveyPresent) {
                $isResponse = $this->CheckResponse($customer['email_id'], $surveyId);
            }
            // $db->close();
        }
        if ($isSurveyPresent) {
            if (!$isResponse) {
                if ($tenantId > 1) {
                    $question = $this->GetQuestionDetails($survey["question_id"]);
                    $answer = $this->GetAnswerDetails($survey["answer_list"]);
                    $isImage = false;
                    if ($survey["answer_list"] == 2) {
                        $isImage = true;
                    }
                }
                $surveyData = [
                    "surveyId" => $survey["survey_id"],
                    "question" => $question,
                    "customerId" => $customer["id"],
                    "customerName" => $customer["name"],
                    "tenantId" => $tenant["tenant_id"],
                    "answerList" => $answer,
                    "isImage" => $isImage
                ];
                //   $data =  ["logo_user" => $getSurveyData['userData']['logo_update']];
                //  session()->set($data);
                return view('csat/validateAnswer', ["surveyData" => $surveyData]); //, "randomKey" => $randomKey]);
            } else {
                $response = "Your survey feedback already added. Please check with Admin";
                session()->setFlashdata('response', $response);
                return view('thankyou');
            }
        }
        return view('Error');
    }
    public function CheckResponse(string $email, int $campaignId)
    {
        $flag = false;

        $model = new CSATSurveyResponseModel();
        $condition = ['email' => $email, 'survey_id' => $campaignId];
        $returnkey = $model->where($condition)->first();

        $flag = $returnkey ? true : false;
        return $flag;
    }

    public function CheckSurvey(int $surveyId)
    {
        $model = new CSATSurveyModel();
        $condition = ['survey_id' => $surveyId, 'status' => '1'];
        $survey = $this->modelHelper->GetSingleData($model, $condition);
        return $survey;
    }

    public function GetQuestionDetails($questionId)
    {
        $model = new CSATQuestionModel();
        $condition = ['question_id' => $questionId];
        $question = $this->modelHelper->GetSingleData($model, $condition);
        return $question;
    }

    public function GetAnswerDetails($answerType)
    {
        $model = new CSATAnswerModel();
        $column = AnswerColumn::from($answerType)->name;
        $result = $this->modelHelper->GetAllData($model);

        $answerList = array_column($result, $column);
        return $answerList;
    }
    public function GetCustomerDetails($customerId)
    {
        $condition = ["id" => $customerId];
        $model = new ExternalcontactsModel();
        $customer = $this->modelHelper->GetSingleData($model, $condition);
        return $customer;
    }

    public function GetNextQuestion()
    {
        if ($this->request->isAJAX()) {
            $query = service('request')->getPost();
            $rating = $query['QandA1'];
            $tenantId = $query['tenant'];
            $surveyId = $query['surveyId'];

            $questionId = null;
            $QandA2 = [];
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();

            $dbname = "nps_" . $tenant['tenant_name'];
            $db = $this->modelHelper->ConnectDB($dbname);

            $survey = $this->CheckSurvey($surveyId);

            $model = new CSATQuestionModel();
            $questionIds = explode(",", $survey["question_id_" . $rating]);
            $questionList = $model->GetQuestionsUsingWhereIn("question_id", $questionIds);

            $db->close();
            //Get default question list
            $dbname = "nps_shared";

            $this->modelHelper->ConnectDB($dbname);
            $defaultQuestionList = $model->GetQuestionsUsingWhereIn("question_id", $questionIds);

            $questionResult = array_merge($defaultQuestionList, $questionList);
            $questions = [];
            foreach ($questionResult as $key => $value) {
                $questions["q_id"] = $value["question_id"];
                $questions["q_name"] = $value["question"];
            }

            echo json_encode(['success' => true, 'csrf' => csrf_hash(), 'query' => $questionResult]);
        }
    }

    public function GetSurveyCustomerAndTenantData($customerId, $surveyId, $tenantId)
    {

        $tenant = $this->GetTenantData($tenantId);
        $dbName = "nps_" . $tenant["tenant_name"];
        $db = $this->modelHelper->ConnectDB($dbName);
        $customer = $this->GetCustomerDetails($customerId);
        $survey = $this->CheckSurvey($surveyId);
        $question = $this->GetQuestionDetails($survey["question_id"]);
        $surveyData = [
            "surveyId" => $survey["survey_id"],
            "question" => $question,
            "customerId" => $customer["id"],
            "emailId" => $customer["email_id"],
            "customerName" => $customer["name"],
            "tenantId" => $tenant["tenant_id"]
        ];
        return $surveyData;
    }
    public function SaveResponse()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Answer_1' => 'required|numeric',
                'Answer.*' => 'required',
            ];
            $errors = [
                'Answer_1' => [
                    'required' => 'You must choose a first question.',
                ],
                'Answer.*' => [
                    'required' => 'You must answer all the questions.',
                ]
            ];
            $request = $this->request->getPost();
            $surveyData = $this->GetSurveyCustomerAndTenantData($request["emailId"], $request["surveyId"], $request["tenantId"]);
            if (!$this->validate($rules, $errors)) {
                return view('validateAnswer', [
                    "validation" => $this->validator,
                    "getSurveyData" => $surveyData,
                    //"randomKey" => $this->request->getPost("randomkey")
                ]);
            } else {

                $isResponse = $this->CheckResponse($surveyData['emailId'], $request["surveyId"]);
                if (!$isResponse) {
                    $answer = array();
                    //$answer2 = implode(",", $this->request->getPost("Answer_2"));
                    //array_push($answer, $this->request->getPost("Answer_1"), $answer2);
                    $data = [
                        "survey_id" => $request["surveyId"],
                        "email" => $surveyData['emailId'],
                        //"user_id" => $this->request->getPost("userid"),
                        "question_id" => $request["question_1"],
                        "answer" => $request["Answer_1"],
                        "mail_status" => "",
                        "ip_details" => getHostByName(getHostName()),
                        "location" => $this->GetLocation()
                    ];
                    $index = 2;
                    foreach ($request["Answer"] as $key => $value) {

                        $data["question_id_" . $index] = $key;
                        $data["answer_" . $index] = $value;
                        $index++;

                    }
                    $model = new CSATSurveyResponseModel();
                    $result = $model->insertBatch([$data]);

                    $response = "Your survey feedback has been recorded.";
                } else {
                    $response = "Your survey feedback already added. Please check with Admin";
                }
                session()->setFlashdata('response', $response);
                return view('thankyou', ["getSurveyData" => $surveyData]);
            }
        }
    }
    public function GetLocation()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ipdata = @json_decode(file_get_contents(
            "http://www.geoplugin.net/json.gp?ip=" . $ip
        ));

        $location = $ipdata->geoplugin_countryName ? $ipdata->geoplugin_countryName : "Local";
        return $location;
    }
}
