<?php

namespace App\Validation;

use App\Controllers\AnswerlistController;
use App\Models\ExternalcontactsModel;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\TagModel;
use App\Models\SegmentModel;

class Userrules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', $data['tenantname'])->first();
        if ($tenant) {
            $model = new UserModel();
            $multiClause = array('email' => $data['email'], 'tenant_id' => $tenant['tenant_id']);
            $user = $model->where($multiClause)->first();

            if (!$user) {
                return false;
            }
        } else {
            return false;
        }

        return password_verify($data['password'], $user['password']);
    }
    public function ValidateOtp(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $userid = session()->get('otp_id');
        $multiClause = array('id' => $userid, "otp_check" => $data["vcode"]);
        $user = $model->where($multiClause)
            ->first();
        if ($user) {
            return true;
        }
        return false;
    }
    public function validateTenant(string $str, string $fields, array $data)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', $data['tenantname'])
            ->first();

        if (!$tenant) {
            return true;
        }
        return false;
    }
    public function validateEmail(string $str, string $fields, array $data)
    {
        $user = $this->GetUser($data);

        if (!$user) {
            return true;
        }
        return false;
    }
    public function validateSurveyEmail(string $str, string $fields, array $data)
    {
        $model = new TenantModel();
        $user = $model->where('survey_email', $data['survey_email'])
            ->first();

        if (!$user) {
            return true;
        }
        return false;
    }

    public function GetUser($data)
    {
        $model = new UserModel();
        $user = $model->where('email', $data['email'])
            ->first();
        return $user;
    }
    public function passwordchecker(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('id', session()->get('id'))
            ->first();

        if (!$user) {
            return false;
        }
        if (password_verify($data['password'], $user['password'])) {
            return false;
        } else {
            return true;
        }
    }
    public function validateCustomerEmail(string $str, string $fields, array $data)
    {
        $model = new ExternalcontactsModel();
        $user = null;
        if (session()->get('tenant_id') == 1) {
            $condition = array('email_id' => $data['email'], 'status' => 1);
            $user = $model->where($condition)->first();
        } else {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', session()->get('tenant_id'))->first();
            $dbname = "nps_" . $tenant['tenant_name'];
            //new DB creation for Tenant details
            $db = db_connect();
            $db->query('USE ' . $dbname);
            $query = "SELECT * FROM " . $dbname . ".nps_external_contacts WHERE nps_external_contacts.email_id = '" . $data['email'] . "' and nps_external_contacts.status = " . 1;
            $user = $db->query($query)->getFirstRow();
            $db->close();
        }
        if ($user) {
            if (array_key_exists("E_Id", $data)) {
                $arrConv = (array)$user;
                if ($arrConv['id'] == $data['E_Id']) {
                    $user = null;
                }
            }
        }
        if (!$user) {
            return true;
        }
        return false;
    }

    public function validateCustomerContact(string $str, string $fields, array $data)
    {
        $model = new ExternalcontactsModel();
        $user = null;
        $condition = array('contact_details' => $data['contact'], 'status' => 1);
        if (session()->get('tenant_id') == 1) {
            $user = $model->where($condition)->first();
        } else {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', session()->get('tenant_id'))->first();
            $dbname = "nps_" . $tenant['tenant_name'];
            //new DB creation for Tenant details
            $db = db_connect();
            $db->query('USE ' . $dbname);
            $query = "SELECT * FROM " . $dbname . ".nps_external_contacts WHERE nps_external_contacts.contact_details = '" . $data['contact'] . "' and nps_external_contacts.status = " . 1;
            $user = $db->query($query)->getFirstRow();
            $db->close();
        }
        if ($user) {
            if (array_key_exists("E_Id", $data)) {
                $arrConv = (array)$user;
                if ($arrConv['id'] == $data['E_Id']) {
                    $user = null;
                }
            }
        }
        if (!$user) {
            return true;
        }
        return false;
    }

    public function validate_answer(string $str, string $fields, array $data)
    {
        $answerListController = new AnswerlistController();
        //$answerList = $answerListController->AnswerList()[0];
        $answerList = $answerListController->AnswerList1();
        //$defaultAnswerList = $answerListController->DefaultAnswerList();
        $req_answer = str_replace(' ', '', $data['answer_name']);

        foreach ($answerList[0] as $answer) {

            $withoutSpace = str_replace(' ', '', $answer['answer_name']);

            if (strcasecmp($withoutSpace, $req_answer) == 0) {
                return false;
            }
            // $flag= $this->string_compare($data['answer_name'], $answer['answer_name']);
            // return $flag? false : true;
        }
        $a = session()->get("survey_Id");
        if (session()->get("survey_Id") > 0) {
            $tenantAnswerList = $answerListController->TenantAnswerList();
            $index = $data['question_Id'] - 2;
            if (count($answerList[1]) > 0) {
                $answerGroup = $answerList[1][$index];
                foreach ($answerGroup as $answer) {

                    $withoutSpace = str_replace(' ', '', $answer['answer_name']);

                    if (strcasecmp($withoutSpace, $req_answer) == 0) {
                        return false;
                    }
                    // $flag= $this->string_compare($data['answer_name'], $answer['answer_name']);
                    // return $flag? false : true;
                }
            }
        }
    }
    public function string_compare(string $str1, string $str2)
    {
        $withoutSpaceStr1 = str_replace(' ', '', $str1);
        $withoutSpaceStr2 = str_replace(' ', '', $str2);
        if (strcasecmp($withoutSpaceStr1, $withoutSpaceStr2) == 0) {
            return true;
        }
    }

    public function CheckTenant(string $str, string $fields, array $data)
    {
        $flag = !($this->validateTenant($str, $fields, $data));

        return $flag;
    }
    public function CheckActivation(string $str, string $fields, array $data)
    {
        $user = $this->GetUser($data);

        return ($user['status'] == 0) ? false : true;
    }
    public function CheckEmail(string $str, string $fields, array $data)
    {
        $user = $this->GetUser($data);

        return ($user) ? true : false;
    }

    public function ValidateUserName(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $userName = $model->where('username', $data['username'])->first();
        if ($userName) {
            return false;
        }
        return true;
    }

    public function ValidateTagName(string $str, string $fields, array $data)
    {
        $model = new TagModel();
        $tag = $model->where('tag_name', $str)->first();
        if ($tag) {

            if (array_key_exists("E_tag_name", $data)) {
                $arrConv = (array)$tag;
                if ($arrConv['tag_id'] == $data['E_tag_id']) {
                    $tag = null;
                }
            }
        }
        if (!$tag) {
            return true;
        }
        return false;
    }

    public function ValidateSegmentName(string $str, string $fields, array $data)
    {
        $model = new SegmentModel();
        $segment = $model->where('segment_name', $str)->first();
        if ($segment) {

            if (array_key_exists("E_segment_name", $data)) {
                $arrConv = (array)$segment;
                if ($arrConv['segment_id'] == $data['E_segment_id']) {
                    $segment = null;
                }
            }
        }
        if (!$segment) {
            return true;
        }
        return false;
    }

    public function ValidateRecipientList(string $str, string $fields, array $data)
    {
        $toList = json_decode($data["To"]);

        if ((count($toList[0]) > 0) || (count($toList[1])) > 0) {
            return true;
        }
        return false;
    }

    public function ValidateQuestionRating(?string $str, string $fields, array $data)
    {
        if (array_key_exists("q_type", $data)) {

            if ($data["q_type"] == "F") {
                if (array_key_exists("q_rating", $data)) {
                    return true;
                } else return false;
            } else {
                return true;
            }
        }
        return true;
    }
}
