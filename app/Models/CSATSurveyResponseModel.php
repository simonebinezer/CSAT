<?php

namespace App\Models;

use CodeIgniter\Model;

class CSATSurveyResponseModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'csat_survey_response';
    protected $primaryKey       = 'survey_response_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["survey_id", "customer_id", "email", "question_id", "answer", "question_id_2", "answer_2", "question_id_3", "answer_3", "question_id_4", "answer_4", "question_id_5", "answer_5", "question_id_6", "answer_6","ip_address", "location"];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
