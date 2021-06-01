<?php
require_once 'rb\rb.php';

class shipper
{
    const  tablename = 'shipper';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($name,$telephone)
    {
        $el= R::dispense(self::tablename);
        $el->name_shipper = $name;
        $el->telephone_shipper = $telephone;
        R::store($el);
    }
    public function update($id,$name,$telephone)
    {
        $el = R::load(self::tablename,$id);
        $el->name_shipper = $name;
        $el->telephone_shipper = $telephone;
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