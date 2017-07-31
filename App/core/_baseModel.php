<?php

/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 7/31/17
 * Time: 2:01 PM
 */
class _baseModel
{

    public $con = null;
    public $model = null;
    
    function __construct()
    {
        $this->con = _dbModel::getInstance();

    }



    protected function rawSelect($sql)
    {
        try {
            $stmt = $this->con->prepare($sql);
            $stmt->execute();

            return  $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //insert
    protected function dbInsert($table, $values)
    {
        $fieldnames = array_keys($values);
        $sql = "INSERT INTO $table";
        $fields = '( ' . implode(' ,', $fieldnames) . ' )';
        $bound = '(:' . implode(', :', $fieldnames) . ' )';
        $sql .= $fields . ' VALUES ' . $bound;
        $stmt = $this->con->prepare($sql);
        $stmt->execute($values);
    }

    //update
    protected function dbUpdate($table, $values, $condition)
    {

        $sql = " update $table set ";

        $i = '';
        $fields = '';

        foreach ($values as $key => $value) {
            $fields .= $i;

            $fields .= "{$key} = :{$key}";
            $i = ', ';

        }

        foreach ($condition as $key => $c){
            $fields .= " where {$key} = :{$key}";
        }

        $sql .= $fields;
        $values = array_merge($values, $condition);

        $stmt = $this->con->prepare($sql);
        $stmt->execute($values);
    }

    //delete
    protected function dbDelete($table, $fieldname, $id)
    {
        $sql = "DELETE FROM `$table` WHERE `$fieldname` = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //SELECT COUNT FOR PAGINATION
    protected function SelectCount($where)
    {
        $stmt = $this->con->prepare($where);
        $stmt->execute();
        $rowcount = $stmt->fetch(PDO::FETCH_OBJ);
        return $rowcount->num;
    }
}