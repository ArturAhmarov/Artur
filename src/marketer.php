<?php
require_once 'rb\rb.php';

class marketer
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($new_name,$new_age,$new_gender,$new_dep)
    {
        R::exec( "INSERT INTO `marketer` 
                    ( 
                    `name_marketer`,
                    `age_marketer`,
                    `gender`,
                    `id_dep`
                    ) 
                    VALUES (
                        '$new_name',
                        '$new_age',
                        '$new_gender',
                        '$new_dep'
                        )");
    }
    public function update($id,$new_name,$new_age,$new_gender,$new_dep)
    {
        R::exec( "UPDATE `marketer` 
                SET 
                `name_marketer`='$new_name',
                 `age_marketer`='$new_age' , 
                 `gender`= '$new_gender', 
                 `id_dep`= '$new_dep'
                WHERE `marketer`.`id_marketer` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `marketer` WHERE `marketer`.`id_marketer` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `marketer` WHERE `id_marketer` = $id");
        return $element;
    }

}