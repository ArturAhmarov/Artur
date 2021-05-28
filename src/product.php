<?php
require_once 'rb\rb.php';

class product
{
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
        }
    }
    public function add($new_name,$new_cost,$new_net_cost,$new_quantity,$new_type,$new_dep,$new_id_magazine)
    {
        R::exec( "INSERT INTO `product` 
                ( 
                `name_product`,
                `cost`,
                `net_cost`,
                `quantity_product`,
                `type`,`id_dep`,
                `id_magazine`
                ) 
                VALUES (
                    '$new_name',
                    '$new_cost',
                    '$new_net_cost',
                    '$new_quantity',
                    '$new_type',
                    '$new_dep',
                    '$new_id_magazine'
                    )");
    }
    public function update($id_old,$new_name,$new_cost,$new_net_cost,$new_quantity,$new_type,$new_dep,$new_id_magazine)
    {
        R::exec( "UPDATE `product` 
                SET 
                `name_product`='$new_name',
                `cost` = '$new_cost',
                 `net_cost` = '$new_net_cost',
                 `quantity_product`='$new_quantity' , 
                 `type`= '$new_type', 
                 `id_dep`= '$new_dep', 
                 `id_magazine`='$new_id_magazine'
                WHERE `product`.`id_product` = '$id_old'");
    }
    public function delete($id)
    {
        R::exec( "DELETE FROM `product` WHERE `product`.`id_product` = '$id'");
    }
    public function read($tablename){
        $table = R::getAll("SELECT *  FROM $tablename");
        return $table;
    }
    public function getid($id){
        $element = R::getAll("SELECT * FROM `shipper` WHERE `id_shipper` = $id");
        return $element;
    }

}