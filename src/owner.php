<?php
require_once 'rb\rb.php';

class owner
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($new_fio_owner,$new_telephone_owner)
    {
        R::exec( "INSERT INTO `owner`
                (
                `name_owner`,
                `telephone_owner`
                )
                VALUES
                (
                '$new_fio_owner',
                '$new_telephone_owner'
                )");
    }
    public function update($id,$new_name,$new_telephone)
    {
        R::exec( "UPDATE `owner` 
                SET 
                `name_owner`='$new_name',
                 `telephone_owner`='$new_telephone'
                WHERE `owner`.`id_owner` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `owner` WHERE `owner`.`id_owner` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `owner` WHERE `id_owner` = $id");
        return $element;
    }

}