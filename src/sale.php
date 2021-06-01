<?php
require_once 'rb\rb.php';

class sale
{
    const  tablename = 'sale';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($id_buyer,$date,$id_marketer)
    {
        $el= R::dispense(self::tablename);
        $el->id_buyer = $id_buyer;
        $el->date_sale = $date;
        $el->id_marketer = $id_marketer;
        R::store($el);
    }
    public function update($id,$id_buyer,$date,$id_marketer)
    {
        $el = R::load(self::tablename,$id);
        $el->id_buyer = $id_buyer;
        $el->date_sale = $date;
        $el->id_marketer = $id_marketer;
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