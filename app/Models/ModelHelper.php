<?php

namespace App\Models;

use CodeIgniter\Model;
class ModelHelper
{

    public function ConnectDB(string $dbName){

        $db=db_connect();
        $db->query("USE ".$dbName);

        return $db;
    }
    
    public function GetAllData(Model $model)
    {

        $result =  $model->findAll();

        return $result;
    }

    public function GetSingleData(Model $model, $condition)
    {

        $result =  $model->where($condition)->first();

        return $result;
    }

    public function GetAllDataUsingWhere(Model $model, $condition)
    {

        $result =  $model->where($condition)->findAll();

        return $result;
    }


    public function GetAllDataUsingWhereIn(Model $model, $key, $values)
    {

        $result =  $model->whereIn($key, $values)->findAll();

        return $result;
    }

    public function InsertData(Model $model, $data)
    {
        $insertId = $model->insert($data);

        return $insertId;
    }

    public function UpdateData(Model $model, $id, $data)
    {
        $insertId = $model->update($id, $data);

        return $insertId;
    }

    public function DeleteData(Model $model, $id)
    {
        $result = $model->delete($id);

        return $result;
    }

    public function DeleteDataUsingWhere(Model $model, $condition)
    {
        $result = $model->where($condition)->delete();

        return $result;
    }

    public function GetDataByOrder(Model $model, $orderBy, $direction, $key, $value)
    {

        $result =  $model->whereNotIn($key, $value)->orderBy($orderBy, $direction)->findAll();

        return $result;
    }

    public function GetDataUsingWhereByOrder(Model $model, $orderBy, $direction, $condition)
    {
        $result = $model->where($condition)->orderBy($orderBy, $direction)->findAll();

        return $result;
    }

    public function GetDataUsingLike(Model $model, $condition)
    {

        for ($i = 0; $i < count($condition); $i++) {
            # code...
            $model->like($condition[$i]['key'], $condition[$i]['value'], $condition[$i]['side']);
        }
        $result =  $model->findAll();

        return $result;
    }

    
}
