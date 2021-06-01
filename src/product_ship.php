<?php
require_once 'rb\rb.php';

class product_ship
{
    const  tablename = 'product_ship';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($id_product,$id_shipper)
    {
        $el= R::getRedBean()->dispense(self::tablename);
        $el->id_product = $id_product;
        $el->id_shipper = $id_shipper;
        R::store($el);
    }
    public function update($id,$id_product,$id_shipper)
    {
        $el = R::getRedBean()->load(self::tablename,$id);
        $el->id_product = $id_product;
        $el->id_shipper = $id_shipper;
        R::store($el);
    }
    public function delete($id)
    {
        $el = R::getRedBean()->load(self::tablename,$id);
        R::trash($el);
    }
    public function read(){
        $table = R::findALl(self::tablename, "ORDER BY `id` ASC");
        return $table;
    }
    public function getid($id){
        $el = R::getRedBean()->load(self::tablename,$id);
        $el = $el->export();
        return $el;
    }

}