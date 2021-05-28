<html>
<?php
include 'db.php';
require_once 'src/buyer.php';
if($_GET['task'] == 'add_buyer'){
    ?>
    <form method="post">
        <br>
        <p>Дата визита</p>
        <input type="date" name="date" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer">
            <?
            $res = R::getAll("SELECT `id_marketer` FROM `marketer`");
            foreach($res as $row) {
                ?>
                <option><? echo $row['id_marketer'] ?></option>
                <?
            }
            ?>
        </select>
        <br>
        <p>Номер отдела</p>
        <select name="id_dep">
            <?
            $res =R::getAll( "SELECT `id_dep` FROM `department`");
            foreach($res as $row) {
                ?>
                <option><? echo $row['id_dep'] ?></option>
                <?
            }
            ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine">
            <?
            $res =R::getAll( "SELECT `id_magazine` FROM `magazine`");
            foreach($res as $row) {
                ?>
                <option><? echo $row['id_magazine'] ?></option>
                <?
            }
            ?>
        </select>
        <p> </p>
        <?
        $res = R::getAll( "SELECT `id_sale` FROM `sale`");
        foreach($res as $row) {
            $per=$row['id_sale'];
        }
        $value=$per+2;
        ?>
        <p> </p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']) {
        $date = $_POST['date'];
        $id_marketer = $_POST['id_marketer'];
        $id_dep = $_POST['id_dep'];
        $id_magazine = $_POST['id_magazine'];
        $buyer=new buyer();
        $buyer->add($date,$id_marketer,$id_dep,$id_magazine);
        $_GET['task'] = 'buyer_list';
    }
}
if($_GET['task'] == 'edit_buyer'){
    $id_old=$_GET['id_buyer'];
    if($_POST['upd']){
        $buyer_date=$_POST['buyer_date'];
        $id_market=$_POST['id_marketer'];
        $id_dep=$_POST['id_dep'];
        $id_magazine = $_POST['id_magazine'];
        $buyer=new buyer();
        $buyer->update($id_old,$buyer_date,$id_market,$id_dep,$id_magazine);
        $_GET['task'] = 'buyer_list';
    }
    $res=R::getAll("SELECT * FROM `buyer` WHERE `buyer`.`id_buyer` ='$id_old'");
    $old_date=$res[0]['date_visit'];
    $id_marketer=$res[0]['id_marketer'];
    $id_dep=$res[0]['id_dep'];
    $id_magazine=$res[0]['id_magazine'];
    ?>
    <form method="post">
        <br>
        <p>Название магазина</p>
        <input type = "date" name="buyer_date" value="<? echo $old_date ?>" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $res=R::getAll("SELECT `id_marketer` FROM `marketer`");
            foreach($res as $row){
                if($row['id_marketer'] == $id_marketer){
                    ?>
                    <option selected><?= $row['id_marketer'] ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row['id_marketer'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <br>
        <p>Номер отдела</p>
        <select name="id_dep" required>
            <?
            $res=R::getAll("SELECT `id_dep` FROM `department`");
            foreach($res as $row){
                if($row['id_dep'] == $id_dep){
                    ?>
                    <option selected><?= $row['id_dep'] ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row['id_dep'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine" required>
            <?
            $res=R::getAll("SELECT `id_magazine` FROM `magazine`");
            foreach($res as $row){
                if($row['id_magazine'] == $id_magazine){
                    ?>
                    <option selected><?= $row['id_magazine'] ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row['id_magazine'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_buyer' ){
    $del_per=$_GET['id_buyer'];
    $buyer = new buyer();
    $buyer->delete($del_per);
    $_GET['task'] = 'buyer_list';
}

?>
</html>
