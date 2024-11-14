<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;

class SurveyController extends BaseController
{


    public function index()
    {

        $QuestionListController = new QandAController();
        $questionList = $QuestionListController->QuestionList1();
        $tenantData = $this->GetTenantData();
        $AnswerlistController = new AnswerlistController;
        // $answerdata = $AnswerlistController->AnswerList();
        // $answerList = $answerdata[0];
        $answerList = $AnswerlistController->AnswerList1();
        $a = session()->get("survey_Id");
       
        $reset = ["survey_Id" => 0];
        session()->set($reset);
        $optionsCountArray = [5, 7];
        $answerLimit=[5,20];
        $tenantData = $this->GetTenantData();
        return view('admin/CreateSurvey', ["getQuestData" =>  $questionList, "answerList" => $answerList, "tenantData" => $tenantData, "optionsCount" => $optionsCountArray, "answerLimit"=> $answerLimit]);
    }
    public function GetTenantData()
    {
        $model = new TenantModel();
        $tenantData = $model->where('tenant_name', session()->get('tenant_name'))->first();
        return $tenantData;
    }

    public function createSurvey()
    {

        $QuestionListController = new QandAController();
        // $questiondata=$QuestionListController->QuestionList1();
        // $questionList=$questiondata[1]; 
        $questionList = $QuestionListController->QuestionList1();
        // $AnswerlistController = new AnswerlistController;
        // $answerData=$AnswerlistController->AnswerList();
        // $answerList=$answerData[0];

        // $answerList = $AnswerlistController->AnswerList1();
        $tenantData = $this->GetTenantData();
        //$optionsCountArray = [5, 7];
        if ($this->request->getMethod() == 'post') {
            //     $rules = [
            //         'campaign_name' => 'required|min_length[2]|max_length[200]',
            //     ];
            //     $errors = [
            //         'campaign_name' => [
            //             'required' => 'You must choose a campaign name.',
            //         ]
            //     ];

            // if (!$this->validate($rules, $errors)) {

            //     return view('admin/CreateSurvey', [
            //         "validation" => $this->validator, "getQuestData" => $questionList
            //     ]);
            // } else {
            // $model = new TenantModel();
            // $tenant = $model->where('tenant_name', session()->get('tenant_name'))->first();
            $userId = session()->get('id');
            $postData = $this->request->getPost();
            //print_r ($_SESSION);
            $data = [
                "campaign_name" => $this->escapeString($postData["campaign_name"]),
                "placeholder_name" => $this->escapeString($postData["placeholder_name"]),
                "question_id_1" => 1,
                "question_id_2" => 2,
                "answer_id_2" => implode(',', $postData["ans_2"]),
                "question_id_3" => 3,
                "answer_id_3" => implode(',', $postData["ans_3"]),
                "question_id_4" => 4,
                "answer_id_4" => implode(',', $postData["ans_4"]),
                "user_id" => $userId
            ];
            if ($tenantData['tenant_id'] == 1) {
                $surv_id = $this->insertSurvey($data, $userId);
            } else {
                $this->tenantInsertSurvey($data, $tenantData, $userId);
            }
            session()->setFlashdata('response', "Create new Survey Successfully");
            //return redirect()->to(base_url('surveyList'));
            $reset = ["survey_Id" => 0];
            session()->set($reset);
            echo json_encode(['success' => true, 'csrf' => csrf_hash()]);

            //}
        }
        //return view('admin/CreateSurvey', ["action" => "Add", "getQuestData" => $questionList, "answerList" => $answerList, "tenantData" => $tenantData, "optionsCount" => $optionsCountArray]);
    }
    public function insertSurvey($data, $userId)
    {

        $model = new SurveyModel();

        $result = $model->insertBatch([$data]);
        $db = db_connect();
        $surv_id = $db->insertID();
        return $surv_id;
    }
    public function tenantInsertSurvey($data, $tenantdata, $userId)
    {

        $dbname = "nps_" . $tenantdata['tenant_name'];
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE ' . $dbname);

        $surveyId = session()->get("survey_Id");
        if ($surveyId == 0) {
            $model = new SurveyModel();
            // $lastSurveyId = $model->selectMax('campaign_id')->first();
            // $surveyId = (int)$lastSurveyId['campaign_id'] + 1;


            // $data["campaign_id"] = $surveyId;
            $key = array_keys($data);
            $values = array_values($data);
            $query = "INSERT INTO " . $dbname . ".nps_survey_details ( " . implode(',', $key) . ") VALUES('" . implode("','", $values) . "')";
        } else {
            $cols = array();

            foreach ($data as $key => $val) {
                $cols[] = "$key = '$val'";
            }
            $query = "UPDATE  " . $dbname . ".`nps_survey_details` SET " . implode(', ', $cols) . " WHERE `nps_survey_details`.`campaign_id` = " . $surveyId;
        }
        $db->query($query);
        $db->close();
        return true;
    }
    public function editsurvey($surv_id)
    {
        $getSurveyData = $this->getSurvey($surv_id);
        $QuestionListController = new QandAController();
        // $questiondata=$QuestionListController->QuestionList1();
        // $questionList=$questiondata[1];     
        $questionList = $QuestionListController->QuestionList1();
        $AnswerlistController = new AnswerlistController;
        // $answerData=$AnswerlistController->AnswerList();
        // $answerList=$answerData[0];   

        $defaultAnswerList = $AnswerlistController->DefaultAnswerList();
        $reset = ["survey_Id" => $surv_id];
        session()->set($reset);
        $a = session()->get("survey_Id");
        $tenantAnswerList = $AnswerlistController->TenantAnswerList();

        $answerList = [$defaultAnswerList, $tenantAnswerList];
        $tenantData = $this->GetTenantData();
        $optionsCountArray = [5, 7];
        $answerLimit=[5,20];
        if ($this->request->getMethod() == 'post') {
            // $rules = [
            //     'campaign_name' => 'required|min_length[2]|max_length[200]',
            // ];
            // $errors = [
            //     'campaign_name' => [
            //         'required' => 'You must choose a campaign_name.',
            //     ]
            // ];

            // if (!$this->validate($rules, $errors)) 
            // {
            //     return view('admin/EditSurvey', [
            //         "validation" => $this->validator,"getQuestData" => $questionList
            //     ]);
            // } 
            //else 
            //{
            // $model = new TenantModel();
            // $tenant = $model->where('tenant_name', session()->get('tenant_name'))->first();
            $userId = session()->get('id');
            $postData = $this->request->getPost();
            $data = [
                "campaign_name" => $this->escapeString($postData["campaign_name"]),
                "placeholder_name" => $this->escapeString($postData["placeholder_name"]),
                "question_id_1" => 1,
                "question_id_2" => 2,
                "answer_id_2" => implode(',', $postData["ans_2"]),
                "question_id_3" => 3,
                "answer_id_3" => implode(',', $postData["ans_3"]),
                "question_id_4" => 4,
                "answer_id_4" => implode(',', $postData["ans_4"]),
                "user_id" => $userId
            ];
            if ($tenantData['tenant_id'] == 1) {
                $model = new SurveyModel();
                $model->update($surv_id, $data);
            } else {
                $this->tenantUpdateSurvey($data, $tenantData, $surv_id);
            }
            session()->setFlashdata('response', "Update Survey Successfully");
            $data = ["survey_Id" => 0];
            session()->set($data);
            return redirect()->to(base_url('surveyList'));
            //}
        }
        
        return view('admin/EditSurvey', ["action" => "Edit", "surveyData" => $getSurveyData[0], "getQuestData" =>  $questionList, "answerList" => $answerList, "tenantData" => $tenantData, "optionsCount" => $optionsCountArray, "answerLimit"=> $answerLimit]);
    }

    public function tenantUpdateSurvey($data, $tenantdata, $surv_id)
    {

        $dbname = "nps_" . $tenantdata['tenant_name'];
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE ' . $dbname);
        $cols = array();

        foreach ($data as $key => $val) {
            $cols[] = "$key = '$val'";
        }

        $new_db_update_user = "UPDATE  " . $dbname . ".`nps_survey_details` SET " . implode(', ', $cols) . " WHERE `nps_survey_details`.`campaign_id` = " . $surv_id;
        $db->query($new_db_update_user);
        $db->close();
    }
    public function GetSurveyList()
    {

        $data = [];
        $surveyList = null;
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', session()->get('tenant_name'))->first();
        array_push($data, $tenant);
        if ($tenant['tenant_id'] == 1) {
            $model = new SurveyModel();
            $surveyList = $model->orderBy('created_at','DESC')->find();
        } else {
            $dbname = "nps_" . $tenant['tenant_name'];
            //new DB creation for Tenant details
            $db = db_connect();
            $query = "SELECT * FROM `" . $dbname . "`.`nps_survey_details` WHERE `status`='1' ORDER BY `created_at` DESC";
            $surveyList = $db->query($query)->getResultArray();
            $db->close();
        }
        array_push($data, $surveyList);

        return $data;
    }
    public function surveyList()
    {
        $surveyListData = $this->GetSurveyList();
        $surveyList = $surveyListData[1];
        return view('admin/surveyList', ["surveyList" => $surveyList, "tenant" => $surveyListData[0]]);
    }
    public function getSurvey($survey_id)
    {

        $survey = null;
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', session()->get('tenant_name'))->first();
        if ($tenant['tenant_id'] == 1) {
            $model = new SurveyModel();
            $survey = $model->where('campaign_id', $survey_id)->find();
        } else {
            $dbname = "nps_" . $tenant['tenant_name'];
            //new DB creation for Tenant details
            $db = db_connect();
            $query = "SELECT * FROM `" . $dbname . "`.`nps_survey_details` WHERE campaign_id='" . $survey_id . "'";
            $survey = $db->query($query)->getResultArray();
            $db->close();
        }

        return $survey;
    }
    public function deletesurvey($surv_id)
    {
        $modeldel = new TenantModel();
        $tenant = $modeldel->where('tenant_name', session()->get('tenant_name'))->first();
        $data = ['status' => '0'];
        if ($tenant['tenant_id'] == 1) {
            $model = new SurveyModel();
            $model->update($surv_id, $data);
            //$model->where('campaign_id', $surv_id)->delete();
        } else {
            $this->tenantDeleteSurvey($tenant, $surv_id);
        }
        session()->setFlashdata('response', "Survey deleted Successfully");
        return redirect()->to(base_url('surveyList'));
    }
    public function tenantDeleteSurvey($tenantdata, $surv_id)
    {
        $data = ['status' => '0'];
        $dbname = "nps_" . $tenantdata['tenant_name'];
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE ' . $dbname);
        //$delete_query  = "DELETE FROM " . $dbname . ".`nps_survey_details` WHERE `nps_survey_details`.`campaign_id` =" . $surv_id;
        $delete_query="UPDATE  " . $dbname . ".nps_survey_details SET nps_survey_details.status = '" . $data['status'] . "' WHERE `nps_survey_details`.`campaign_id` = '" . $surv_id . "'";
        
        $db->query($delete_query);
        $db->close();
    }
    public function escapeString($val)
    {
        $db = db_connect();
        $connectionId = $db->connID;
        $val = mysqli_real_escape_string($connectionId, $val);
        return $val;
    }
}
