<html>
<?php
include 'db.php';
require_once 'src/sh.php';
if($_GET['task'] == 'add_order'){
    ?>
    <form method="post">
        <br>
        <p>Номер товара</p>
        <select name="id_product" required>
            <?
            $res=R::findAll("product");
            foreach($res as $row){
                ?>
                <option><?= $row['id'] ?></option>
                <?
            }
            ?>
        </select>
        <br>
        <p>Количество товара в заказе</p>
        <input type="number" name="quantity_sh" required>
        <br>
        <p>Номер поставщика</p>
        <select name="id_shipper" required>
            <?
            $res=R::findAll("shipper");
            foreach($res as $row){
                ?>
                <option><?= $row['id'] ?></option>
                <?
            }
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
        $sh = new sh();
        $sh->add($id_product,$quantity,$id_shipper,$order_status);
        $_GET['task'] = 'sh_list_2';
    }
}
if($_GET['task'] == 'edit_sh'){
    $id_old=$_GET['id_order'];
    $sh = new sh();
    if($_POST['upd']){
        $id_product = $_POST['id_product'];
        $quantity = $_POST['quantity_sh'];
        $id_shipper = $_POST['id_shipper'];
        $order_status= $_POST['order_status'];
        $sh->update($id_old,$id_product,$quantity,$id_shipper,$order_status);
        $_GET['task'] = 'sh_list_2';
    }
    $row=$sh->getid($id_old);
    $id_product=$row['id_product'];
    $quantity_in_sh=$row['quantity_in_sh'];
    $id_shipper=$row['id_shipper'];
    $order_status = $row['order_status'];
    ?>
    <form method="post">
        <br>
        <p>Номер товара</p>
        <select name="id_product" required>
            <?
            $res=R::findAll("product");
            foreach($res as $row){
                if($row['id'] == $id_product){
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
        <br>
        <p>Количество товара</p>
        <input type = "text" name="quantity_sh" value="<?php echo $quantity_in_sh?>" required>
        <br>
        <p>Номер поставщика</p>
        <select name="id_shipper" required>
            <?
            $res=R::findAll("shipper");
            foreach($res as $row){
                if($row['id'] == $id_shipper){
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
    $sh = new sh();
    $sh->delete($del_per);
    $_GET['task'] = 'sh_list_2';
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
        $row=R::getAll("SELECT `quantity_in_sh`,`id_product`,`order_status`FROM `storehouse` WHERE `id` ='$id_old'");
        $id_tovara = $row[0]['id_product'];
        if($row[0]['order_status'] == 'Есть на складе') {
            if ($_POST['quantity'] < $row[0]['quantity_in_sh']) {
                $new_quantity = $row[0]['quantity_in_sh'] - $_POST['quantity'];
                $query = R::exec("UPDATE `storehouse` 
                SET 
                 `quantity_in_sh`='$new_quantity'
                WHERE `storehouse`.`id` = '$id_old'");
                echo "Товар перемещен в магазин в количестве ", $_POST['quantity'];
            } else {
                echo "Количество не может быть больше чем ", $row[0]['quantity_in_sh'];
            }
        }else{
            echo "Товара нету на складе";
        }
    }
}
if($_GET['task'] == 'sh_list_2'){
    $sh = new sh();
    $res = $sh->read();
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
        foreach ($res as $row) {
            ?>
                <td><?=$row['id'];?></td>
                <td><?=$row['id_product'];?></td>
                <td><?=$row['quantity_in_sh'];?></td>
                <td><?=$row['id_shipper'];?></td>
                <td><?=$row['order_status'];?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?php
}
?>
</html>
