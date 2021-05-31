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
            $query="CALL get_buyer()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_buyer ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Дата продажи</p>
        <input type="date" name="date" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $query="CALL get_marketer()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_marketer ?></option>
                <?
            }
            mysqli_next_result($connection);
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
        $query="CALL add_sale($id_buyer,'$date',$id_marketer)";
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
        $query="CALL upd_sale ($id_old,$id_buyer,'$date',$id_marketer)";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'sales_list_2';
    }
    $query="CALL get_sale_id($id_old)";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $id_buyer=$row->id_buyer;
    $date = $row->date_sale;
    $id_marketer = $row->id_marketer;
    mysqli_next_result($connection);
    ?>
    <form method="post">
        <p>Номер покупателя</p>
        <select name="id_buyer" required>
            <?
            $query="CALL get_buyer()";
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
            mysqli_next_result($connection);
            ?>
        </select>
        <p>Дата продажи</p>
        <input type="date" name="date" value="<? echo $date?>">
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $query="CALL get_marketer()";
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
            mysqli_next_result($connection);
            ?>
        </select>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_sale' ){
    $del_per=$_GET['id_sale'];
    $query="CALL del_sale ($del_per)";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'sales_list';
}
if($_GET['task'] == 'sales_list_2'){
    $res = mysqli_query($connection,'CALL get_sale()');
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
    $res = mysqli_query($connection, "CALL sale_check($buf)");
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
