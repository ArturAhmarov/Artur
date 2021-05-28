<?php
require_once 'rb\rb.php';

class product_ship
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($id_product,$id_shipper)
    {
        R::exec( "INSERT INTO `product_ship` 
                    ( 
                    `id_product`,
                    `id_shipper`
                    ) 
                    VALUES (
                        '$id_product',
                        '$id_shipper'
                        )");
    }
    public function update($id,$id_product,$id_shipper)
    {
        R::exec( "UPDATE `product_ship` 
                SET 
                `id_product`='$id_product',
                 `id_shipper`='$id_shipper' 
                WHERE `product_ship`.`id` = '$id'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `product_ship` WHERE `product_ship`.`id` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `product_ship` WHERE `id` = $id");
        return $element;
    }

}