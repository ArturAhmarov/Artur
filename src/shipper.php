<?php
require_once 'rb\rb.php';

class shipper
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($name,$telephone)
    {
        R::exec( "INSERT INTO `shipper`
                (
                `name_shipper`,
                `telephone_shipper`
                )
                VALUES
                (
                '$name',
                '$telephone'
                )");
    }
    public function update($id,$name,$telephone)
    {
        R::exec( "UPDATE `shipper` 
                SET 
                `name_shipper` = '$name',
                 `telephone_shipper` = '$telephone'
                WHERE `shipper`.`id_shipper` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `shipper` WHERE `shipper`.`id_shipper` = '$id'");
    }
    public function read($tablename){
        $shipper = R::getAll("SELECT *  FROM $tablename");
        return $shipper;
    }
    public function getid($id){
        $shipper = R::getAll("SELECT * FROM `shipper` WHERE `id_shipper` = $id");
        return $shipper;
    }

}