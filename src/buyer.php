<?php
require_once 'rb\rb.php';

class buyer
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($date,$id_marketer,$id_dep,$id_magazine)
    {
        R::exec( "INSERT INTO `buyer` 
                    ( 
                    `date_visit`,
                    `id_marketer`,
                    `id_dep`,
                    `id_magazine`
                    ) 
                    VALUES (
                        '$date',
                        '$id_marketer',
                        '$id_dep',
                        '$id_magazine'
                        )");
    }
    public function update($id_old,$buyer_date,$id_market,$id_dep,$id_magazine)
    {
        R::exec( "UPDATE `buyer` 
                SET 
                `date_visit` = '$buyer_date',
                 `id_marketer` = '$id_market',
                 `id_dep` = '$id_dep',
                 `id_magazine` = '$id_magazine'
                WHERE `buyer`.`id_buyer` = '$id_old'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `buyer` WHERE `buyer`.`id_buyer` = '$id'");
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