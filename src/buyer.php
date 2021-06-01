<?php
require_once 'rb\rb.php';
class buyer
{
    const  tablename = 'buyer';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($date,$id_marketer,$id_dep,$id_magazine)
    {
        $el= R::dispense(self::tablename);
        $el->date_visit = $date;
        $el->id_marketer = $id_marketer;
        $el->id_dep = $id_dep;
        $el->id_magazine = $id_magazine;
        R::store($el);
    }
    public function update($id,$buyer_date,$id_market,$id_dep,$id_magazine)
    {
        $el = R::load(self::tablename,$id);
        $el->date_visit = $buyer_date;
        $el->id_marketer = $id_market;
        $el->id_dep = $id_dep;
        $el->id_magazine = $id_magazine;
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