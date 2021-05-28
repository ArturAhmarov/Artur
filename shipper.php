<html>
<?php
include 'db.php';
require_once 'src\shipper.php';
$shipper = new shipper();
if($_GET['task'] == 'add_shipper'){
    ?>
    <form method="post">
        <br>
        <p>ФИО поставщика</p>
        <input type="text" name="fio_shipper" required>
        <br>
        <p>Номер телефона</p>
        <input type="number" name="telephone_shipper" required>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']){
        $name= $_POST['fio_shipper'];
        $telephone = $_POST['telephone_shipper'];
        $shipper->add($name,$telephone);
        $_GET['task'] = 'shipper_list';
    }
}
if($_GET['task'] == 'edit_shipper'){
    $id=$_GET['id_shipper'];
    if($_POST['upd']){
        $name=$_POST['old_shipper_name'];
        $telephone=$_POST['old_telephone_shipper'];
        $shipper->update($id,$name,$telephone);
        $_GET['task'] = 'shipper_list';
    }
    $res = $shipper->getid($id);
    ?>
    <form method="post">
        <br>
        <p>ФИО владельца</p>
        <input type = "text" name="old_shipper_name" value="<?=$res[0]['name_shipper'];?>" required>
        <br>
        <p>Телефон</p>
        <input type = "number" name="old_telephone_shipper" value="<?=$res[0]['telephone_shipper']?>" required>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_shipper')
{
    $del_per=$_GET['id_shipper'];
    $shipper->delete($del_per);
    $_GET['task'] = 'shipper_list';
}
?>
</html>

