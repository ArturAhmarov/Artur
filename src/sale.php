<?php
require_once 'rb\rb.php';

class sale
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($id_buyer,$date,$id_marketer)
    {
        R::exec( "INSERT INTO `sale`
                (
                `id_buyer`,
                `date_sale`,
                `id_marketer`
                )
                VALUES
                (
                '$id_buyer',
                '$date',
                '$id_marketer'
                )");
    }
    public function update($id,$id_buyer,$date,$id_marketer)
    {
        R::exec( "UPDATE `sale` 
                SET 
                `id_buyer` = '$id_buyer',
                 `date_sale` = '$date',
                 `id_marketer` = '$id_marketer'
                WHERE `sale`.`id_sale` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `sale` WHERE `sale`.`id_sale` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `sale` WHERE `id_sale` = $id");
        return $element;
    }

}