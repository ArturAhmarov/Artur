<?php
require_once 'rb\rb.php';

class magazine
{
    const  tablename = 'magazine';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($new_name_mag,$type,$id_owner)
    {
        $el= R::dispense(self::tablename);
        $el->name_magazine = $new_name_mag;
        $el->magazine_type = $type;
        $el->id_owner = $id_owner;
        R::store($el);
    }
    public function update($id,$new_name,$new_magazine_type,$new_id_owner)
    {
        $el = R::load(self::tablename,$id);
        $el->name_magazine = $new_name;
        $el->magazine_type = $new_magazine_type;
        $el->id_owner = $new_id_owner;
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