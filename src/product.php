<?php
require_once 'rb\rb.php';

class product
{
    const  tablename = 'product';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($new_name,$new_cost,$new_net_cost,$new_quantity,$new_type,$new_dep,$new_id_magazine)
    {
        $el= R::dispense(self::tablename);
        $el->name_product = $new_name;
        $el->cost = $new_cost;
        $el->net_cost = $new_net_cost;
        $el->quantity_product = $new_quantity;
        $el->type = $new_type;
        $el->id_dep = $new_dep;
        $el->id_magazine = $new_id_magazine;
        R::store($el);
    }
    public function update($id,$new_name,$new_cost,$new_net_cost,$new_quantity,$new_type,$new_dep,$new_id_magazine)
    {
        $el = R::load(self::tablename,$id);
        $el->name_product = $new_name;
        $el->cost = $new_cost;
        $el->net_cost = $new_net_cost;
        $el->quantity_product = $new_quantity;
        $el->type = $new_type;
        $el->id_dep = $new_dep;
        $el->id_magazine = $new_id_magazine;
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