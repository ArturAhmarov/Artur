<?php
require_once 'rb\rb.php';

class sh
{
    const  tablename = 'storehouse';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($id_product,$quantity,$id_shipper,$order_status)
    {
        $el= R::dispense(self::tablename);
        $el->id_product = $id_product;
        $el->quantity_in_sh = $quantity;
        $el->id_shipper = $id_shipper;
        $el->order_status = $order_status;
        R::store($el);
    }
    public function update($id,$id_product,$quantity,$id_shipper,$order_status)
    {
        $el = R::load(self::tablename,$id);
        $el->id_product = $id_product;
        $el->quantity_in_sh = $quantity;
        $el->id_shipper = $id_shipper;
        $el->order_status = $order_status;
        R::store($el);
    }
    public function delete($id)
    {
        $el = R::load(self::tablename,$id);
        R::trash($el);
    }
    public function read(){
        $table = R::findALl(self::tablename, "ORDER BY `id` ASC");
        return $table;
    }
    public function getid($id){
        $el = R::load(self::tablename,$id);
        $el = $el->export();
        return $el;
    }
}