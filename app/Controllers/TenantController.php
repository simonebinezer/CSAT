<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class TenantController extends BaseController
{
    public function index()
    {
        $tenantModel = new TenantModel();
        $tenantList = $tenantModel->findAll();
        return view('createTenant', ["tenantList" => $tenantList]);
    }
    public function createtenant()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstname' => 'required|alpha',
                'lastname' => 'required|alpha',
                'username' => 'required|min_length[6]|max_length[50]|ValidateUserName[username]',
                'tenantname' => 'required|min_length[2]|max_length[50]|validateTenant[tenantname]', //CheckTenant[tenantname]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|validateEmail[email]',
                'survey_email' => 'required|min_length[6]|max_length[50]|valid_email',//|validateSurveyEmail[survey_email]',
                'phone_no' => 'required|numeric|exact_length[10]',
                'password' => 'required|min_length[4]|max_length[255]',
                'confirmpassword' => 'required|min_length[4]|max_length[255]|matches[password]',
            ];
            $errors = [
                'username' => [
                    'required' => 'You must choose a username.',
                    'ValidateUserName' => 'User name is already present.'
                ],
                'email' => [
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'validateEmail' => 'A Email Address is already available',
                ],
                'tenantname' => [
                    //'CheckTenant' => 'Tenant name is not present',

                    'validateTenant' => 'Tenant name is not available.'
                ],
                'survey_email' => [
                    'required' => 'This field is required.',
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'validateSurveyEmail' => 'Email Address is already available',
                ],
            ];
            if (!$this->validate($rules, $errors)) {
                $output = $this->validator->getErrors();
                return json_encode(['success' => false, 'csrf' => csrf_hash(), 'error' => $output]);
            } else {
                $postData = $this->request->getPost();
                $userId = $this->AddTenant($postData);

                $encryptedUserId =  encrypt_url_segment($userId);
                $emailstatus = $this->createTemplateForAccountCreation($postData, $encryptedUserId);

                session()->setFlashdata('response', $emailstatus);
                return json_encode(['success' => true, 'csrf' => csrf_hash()]);
            }
        }
    }

    public function createtenantOld()
    {
        $data = [];

        $tenantModel = new TenantModel();
        $tenantList = $tenantModel->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'tenantname' => 'required|min_length[2]|max_length[50]|validateTenant[tenantname]',
                'firstname' => 'required|alpha',
                'lastname' => 'required|alpha',
                'username' => 'required|min_length[6]|max_length[50]',
                //'tenantname' => 'required|min_length[2]|max_length[50]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|validateEmail[email]',
                'survey_email' => 'required|min_length[6]|max_length[50]|valid_email|validateSurveyEmail[survey_email]',
                'phone_no' => 'required|numeric|exact_length[10]',
                'password' => 'required|min_length[4]|max_length[255]',
                'confirmpassword' => 'required|min_length[4]|max_length[255]|matches[password]'
            ];
            $errors = [
                'username' => [
                    'required' => 'You must choose a username.',
                ],
                'email' => [
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'validateEmail' => 'Email Address is already available',
                ],
                'survey_email' => [
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                    'validateSurveyEmail' => 'Email Address is already available',
                ],
                'tenantname' => [
                    'validateTenant' => "Tenant name is already exist",
                ],
            ];
            if (!$this->validate($rules, $errors)) {
                return view('createTenant', [
                    "validation" => $this->validator,
                ]);
            } else {
                $model = new TenantModel();
                $tenant = $model->where('tenant_name', $this->request->getPost('tenantname'))->first();
                if (!$tenant) {
                    $this->insertTenant($this->request->getPost());
                } else {
                    $data = $this->formData($this->request->getPost(), $tenant);
                    $tenantId = $tenant['tenant_id'];
                    $userId = $this->CreateUser($data, $tenantId);
                    $data["id"] = $userId;

                    $this->createUserAndTenantDB($tenantId, $userId);
                }
                $emailstatus = $this->sendmailforReg($this->request->getPost());

                session()->setFlashdata('response', $emailstatus);
                return redirect()->to(base_url('createtenant'));
            }
        }
        return view('createTenant', ["tenantList" => $tenantList]);
    }
    public function sendmailforReg($postData)
    {
        $whitelist = array('127.0.0.1', '::1');
        $mail = new PHPMailer(true);
        $template = view("template/email-template-register", ["postdata" => $postData]);
        $subject = "NPS Customer Registration || New Account Creation";
        try {
            if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {

                $mail->isSMTP();
                // $mail->Host         = 'email-smtp.us-west-2.amazonaws.com'; //smtp.google.com
                // $mail->SMTPAuth     = true;
                // $mail->Username     = 'AKIASKRV7H5JDOJCUGGT';
                // $mail->Password     = 'BAYiFnjSzn1W4zX8+UC+xINscVJXCNY6XbQqTeY5p3V9';
                // $mail->SMTPSecure   = 'tls';
                // $mail->Port         = 587;
                // $mail->Subject      = $subject;
                // $mail->Body         = $template;
                // $mail->setFrom('noreply@hctools.in', 'CI-NPS');
                $mail->Host         = 'smtp.gmail.com'; //smtp.google.com
                $mail->SMTPAuth     = true;
                $mail->Username     = 'hctoolssmtp@gmail.com';
                $mail->Password     = 'iyelinyqlqdsmhro';
                $mail->SMTPSecure   = 'tls';
                $mail->Port         = 587;
                $mail->Subject      = $subject;
                $mail->Body         = $template;

                $mail->setFROM('hctoolssmtp@gmail.com', 'CI-NPS');
                //  $mail->addAddress('jeyprabu@hctools.in');
                $mail->addAddress($postData["email"]);
                $mail->isHTML(true);
                $response = $mail->send();
            } else {
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From: <support@cxanalytix.com>' . "\r\n";

                $response = mail($postData["email"], $subject, $template, $headers);
            }
            if (!$response) {
                return "Something went wrong. Please try again." . $mail->ErrorInfo;
            } else {
                return "Your Account has been created";
            }
        } catch (Exception $e) {
            return "Something went wrong. Please try again." . $mail->ErrorInfo;
        }
    }
    public function insertTenant($postdata)
    {
        $model = new TenantModel();
        $data = [
            "tenant_name" => $postdata['tenantname'],
            "survey_email" => $postdata['survey_email']
        ];
        $model->insertBatch([$data]);
        $db = db_connect();
        $tenantId = $db->insertID();

        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "tenant_id" => $tenantId,
            "email" =>  $postdata['email'],
            //"survey_email" =>  $postdata['survey_email'],
            "phone_no" =>  $postdata['phone_no'],
            "role" => "admin",
            "password" => password_hash($postdata['password'], PASSWORD_DEFAULT),
            "status" => "1"
        ];

        $userId = $this->CreateUser($data, $tenantId);
        $data["id"] = $userId;
        $this->createUserAndTenantDB($tenantId, $data);
    }
    public function AddTenant($postdata)
    {
        $model = new TenantModel();
        $data = [
            "tenant_name" => $postdata['tenantname'],
            "survey_email" => "support@cxanalytix.com", //$postdata['survey_email']
        ];
        $model->insertBatch([$data]);
        $db = db_connect();
        $tenantId = $db->insertID();

        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "tenant_id" => $tenantId,
            "email" =>  $postdata['email'],
            //"survey_email" =>  $postdata['survey_email'],
            "phone_no" =>  $postdata['phone_no'],
            "role" => "admin",
            "password" => password_hash($postdata['password'], PASSWORD_DEFAULT),
            "status" => "0"
        ];
        $userId = $this->CreateUser($data, $tenantId);
        return $userId;
    }

    public function CreateAccount($encryptedUserId)
    {

        $userId = decrypt_url_segment($encryptedUserId);

        $model = new UserModel();

        $user = $model->where("id", $userId)->first();

        if ($user) {
            if ($user["status"] == 0) {
                $data = ["status" => 1];
                $model->update($userId, $data);
                unset($user["created_at"], $user["updated_at"], $user["otp_check"]);

                $user["status"] = 1;
                $this->createUserAndTenantDB($user["tenant_id"], $user);
                session()->setFlashdata('response', "Your account was created. Please login and continue.");
            }
        }
        return redirect()->to(base_url());
    }

    public function createTemplateForAccountCreation($postdata, $userId)
    {
        $whitelist = array('127.0.0.1', '::1');
        $mail = new PHPMailer(true);
        $template = view("template/email-template-account-creation", ["postdata" => $postdata, "userId" => $userId]);
        $subject = "NPS Customer || Create Account";

        try {
            if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {

                $mail->isSMTP();
                $mail->Host         = 'smtp.gmail.com'; //smtp.google.com
                $mail->SMTPAuth     = true;
                $mail->Username     = 'hctoolssmtp@gmail.com';
                $mail->Password     = 'iyelinyqlqdsmhro';
                $mail->SMTPSecure   = 'tls';
                $mail->Port         = 587;
                $mail->Subject      = $subject;
                $mail->Body         = $template;

                $mail->setFrom('hctoolssmtp@gmail.com', 'CI-NPS');

                $mail->addAddress($postdata["email"]);
                $mail->isHTML(true);
                $response = $mail->send();
            } else {
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From: <support@cxanalytix.com>' . "\r\n";
                $response = mail($postdata["email"], $subject, $template, $headers);
            }
            if (!$response) {
                return "Something went wrong. Please try again." . $mail->ErrorInfo;
            } else {
                return "Account creation link has been sent to your mail.";
            }
        } catch (Exception $e) {
            return "Something went wrong. Please try again." . $mail->ErrorInfo;
        }
    }
    public function formData($postdata, $tenantdata)
    {
        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "tenant_id" => $tenantdata['tenant_id'],
            "email" =>  $postdata['email'],
            "phone_no" =>  $postdata['phone_no'],
            "role" => "admin",
            "password" => password_hash($postdata['password'], PASSWORD_DEFAULT),
            "status" => "1"
        ];
        return $data;
    }

    public function CreateUser($data, $tenantdata)
    {
        $model = new UserModel();
        $result = $model->insertBatch([$data]);
        $db = db_connect();
        $userId = $db->insertID();
        return $userId;
    }

    public function createUserAndTenantDB($tenantId, $data)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_id', $tenantId)->first();
        $dbname = "nps_" . $tenant['tenant_name'];

        $this->createnewTenantDB($dbname);
        $db = db_connect();
        $key = array_keys($data);
        $values = array_values($data);
        $new_db_insert_user = "INSERT INTO " . $dbname . ".nps_users ( " . implode(',', $key) . ") VALUES('" . implode("','", $values) . "')";
        $db->query($new_db_insert_user);
    }

    public function createnewTenantDB($dbname)
    {
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('CREATE DATABASE `' . $dbname . "`");
        $db->query('USE `' . $dbname . "`");

        //new Table creation for Tenant Details
        $nps_answer_table = "CREATE TABLE `nps_answers_details` (
            `answer_id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
            `campaign_id` int(11) NOT NULL,
            `answer_name` text NOT NULL,
            `description` text NOT NULL,
            `question_id` ENUM('2','3','4') NOT NULL DEFAULT '2',
            `created_id` int(11) NOT NULL,
            `info_details` varchar(120) NOT NULL,
            `status` enum('0','1') NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_answer_table);

        $autoIncrement = "ALTER TABLE `nps_answers_details`
        MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;";
        $db->query($autoIncrement);

        $nps_campaign_details = "CREATE TABLE `nps_campaign_details` (`id` int(11) NOT NULL,
            `category_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `question_id` varchar(55) NOT NULL,
            `answer_id` varchar(55) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_campaign_details);

        $emailsendlist = "CREATE TABLE `nps_email_send_list` (
            `id` int(11) NOT  NULL AUTO_INCREMENT PRIMARY KEY,
            `survey_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `subject` varchar(120) NOT NULL,
            `email_list` text NOT NULL,
            `message` blob NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($emailsendlist);

        $nps_external_contacts = "CREATE TABLE `nps_external_contacts` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `created_by` int(11) NOT NULL COMMENT 'User_id',
            `name` varchar(120) NOT NULL,
            `firstname` varchar(120) NOT NULL,
            `lastname` varchar(120) NOT NULL,
            `contact_details` text NOT NULL,
            `email_id` varchar(120) NOT NULL,
            `status` enum('1','0') NOT NULL DEFAULT '1',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_external_contacts);

        $nps_login_user_info = "CREATE TABLE `nps_login_user_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
            `logout_time` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_login_user_info);

        $nps_question_details = "CREATE TABLE `nps_question_details` (
            `question_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `question_name` text NOT NULL,
            `description` text NOT NULL,
            `info_details` varchar(120) NOT NULL,
            `other_option` text NOT NULL,
            `user_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_question_details);


        $nps_survey_details = "CREATE TABLE `nps_survey_details` (
            `campaign_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `campaign_name` varchar(120) NOT NULL,
            `sent_status` enum('1','0') NOT NULL DEFAULT '1',
            `placeholder_name` VARCHAR(50) NOT NULL,
            `question_id_1` int(11) NOT NULL,
            `question_id_2` int(11) NOT NULL,
            `answer_id_2` TEXT NOT NULL COMMENT 'comma separated answer Id''s',
            `question_id_3` int(11) NOT NULL,
            `answer_id_3` TEXT NOT NULL COMMENT 'comma separated answer Id''s',
            `question_id_4` int(11) NOT NULL,
            `answer_id_4` TEXT NOT NULL COMMENT 'comma separated answer Id''s',
            `status` enum('1','0') NOT NULL DEFAULT '1',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_survey_details);

        $nps_survey_response = "CREATE TABLE `nps_survey_response` (
            `id` int(11) NOT  NULL AUTO_INCREMENT PRIMARY KEY,
            `campaign_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `email` varchar(120) NOT NULL,
            `question_id` int(11) NOT NULL,
            `answer_id` varchar(55) NOT NULL,
            `question_id2` int(11) NOT NULL,
            `answer_id2` TEXT NOT NULL,
            `mail_status` varchar(120) NOT NULL,
            `ip_details` varchar(120) NOT NULL,
            `location` VARCHAR(50) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_survey_response);

        $nps_users = "CREATE TABLE `nps_users` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `firstname` varchar(120) DEFAULT NULL,
            `lastname` varchar(55) NOT NULL,
            `username` varchar(120) DEFAULT NULL,
            `tenant_id` int(11) NOT NULL,
            `email` varchar(120) NOT NULL,
            `phone_no` varchar(120) NOT NULL,
            `role` enum('admin','user') NOT NULL,
            `password` varchar(240) NOT NULL,
            `logo_update` text NOT NULL,
            `status` enum('1','0') NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_users);

        $nps_segments = "CREATE TABLE `nps_segments` (
            `segment_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `segment_name` varchar(250) NOT NULL UNIQUE KEY,
            `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $db->query($nps_segments);

        $nps_tags = "CREATE TABLE `nps_tags` (`tag_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `tag_name` varchar(250) NOT NULL UNIQUE KEY,
                    `created_by` int(11) NOT NULL,
                    `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $db->query($nps_tags);

        $nps_customer_tag_map = "CREATE TABLE `nps_customer_tag_map` (
            `tag_map_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `tag_id` int(11) NOT NULL,
            `customer_id` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $db->query($nps_customer_tag_map);

        $nps_segment_tag_map = "CREATE TABLE `nps_segment_tag_map` (
            `segment_tag_map_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `tag_id` int(11) NOT NULL,
            `segment_id` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_segment_tag_map);

        $nps_customer_tag_view = "CREATE VIEW `nps_customer_tag_view` AS SELECT `nps_external_contacts`.`id`  `customer_id`,`nps_external_contacts`.`name` AS `name`,
         `nps_external_contacts`.`email_id` AS `email`,
         `nps_external_contacts`.`contact_details` AS `phone_no`,
         IFNULL(group_concat(`nps_tags`.`tag_name` separator ','),'') AS `tag_names`,
         IFNULL(group_concat(`nps_tags`.`tag_id` separator ','),'') AS `tag_id_list`FROM ((`nps_external_contacts` LEFT JOIN `nps_customer_tag_map` ON(`nps_external_contacts`.`id` = `nps_customer_tag_map`.`customer_id`)) LEFT JOIN `nps_tags` ON(`nps_tags`.`tag_id` = `nps_customer_tag_map`.`tag_id`)) WHERE `nps_external_contacts`.`status` = '1' GROUP BY `nps_external_contacts`.`id`,
          `nps_external_contacts`.`name`,`nps_external_contacts`.`email_id`,
          `nps_external_contacts`.`contact_details` ORDER BY `nps_external_contacts`.`id`;";

        $db->query($nps_customer_tag_view);

        $nps_segment_mail_view = "CREATE VIEW `nps_segment_mails_view` AS SELECT `nps_segments`.`segment_id`AS `segment_id`,
        `nps_segments`.`segment_name` AS `segment_name`,count(`nps_external_contacts`.`id`)AS `total_count`,
        group_concat(`nps_external_contacts`.`id` separator ',') AS `customer_id_list`,
          group_concat(`nps_external_contacts`.`email_id` separator ',') AS `customer_mail_list` FROM (((`nps_external_contacts` JOIN `nps_customer_tag_map` ON(`nps_external_contacts`.`id` = `nps_customer_tag_map`.`customer_id`)) JOIN  `nps_segment_tag_map` ON(`nps_customer_tag_map`.`tag_id` = `nps_segment_tag_map`.`tag_id`))JOIN `nps_segments` ON(`nps_segments`.`segment_id` = `nps_segment_tag_map`.`segment_id`)) WHERE `nps_external_contacts`.`status` = 1 GROUP BY `nps_segments`.`segment_id`,
          `nps_segments`.`segment_name`;";

        $db->query($nps_segment_mail_view);

        $nps_segment_tag_view = "CREATE view `nps_segment_tag_view` AS SELECT `nps_segments`.`segment_id` AS `segment_id`,`nps_segments`.`segment_name` AS `segment_name`,
        IFNULL(group_concat(`nps_tags`.`tag_name` separator ','),'') AS `tag_names`,
        IFNULL(group_concat(`nps_tags`.`tag_id` separator ','),'') AS `tag_id_list`  FROM ((`nps_segments` LEFT JOIN `nps_segment_tag_map`  ON(`nps_segments`.`segment_id` = `nps_segment_tag_map`.`segment_id`)) LEFT JOIN `nps_tags` ON(`nps_tags`.`tag_id` = `nps_segment_tag_map`.`tag_id`))  GROUP BY `nps_segments`.`segment_id`,`nps_segments`.`segment_name`  ORDER BY `nps_segments`.`segment_id` DESC;";

        $db->query($nps_segment_tag_view);

        $db->close();
    }
    public function createTenantFront($postdata)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', $postdata['tenantname'])->first();
        if (!$tenant) {
            $model = new TenantModel();
            $data = [
                "tenant_name" => $postdata['tenantname'],
                "database_name" => "nps_" . $postdata['tenantname']
            ];
            $model->insertBatch([$data]);
            $db = db_connect();
            $tenantId = $db->insertID();
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            $db->close();
        }
        $dbname = "nps_" . $tenant['tenant_name'];
        $this->createnewTenantDB($dbname);
        return $tenant;
    }
    public function getUserDetails()
    {
        $model = new UserModel();
        $users = $model->where('tenant_id', session()->get('tenant_id'))->find();

        return view('userpermission', ["users" => $users]);
    }
    public function settingpage()
    {
        $model = new UserModel();
        $userdata = $model->where('email', session()->get('email'))->first();
        $settingData = [
            "u_id" => $userdata['id'],
            "firstname" => $userdata['firstname'],
            "lastname" => $userdata['lastname'],
            "username" => $userdata['username'],
            "logo_img" => $userdata['logo_update'] ? $userdata['logo_update'] : 'images/no_image.png',
            "logo_update" => $userdata['logo_update'],
            "email" => $userdata['email'],
        ];
        return view('admin/settingpage', ["settingdata" => $settingData]);
    }
    public function logoupload()
    {
        $input = $this->validate([
            'formData' => 'uploaded[formData]|max_size[formData,2048]|ext_in[formData,jpg,jpeg,png]'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            $response = ['failed' => $data, 'csrf' => csrf_hash()];
            return $this->response->setJSON($response);
        } else {
            if ($file = $this->request->getFile('formData')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = session()->get('username') . "_" . rand() . "_" . $file->getName();
                    $filepath = 'uploads/' . $newName;
                    $file->move('uploads', $newName);
                    $data = [
                        'img_name' => $file->getClientName(),
                        'file'  => $file->getClientMimeType(),
                        'filepath'  => $filepath
                    ];
                    $response = [
                        'success' => true,
                        'data' => $data,
                        'msg' => "Image successfully uploaded"
                    ];
                }
            }
            return $this->response->setJSON($response);
        }
    }
    public function settingupdate()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstname' => 'required|alpha',
                'lastname' => 'required|alpha',
                'username' => 'required|min_length[6]|max_length[50]',
            ];
            $errors = [
                'username' => [
                    'required' => 'You must choose a username.',
                ],
            ];
            if (!$this->validate($rules, $errors)) {
                return view('admin/settingpage', [
                    "validation" => $this->validator,
                ]);
            } else {
                $updateId = session()->get('id');
                $tenantId = session()->get('tenant_id');
                $this->updateSetting($this->request->getPost(), $updateId);
                if ($tenantId > 1) {
                    $this->tenantUserPasswordUpdate($this->request->getPost(), $tenantId, $updateId);
                }
            }

            session()->setFlashdata('response', "Data updated Successfully");
            return redirect()->to(base_url('settingpage'));
        }
    }
    public function updateSetting($postdata, $updateId)
    {
        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "logo_update" => $postdata['logofile']
        ];
        $model = new UserModel();
        $model->update($updateId, $data);
        $dataSession = [
            'logo_update' => $postdata['logofile'],
        ];
        session()->setFlashdata('logo_update', $postdata['logofile']);
        session()->set($dataSession);
    }
    public function tenantUserPasswordUpdate($postdata, $updateId)
    {
        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "logo_update" => $postdata['logofile']
        ];
        $dbname = "nps_" . session()->get('tenant_name');
        //new DB updation for Tenant details
        $db = db_connect();
        $db->query('USE ' . $dbname);
        $cols = array();
        foreach ($data as $key => $val) {
            $cols[] = "$key = '$val'";
        }
        $new_db_update_user = "UPDATE  " . $dbname . ".`nps_users` SET " . implode(', ', $cols) . " WHERE `nps_users`.`id` = " . $updateId;
        $db->query($new_db_update_user);
    }
}
