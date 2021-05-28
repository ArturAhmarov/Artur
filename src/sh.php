<?php
require_once 'rb\rb.php';

class sh
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($id_product,$quantity,$id_shipper,$order_status)
    {
        R::exec( "INSERT INTO `storehouse`
                (
                `id_product`,
                `quantity_in_sh`,
                `id_shipper`,
                `order_status`
                )
                VALUES
                (
                '$id_product',
                '$quantity',
                '$id_shipper',
                '$order_status'
                )");
    }
    public function update($id,$id_product,$quantity,$id_shipper,$order_status)
    {
        R::exec( "UPDATE `storehouse` 
                SET 
                `id_product` = '$id_product',
                 `quantity_in_sh` = '$quantity',
                 `id_shipper` = '$id_shipper',
                 `order_status` = '$order_status'
                WHERE `storehouse`.`id_order` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `storehouse` WHERE `storehouse`.`id_order` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `storehouse` WHERE `id_order` = $id");
        return $element;
    }

}