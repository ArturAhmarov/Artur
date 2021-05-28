<?php
require_once 'rb\rb.php';

class dep
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($new_name_dep,$floor,$id_magazine)
    {
        R::exec( "INSERT INTO `department`
                (
                `name_dep`,
                `floor_dep`,
                `id_magazine`
                )
                VALUES
                (
                '$new_name_dep',
                '$floor',
                '$id_magazine'
                )");
    }
    public function update($id,$new_name,$new_floor,$new_id_magazine)
    {
        R::exec( "UPDATE `department` 
                SET 
                `name_dep` = '$new_name',
                 `floor_dep` = '$new_floor',
                 `id_magazine` = '$new_id_magazine'
                WHERE `department`.`id_dep` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `department` WHERE `department`.`id_dep` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `department` WHERE `id_dep` = $id");
        return $element;
    }

}