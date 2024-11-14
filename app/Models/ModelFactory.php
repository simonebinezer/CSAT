<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;
use App\Libraries\EnumsAndConstants\ModelNames;

require_once APPPATH . 'Libraries/EnumsAndConstants/Enums.php';
class ModelFactory
{
    public static function createModel($model)
    {
        switch ($model) {
            case 'User':
                return new UserModel();
            case 'Access':
                return new AccessModel();
            case 'Stock':
                return new StockModel();
            case 'Order':
                return new OrderModel();
            case 'Task':
                return new TaskModel();
            case 'Input':
                return new InputModel();
            case 'Employee':
                return new EmployeeModel();
            case 'TaskDetail':
                return new TaskDetailModel();
            case 'QualityCheck':
                return new QualityCheckModel();
            default:
                throw new Exception("Invalid model type: " . $model);
        }
    }
}
