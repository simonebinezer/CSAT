<?php

namespace App\Models;

use CodeIgniter\Model;

class CSATSurveyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'csat_survey_detail';
    protected $primaryKey       = 'survey_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "survey_name", 
        "company_service", 
        "main_question", 
        "question_id",
        "question_id_1",
        "question_id_2",
        "question_id_3",
        "question_id_4",
        "question_id_5",
        "answer_list", 
        "sent_status", 
        "status", 
        "created_by", 
        "updated_by"
    ];

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
