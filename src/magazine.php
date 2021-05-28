<?php
require_once 'rb\rb.php';

class magazine
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($new_name_mag,$type,$id_owner)
    {
        R::exec( "INSERT INTO `magazine`
                (
                `name_magazine`,
                `magazine_type`,
                `id_owner`
                )
                VALUES
                (
                '$new_name_mag',
                '$type',
                '$id_owner'
                )");
    }
    public function update($id,$new_name,$new_magazine_type,$new_id_owner)
    {
        R::exec( "UPDATE `magazine` 
                SET 
                `name_magazine` = '$new_name',
                 `magazine_type` = '$new_magazine_type',
                 `id_owner` = $new_id_owner
                WHERE `magazine`.`id_magazine` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `magazine` WHERE `magazine`.`id_magazine` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `magazine` WHERE `id_magazine` = $id");
        return $element;
    }

}