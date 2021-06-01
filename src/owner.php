<?php
require_once 'rb\rb.php';

class owner
{
    const  tablename = 'owner';
    function __construct(){
        if (!R::testConnection()) {
            R:: setup('mysql:host=127.0.0.1;dbname=kursach_2', 'mysql', 'mysql');
        }
    }
    public function add($new_fio_owner,$new_telephone_owner)
    {
        $el= R::dispense(self::tablename);
        $el->name_owner = $new_fio_owner;
        $el->telephone_owner = $new_telephone_owner;
        R::store($el);
    }
    public function update($id,$new_name,$new_telephone)
    {
        $el = R::load(self::tablename,$id);
        $el->name_owner = $new_name;
        $el->telephone_owner = $new_telephone;
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