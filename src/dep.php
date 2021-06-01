<?php
require_once 'rb\rb.php';

class dep
{
    const  tablename = 'department';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($new_name_dep,$floor,$id_magazine)
    {
        $el= R::dispense(self::tablename);
        $el->name_dep = $new_name_dep;
        $el->floor_dep = $floor;
        $el->id_magazine = $id_magazine;
        R::store($el);
    }
    public function update($id,$new_name,$new_floor,$new_id_magazine)
    {
        $el = R::load(self::tablename,$id);
        $el->name_dep = $new_name;
        $el->floor_dep = $new_floor;
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