<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHelper;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\CSATAnswerModel;
use App\Models\CSATQuestionModel;

class CSATQandAController extends BaseController
{
    private $modelHelper;

    public function __construct()
    {
        $this->modelHelper = new ModelHelper();
    }

    public function GetCSATQuestionList()
    {
        $data = [];
        $questionList = null;

        $model = new CSATQuestionModel();

        $dbname = session()->get("db_name");
        $db = $this->modelHelper->ConnectDB($dbname);


        $questionList =  $this->modelHelper->GetAllData($model);

        return $questionList;
    }

    public function GetDefaultQuestionList()
    {
        $data = [];
        $questionList = null;

        $model = new CSATQuestionModel();

        $dbname = "nps_shared";
        $db = $this->modelHelper->ConnectDB($dbname);


        $questionList =  $this->modelHelper->GetAllData($model);

        return $questionList;
    }

    public function GetAllQuestions()
    {
        $defaultQuestionList =  $this->GetDefaultQuestionList();
        $tenantQuestionList =  $this->GetCSATQuestionList();
        $questionList = array_merge($defaultQuestionList, $tenantQuestionList);
        return $questionList;
    }

    public function GetAllQuestionsByGroup()
    {

        $defaultQuestionList =  $this->GetDefaultQuestionList();
        $tenantQuestionList =  $this->GetCSATQuestionList();
        $questionList = $this->GetAllQuestions();

        $followupQuestionList = [];
        $mainQuestionList = [];
        foreach ($questionList as $key => $question) {

            if ($question["type"] == "R") {
                array_push($mainQuestionList, $question);
            } else {
                $arr = [];
                if (array_key_exists($question["rating"], $followupQuestionList)) {
                    $arr = $followupQuestionList[$question["rating"]];
                    array_push($arr, $question);
                    $followupQuestionList[$question["rating"]] = $arr;
                } else {
                    array_push($arr, $question);
                    $followupQuestionList[$question["rating"]] = $arr;
                }
            }
        }
        $result = [$mainQuestionList, $followupQuestionList];
        return $result;
    }
    public function CSATQuestionList()
    {

        $questionList = $this->GetCSATQuestionList();

        return view("questionListCSAT", ["questionList" => $questionList]);
    }
    public function createCSATQuestion()
    {
        $data = [];
        $model = new CSATQuestionModel();

        if ($this->request->getMethod() == 'post') {
            $request = $this->request->getPost();

            $rules = [
                'question' => 'required|min_length[2]|max_length[100]',
                'q_info' => 'required|min_length[2]|max_length[100]',
                'q_type' => 'required',
                'q_rating' => 'ValidateQuestionRating[q_type]'
            ];
            $errors = [
                'question' => [
                    'required' => 'Question is required.',
                ],
                'q_info' => ['required' => 'Please enter description'],
                'q_type' => ['required' => 'Please select quetion type.'],
                'q_rating' => ['ValidateQuestionRating' => 'Please select rating type for this question.'],
            ];

            if (!$this->validate($rules, $errors)) {
                if (isset($request["isAjax"]) && $request["isAjax"] == 1) {
                    $output = $this->validator->getErrors();
                    return json_encode(['success' => false, 'csrf' => csrf_hash(), 'error' => $output]);
                }
                return view('createQuestionCSAT', [
                    "validation" => $this->validator
                ]);
            } else {
                $model = new TenantModel();
                $tenant = $model->where('tenant_name', session()->get('tenant_name'))->first();
                if ($tenant['tenant_id'] > 1) {

                    $model = new CSATQuestionModel();
                    $dbname = session()->get("db_name");
                    $db = $this->modelHelper->ConnectDB($dbname);
                    $userId = session()->get('id');

                    $data = [
                        "question" => $request["question"],
                        "description" => $request["q_info"],
                        "type" => $request["q_type"],
                        "rating" => isset($request["q_rating"]) ? $request["q_rating"] : 0,
                        "created_by" => $userId,
                        "updated_by" => $userId,
                    ];
                    $result = $this->modelHelper->InsertData($model, $data);
                    if ($result) {
                        $output = [
                            "id" => $result,
                            "question" => $data["question"],
                            "rating" => $data["rating"]
                        ];
                    }
                    // $this->tenantInsertQuestion($this->request->getPost(),$tenant,$questionId, $userId);
                }
                if (isset($request["isAjax"]) && $request["isAjax"] == 1) {
                    return json_encode(['success' => true, 'csrf' => csrf_hash(), 'data' => $output]);
                }
                session()->setFlashdata('response', "Question added Successfully");
                return redirect()->to(base_url('csat/questionList'));
            }
        } else {
            return view('createQuestionCSAT');
        }
    }
    public function EditCSATQuestion($question_id)
    {
        $model = new CSATQuestionModel();
        $dbName = session()->get("db_name");
        $this->modelHelper->ConnectDB($dbName);
        if ($this->request->getMethod() == 'get') {
            $condition = ['question_id' => $question_id];

            $question = $this->modelHelper->GetSingleData($model, $condition);
            return view('editQuestionCSAT',  ["question" => $question]);
        } elseif ($this->request->getMethod() == 'post') {
            $rules = [
                'question' => 'required|min_length[2]|max_length[100]',
                'q_info' => 'required|min_length[2]|max_length[100]',
                'q_type' => 'required',
                'q_rating' => 'ValidateQuestionRating[q_type]'
            ];
            $errors = [
                'question' => [
                    'required' => 'Question is required.',
                ],
                'q_info' => ['required' => 'Please enter description'],
                'q_type' => ['required' => 'Please select quetion type.'],
                'q_rating' => ['ValidateQuestionRating' => 'Please select rating type for this question.'],
            ];
            if (!$this->validate($rules, $errors)) {

                return view('editQuestionCSAT', [
                    "validation" => $this->validator
                ]);
            } else {
                $request = $this->request->getPost();
                $tenant = session()->get("tenant_id");
                $userId = session()->get('id');
                if ($tenant > 1) {

                    $data = [
                        "question" => $request["question"],
                        "description" => $request["q_info"],
                        "type" => $request["q_type"],
                        "rating" => isset($request["q_rating"]) ? $request["q_rating"] : 0,
                        "updated_by" => $userId
                    ];

                    $this->modelHelper->UpdateData($model, $question_id, $data);
                }
                session()->setFlashdata('response', "Question updated successfully.");
                return redirect()->to(base_url('csat/questionList'));
            }
        }
    }

    public function DeleteCSATQuestion()
    {
        $request = $this->request->getPost();
        $model = new CSATQuestionModel();
        $dbName = session()->get("db_name");
        $this->modelHelper->ConnectDB($dbName);
        $tenant = session()->get("tenant_id");
        if ($tenant > 1) {
            $this->modelHelper->DeleteData($model, $request["q_id"]);
        }
        session()->setFlashdata('response', "Question deleted successfully.");
        return redirect()->to(base_url('csat/questionList'));
    }

    public function AnswerList()
    {
        $model = new CSATAnswerModel();
        $dbName = session()->get("db_name");
        $db = $this->modelHelper->ConnectDB($dbName);
        $tenant = session()->get("tenant_id");
        $answerList = [];
        if ($tenant > 1) {
            $answerList = $this->modelHelper->GetAllData($model);
        }
        return view("answerListCSAT", ["answerList" => $answerList]);
    }

    public function UpdateEmojiAnswer()
    {
        if ($this->request->getMethod() == "post") {
            $request = $this->request->getFiles();
            $rules = [
                'emoji.*' => 'uploaded[emoji]|ext_in[emoji,png,jpg,svg]|max_size[emoji,20]',
                // 'emoji_1' => 'uploaded[emoji_1]|max_size[emoji_1,2048]|ext_in[emoji_1,png,jpg,svg]',
                // 'emoji_2' => 'uploaded[emoji_2]|max_size[emoji_2,2048]|ext_in[emoji_2,png,jpg,svg]',
                // 'emoji_3' => 'uploaded[emoji_3]|max_size[emoji_3,2048]|ext_in[emoji_3,png,jpg,svg]',
                // 'emoji_4' => 'uploaded[emoji_4]|max_size[emoji_4,2048]|ext_in[emoji_4,png,jpg,svg]',
                // 'emoji_5' => 'uploaded[emoji_5]|max_size[emoji_5,2048]|ext_in[emoji_5,png,jpg,svg]',


            ];
            $errors =
                ["emoji.*" => [

                    "uploaded" => "Please upload a file.",
                    'max_size' => 'Uploaded file size is more than 10kb',
                    'ext_in' => "Uploaded file is not a image file"

                ]];
            $validation = $this->validate($rules, $errors);
            if (!$validation) {
                $output = $this->validator->getErrors();
                echo json_encode(['success' => false, 'csrf' => csrf_hash(), 'error' => $output]);
            } else {
                if ($files = $this->request->getFiles()) {
                    $count = 0;
                    foreach ($files["emoji"] as $key => $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $ext = $file->getExtension();
                            $name = "emoji_" . $key . "." . $ext;

                            $count++;
                            $data[$count] = ["answer_id" => $key, "emoji" => $name];

                            $file->move('../public/images/answers', $name, true);
                        }
                    }
                    if (count($data) > 0) {
                        $model = new CSATAnswerModel();
                        $dbName = session()->get("db_name");
                        $db = $this->modelHelper->ConnectDB($dbName);
                        $model->updateBatch($data, "answer_id");
                    }
                }
                return json_encode(['success' => true, 'csrf' => csrf_hash(), 'url' => base_url("csat/answerList")]);
            }
        }
    }

    public function UpdateTextAnswer()
    {
        if ($this->request->getMethod() == "post") {
            $request = $this->request->getPost();
            $rules = [
                'text.*' => 'required',
                // 'emoji_1' => 'uploaded[emoji_1]|max_size[emoji_1,2048]|ext_in[emoji_1,png,jpg,svg]',
                // 'emoji_2' => 'uploaded[emoji_2]|max_size[emoji_2,2048]|ext_in[emoji_2,png,jpg,svg]',
                // 'emoji_3' => 'uploaded[emoji_3]|max_size[emoji_3,2048]|ext_in[emoji_3,png,jpg,svg]',
                // 'emoji_4' => 'uploaded[emoji_4]|max_size[emoji_4,2048]|ext_in[emoji_4,png,jpg,svg]',
                // 'emoji_5' => 'uploaded[emoji_5]|max_size[emoji_5,2048]|ext_in[emoji_5,png,jpg,svg]',


            ];
            $errors =
                ["text.*" => [

                    "required" => "Please enter text.",

                ]];
            $validation = $this->validate($rules, $errors);
            if (!$validation) {
                $output = $this->validator->getErrors();
                echo json_encode(['success' => false, 'csrf' => csrf_hash(), 'error' => $output]);
            } else {
                $request = $this->request->getPost();
                $count = 0;
                foreach ($request["text"] as $key => $text) {

                    $count++;
                    $data[$count] = ["answer_id" => $key, "text" => $text];
                }
                if (count($data) > 0) {
                    $model = new CSATAnswerModel();
                    $dbName = session()->get("db_name");
                    $db = $this->modelHelper->ConnectDB($dbName);
                    $model->updateBatch($data, "answer_id");
                }
                return json_encode(['success' => true, 'csrf' => csrf_hash(), 'url' => base_url("csat/answerList")]);
            }
        }
    }
}
