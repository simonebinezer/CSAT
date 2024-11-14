<?php

namespace App\Models;

use CodeIgniter\Model;

class CSATQuestionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'csat_question';
    protected $primaryKey       = 'question_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["question", "description", "type", "rating", "created_by", "updated_by"];

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


    public function GetQuestionsUsingWhereIn($key, $values)
    {
        $result = $this->whereIn($key, $values)->findAll();
        return $result;
    }
}
