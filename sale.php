<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_sale'){
    ?>
    <form method="post">
        <br>
        <p>Номер покупателя</p>
        <select name="id_buyer" >
            <?
            $query="SELECT `id_buyer` FROM `buyer` ORDER BY `id_buyer`";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_buyer ?></option>
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
            $query="SELECT `id_marketer` FROM `marketer`";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_marketer ?></option>
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
        $query="INSERT INTO `sale`
                (
                `id_buyer`,
                `date_sale`,
                `id_marketer`
                )
                VALUES
                (
                '$id_buyer',
                '$date',
                '$id_marketer'
                )";
        $res=mysqli_query($connection,$query);
        $_GET['task'] ='sales_list_2';
    }
}
if($_GET['task'] == 'edit_sale'){
    $id_old=$_GET['id_sale'];
    if($_POST['upd']){
        $id_buyer = $_POST['id_buyer'];
        $date = $_POST['date'];
        $id_marketer = $_POST['id_marketer'];
        $query="UPDATE `sale` 
                SET 
                `id_buyer` = '$id_buyer',
                 `date_sale` = '$date',
                 `id_marketer` = '$id_marketer'
                WHERE `sale`.`id_sale` = '$id_old'";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'sales_list_2';
    }
    $query="SELECT * FROM `sale` WHERE `sale`.`id_sale` ='$id_old'";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $id_buyer=$row->id_buyer;
    $date = $row->date_sale;
    $id_marketer = $row->id_marketer;
    ?>
    <form method="post">
        <p>Номер покупателя</p>
        <select name="id_buyer" required>
            <?
            $query="SELECT `id_buyer` FROM `buyer` ORDER BY `id_buyer`";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_buyer == $id_buyer){
                    ?>
                    <option selected><?= $row->id_buyer ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_buyer ?></option>
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
            $query="SELECT `id_marketer` FROM `marketer`";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_marketer == $id_marketer){
                    ?>
                    <option selected><?= $row->id_marketer ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_marketer ?></option>
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
    $query="DELETE FROM `sale` WHERE `sale`.`id_sale` = '$del_per'";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'sales_list';
}
if($_GET['task'] == 'sales_list_2'){
    $res = mysqli_query($connection,'SELECT* FROM sale');
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
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_sale;?></td>
            <td><?=$row->id_buyer;?></td>
            <td><?=$row->date_sale;?></td>
            <td><?=$row->id_marketer;?></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'sale_check' ){
    $buf=$_GET['id_sale'];
    $res = mysqli_query($connection, "SELECT b.id_sale,b.quantity_sale,s.name_product,s.cost FROM sale_product as b LEFT JOIN `product` s ON b.id_product = s.id_product WHERE b.id_sale ='$buf'");
    ?>
    <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
    <tr>
        <th>Номер продажи</th>
        <th>Название товара </th>
        <th>Цена товара </th>
        <th>Количество купленного товара </th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?= $row->id_sale; ?></td>
            <td><?= $row->name_product; ?></td>
            <td><?= $row->cost; ?></td>
            <td><?= $row->quantity_sale; ?></td>
        </tr>
        <?
    }
}

?>
</html>
