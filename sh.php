<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_order'){
    ?>
    <form method="post">
        <br>
        <p>Номер товара</p>
        <select name="id_product" required>
            <?
            $query="CALL get_product()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_product ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Количество товара в заказе</p>
        <input type="number" name="quantity_sh" required>
        <br>
        <p>Номер поставщика</p>
        <select name="id_shipper" required>
            <?
            $query="CALL get_shipper()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_shipper ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Статус заказа</p>
        <select name="order_status">
            <option>Есть на складе</option>
            <option>Заказан</option>
        </select>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']){
        $id_product = $_POST['id_product'];
        $quantity = $_POST['quantity_sh'];
        $id_shipper=$_POST['id_shipper'];
        $order_status=$_POST['order_status'];
        $query="CALL add_sh
                (
                '$id_product',
                '$quantity',
                '$id_shipper',
                '$order_status'
                )";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'sh_list_2';
    }
}
if($_GET['task'] == 'edit_sh'){
    $id_old=$_GET['id_order'];
    if($_POST['upd']){
        $id_product = $_POST['id_product'];
        $quantity = $_POST['quantity_sh'];
        $id_shipper = $_POST['id_shipper'];
        $order_status= $_POST['order_status'];
        $query="CALL upd_sh($id_old,$id_product,$quantity,$id_shipper,'$order_status')";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'sh_list_2';
    }
    $query="CALL get_sh_id($id_old)";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $id_product=$row->id_product;
    $quantity_in_sh=$row->quantity_in_sh;
    $id_shipper=$row->id_shipper;
    $order_status = $row->order_status;
    mysqli_next_result($connection);
    ?>
    <form method="post">
        <br>
        <p>Номер товара</p>
        <select name="id_product" required>
            <?
            $query="CALL get_product()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_product == $id_product){
                    ?>
                    <option selected><?= $row->id_product ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_product ?></option>
                    <?
                }
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Количество товара</p>
        <input type = "text" name="quantity_sh" value="<?php echo $quantity_in_sh?>" required>
        <br>
        <p>Номер поставщика</p>
        <select name="id_shipper" required>
            <?
            $query="CALL get_shipper()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_shipper == $id_shipper){
                    ?>
                    <option selected><?= $row->id_shipper ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_shipper ?></option>
                    <?
                }
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Статус заказа</p>
        <select name="order_status">
            <?
            if($order_status == 'Есть на складе'){
                ?>
                <option selected>Есть на складе</option>
                <option>Заказан</option>
                <?
            }else{
                ?>
                <option>Есть на складе</option>
                <option selected>Заказан</option>
                <?
            }
            ?>
        </select>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_sh' ){
    $del_per=$_GET['id_order'];
    $query="CALL del_sh($del_per)";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'sh_list';
}
if($_GET['task']=='carry_product'){
    ?>
    <form method="post">
        <br>
        <p>Введите количество товара</p>
        <input type="number" name="quantity">
        <br>
        <p></p>
        <input type="submit" name="carry" value="Перенести">
    </form>
    <?
    if($_POST['carry']){
        $id_old=$_GET['id_order'];
        $query="CALL carry_product($id_old)";
        $res = mysqli_query($connection,$query);
        $row= $res->fetch_object();
        $id_tovara = $row->id_product;
        if($row->order_status == 'Есть на складе') {
            if ($_POST['quantity'] < $row->quantity_in_sh) {
                $new_quantity = $row->quantity_in_sh - $_POST['quantity'];
                $query = "CALL upd_quantity_sh($id_old,'$new_quantity')";
                $res = mysqli_query($connection, $query);

                echo "Товар перемещен в магазин в количестве ", $_POST['quantity'];
            } else {
                echo "Количество не может быть больше чем ", $row->quantity_in_sh;
            }
        }else{
            echo "Товара нету на складе";
        }
    }
}
if($_GET['task'] == 'sh_list_2'){
    $res = mysqli_query($connection,'CALL get_storehouse()');
    ?>
    <H3> Склад </H3>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>Номер заказа</th>
            <th>Номер товара </th>
            <th>Количество товара в заказе</th>
            <th>Номер поставщика</th>
            <th>Статус заказа</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?=$row->id_order;?></td>
                <td><?=$row->id_product;?></td>
                <td><?=$row->quantity_in_sh;?></td>
                <td><?=$row->id_shipper;?></td>
                <td><?=$row->order_status;?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?php
}
?>
</html>
