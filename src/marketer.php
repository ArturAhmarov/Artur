<?php
require_once 'rb\rb.php';

class marketer
{
    const  tablename = 'marketer';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($new_name,$new_age,$new_gender,$new_dep)
    {
        $el= R::dispense(self::tablename);
        $el->name_marketer = $new_name;
        $el->age_marketer = $new_age;
        $el->gender = $new_gender;
        $el->id_dep = $new_dep;
        R::store($el);
    }
    public function update($id,$new_name,$new_age,$new_gender,$new_dep)
    {
        $el = R::load(self::tablename,$id);
        $el->name_marketer = $new_name;
        $el->age_marketer = $new_age;
        $el->gender = $new_gender;
        $el->id_dep = $new_dep;
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