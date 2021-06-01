<html>
<?php
include 'db.php';
require_once 'src/sale.php';
if($_GET['task'] == 'add_sale'){
    ?>
    <form method="post">
        <br>
        <p>Номер покупателя</p>
        <select name="id_buyer" >
            <?
            $res=R::findAll("buyer");
            foreach($res as $row){
                ?>
                <option><?= $row['id'] ?></option>
                <?
            }
            ?>
        </select>
        <br>
        <p>Дата продажи</p>
        <input type="date" name="date" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $res=R::findAll("marketer");
            foreach($res as $row){
                ?>
                <option><?= $row['id'] ?></option>
                <?
            }
            ?>
        </select>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']){
        $id_buyer = $_POST['id_buyer'];
        $date = $_POST['date'];
        $id_marketer=$_POST['id_marketer'];
        $sale = new sale();
        $sale->add($id_buyer,$date,$id_marketer);
        $_GET['task'] ='sales_list_2';
    }
}
if($_GET['task'] == 'edit_sale'){
    $id_old=$_GET['id_sale'];
    $sale = new sale();
    if($_POST['upd']){
        $id_buyer = $_POST['id_buyer'];
        $date = $_POST['date'];
        $id_marketer = $_POST['id_marketer'];
        $sale->update($id_old,$id_buyer,$date,$id_marketer);
        $_GET['task'] = 'sales_list_2';
    }
    $row=$sale->getid($id_old);
    $id_buyer=$row['id_buyer'];
    $date = $row['date_sale'];
    $id_marketer = $row['id_marketer'];
    ?>
    <form method="post">
        <p>Номер покупателя</p>
        <select name="id_buyer" required>
            <?
            $res=R::findAll("buyer");
            foreach($res as $row){
                if($row['id'] == $id_buyer){
                    ?>
                    <option selected><?= $row['id'] ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row['id'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <p>Дата продажи</p>
        <input type="date" name="date" value="<? echo $date?>">
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $res=R::findAll("marketer");
            foreach($res as $row){
                if($row['id'] == $id_marketer){
                    ?>
                    <option selected><?= $row['id'] ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row['id'] ?></option>
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
if($_GET['task'] == 'del_sale' ){
    $del_per=$_GET['id_sale'];
    $sale = new sale();
    $sale->delete($del_per);
    $_GET['task'] = 'sales_list';
}
if($_GET['task'] == 'sales_list_2'){
    $sale = new sale();
    $res = $sale->read();
    ?>
    <H3> Продажи </H3>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер продажи</th>
        <th>Номер покупателя</th>
        <th>Дата продажи</th>
        <th>Номер продавца</th>
    </tr>
    <?php
    foreach ($res as $row) {
        ?>
        <tr>
            <td><?=$row['id'];?></td>
            <td><?=$row['id_buyer'];?></td>
            <td><?=$row['date_sale'];?></td>
            <td><?=$row['id_marketer'];?></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'sale_check' ){
    $buf=$_GET['id_sale'];
    $res = R::getAll( "SELECT b.id_sale,b.quantity_sale,s.name_product,s.cost FROM sale_product as b LEFT JOIN `product` s ON b.id_product = s.id WHERE b.id_sale ='$buf'");
    ?>
    <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
    <tr>
        <th>Номер продажи</th>
        <th>Название товара </th>
        <th>Цена товара </th>
        <th>Количество купленного товара </th>
    </tr>
    <?php
    foreach ($res as $row) {
        ?>
        <tr>
            <td><?= $row['id_sale']; ?></td>
            <td><?= $row['name_product']; ?></td>
            <td><?= $row['cost']; ?></td>
            <td><?= $row['quantity_sale']; ?></td>
        </tr>
        <?
    }
}

?>
</html>
