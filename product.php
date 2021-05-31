<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_product'){
    ?>
    <form method="post">
        <br>
        <p>Имя товара</p>
        <input type = "text" name="new_product_name" required>
        <br>
        <p>Цена</p>
        <input type = "number" name="new_product_cost"  required>
        <br>
        <p>Себестоимость </p>
        <input type = "number" name="new_product_net_cost" required>
        <br>
        <p>Количество</p>
        <input type = "number" name="new_product_quantity" required>
        <br>
        <p>Вид</p>
        <input type = "text" name="new_product_type" required>
        <br>
        <p>Номер отдела</p>
        <select name="new_product_dep_id" ">
        <?php
        $res=mysqli_query($connection,"CALL get_dep()" );
        ?>
        <?php
        while($row=$res->fetch_object()){
            ?>
            <option><?=$row->id_dep;?></option>
            <?
        }
        mysqli_next_result($connection);
        ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="new_product_magaizne_id" ">
        <?php
        $res=mysqli_query($connection,"CALL get_magazine()" );
        ?>
        <?php
        while($row=$res->fetch_object()){
            ?>
            <option><?=$row->id_magazine;?></option>
            <?
        }
        mysqli_next_result($connection);
        ?>
        </select>
        <br>
        <p></p>
        <input type = "submit" name="add" value = Добавить>
    </form>
    <?
    if($_POST['add']) {
        $new_name=mysqli_real_escape_string($connection,$_POST['new_product_name']);
        $new_cost = $_POST['new_product_cost'];
        $new_net_cost = $_POST['new_product_net_cost'];
        $new_quantity=$_POST['new_product_quantity'];
        $new_type=mysqli_real_escape_string($connection,$_POST['new_product_type']);
        $new_dep=$_POST['new_product_dep_id'];
        $new_id_magazine=$_POST['new_product_magaizne_id'];

        $sql = "CALL add_product  (
                    '$new_name',
                    '$new_cost',
                    '$new_net_cost',
                    '$new_quantity',
                    '$new_type',
                    '$new_dep',
                    '$new_id_magazine'
                    )";
        $add = mysqli_query($connection, $sql );
        $_GET['task'] = 'product_list_2';
    }
}
if($_GET['task'] == 'del_product')
{
    $del_per=$_GET['id_product'];
    $query="CALL del_product ($del_per)";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'product_list';
}
if($_GET['task']=='edit'){
    $id_old=$_GET['id_product'];
    if($_POST['upd']){
        $new_name=$_POST['old_product_name'];
        $new_cost = $_POST['old_product_cost'];
        $new_net_cost = $_POST['old_product_net_cost'];
        $new_quantity=$_POST['old_product_quantity'];
        $new_type=$_POST['old_product_type'];
        $new_dep=$_POST['old_product_dep_id'];
        $new_id_magazine=$_POST['old_product_magaizne_id'];
        $query="CALL upd_product ($id_old,'$new_name',$new_cost,$new_net_cost,$new_quantity,'$new_type',$new_dep,$new_id_magazine)";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'product_list_2';
    }
    $query="CALL get_product_id($id_old)";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $old_name=$row->name_product;
    $old_cost = $row->cost;
    $old_net_cost = $row->net_cost;
    $old_quantity=$row->quantity_product;
    $old_type=$row->type;
    $old_dep=$row->id_dep;
    $old_id_magazine=$row->id_magazine;
    mysqli_next_result($connection);
    ?>
    <form method="post">
        <br>
        <p>Имя товара</p>
        <input type = "text" name="old_product_name" value="<?php echo $old_name ?>" required>
        <br>
        <p>Цена</p>
        <input type = "number" name="old_product_cost" value="<?php echo $old_cost ?>" step="0.01" required>
        <br>
        <p>Себестоимость </p>
        <input type = "number" name="old_product_net_cost" value="<?php echo $old_net_cost ?>" step="0.01" required>
        <br>
        <p>Количество</p>
        <input type = "number" name="old_product_quantity" value="<?php echo $old_quantity ?>" required>
        <br>
        <p>Вид</p>
        <input type = "text" name="old_product_type" value="<?php echo $old_type ?>"  required>
        <br>
        <p>Номер отдела</p>
        <select name="old_product_dep_id" ">
        <?php
        $res=mysqli_query($connection,"CALL get_dep()" );
        ?>
        <?php
        while($row=$res->fetch_object()){
            if($row->id_dep == $old_dep ){
                ?>
                <option selected><?=$row->id_dep;?></option>
                <?
            }
            else {
                ?>
                <option><?= $row->id_dep; ?></option>
                <?
            }
        }
        mysqli_next_result($connection);
        ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="old_product_magaizne_id" ">
        <?php
        $res=mysqli_query($connection,"CALL get_magazine()" );
        ?>
        <?php
        while($row=$res->fetch_object()){
            if($row->id_magazine == $old_id_magazine){
                ?>
                <option selected><?=$row->id_magazine;?></option>
                <?
            }
            else {
                ?>
                <option><?= $row->id_magazine; ?></option>
                <?
            }
        }
        mysqli_next_result($connection);
        ?>
        </select>
        <br>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task']=='sell_product'){
    ?>
    <form method="post">
        <br>
        <p>Введите количество товара</p>
        <input type="number" name="quantity">
        <p>Номер продажи</p>
        <select name="id_sale" ">
        <?php
        $res=mysqli_query($connection,"CALL get_sale()" );
        ?>
        <?php
        while($row=$res->fetch_object()){
            ?>
            <option><?=$row->id_sale;?></option>
            <?
        }
        mysqli_next_result($connection);
        ?>
        </select>
        <br>
        <p></p>
        <input type="submit" name="sell" value="Продать">
    </form>
    <?
    if($_POST['sell']){
        $id_old=$_GET['id_product'];
        $query="CALL get_product_id($id_old)";
        $res = mysqli_query($connection,$query);
        $row= $res->fetch_object();
        if($_POST['quantity'] < $row->quantity_product){
            $new_quantity=$row->quantity_product-$_POST['quantity'];
            $query="CALL upd_quantity($id_old,$new_quantity)";
            $res=mysqli_query($connection,$query);

            $id_sale = $_POST['id_sale'];
            $quantity = $_POST['quantity'];
            $sql = "CALL add_sale_product($id_sale,$id_old,$quantity)";
            $res=mysqli_query($connection,$sql);
            mysqli_next_result($connection);
            echo "Товар продан в количестве ", $_POST['quantity'];
        }
        else{
            echo "Количество не может быть больше чем ", $row->quantity_product;
        }
    }
}
if($_GET['task'] == 'product_list_2')
{
    $res = mysqli_query($connection,'CALL get_product()');
    ?>
    <H3> Товары </H3>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>Номер товара</th>
            <th>Наименование товара</th>
            <th>Цена</th>
            <th>Себестоимость</th>
            <th>Количество товара в магазине</th>
            <th>Вид</th>
            <th>Номер отдела</th>
            <th>Номер магазина</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?=$row->id_product;?></td>
                <td><?=$row->name_product;?></td>
                <td><?=$row->cost;?></td>
                <td><?=$row->net_cost;?></td>
                <td><?=$row->quantity_product;?></td>
                <td><?=$row->type;?></td>
                <td><?=$row->id_dep;?></td>
                <td><?=$row->id_magazine;?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?php
}

?>
</html>
