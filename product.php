<html>
<?php
include 'db.php';
require_once 'src/product.php';
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
        $product=new product();
        $res=R::findAll("department");
        ?>
        <?php
        foreach ($res as $row){
            ?>
            <option><?=$row['id'];?></option>
            <?
        }
        ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="new_product_magaizne_id" ">
        <?php
        $res=R::findAll("magazine" );
        ?>
        <?php
        foreach ($res as $row){
            ?>
            <option><?=$row['id'];?></option>
            <?
        }
        ?>
        </select>
        <br>
        <p></p>
        <input type = "submit" name="add" value = Добавить>
    </form>
    <?
    if($_POST['add']) {
        $new_name = $_POST['new_product_name'];
        $new_cost = $_POST['new_product_cost'];
        $new_net_cost = $_POST['new_product_net_cost'];
        $new_quantity=$_POST['new_product_quantity'];
        $new_type=$_POST['new_product_type'];
        $new_dep=$_POST['new_product_dep_id'];
        $new_id_magazine=$_POST['new_product_magaizne_id'];
        $product->add($new_name,$new_cost,$new_net_cost,$new_quantity,$new_type,$new_dep,$new_id_magazine);
        $_GET['task'] = 'product_list_2';
    }
}
if($_GET['task'] == 'del_product')
{
    $del_per=$_GET['id_product'];
    $product = new product();
    $product->delete($del_per);
    $_GET['task'] = 'product_list_2';
}
if($_GET['task']=='edit'){
    $id_old=$_GET['id_product'];
    $product = new product();
    if($_POST['upd']){
        $new_name=$_POST['old_product_name'];
        $new_cost = $_POST['old_product_cost'];
        $new_net_cost = $_POST['old_product_net_cost'];
        $new_quantity=$_POST['old_product_quantity'];
        $new_type=$_POST['old_product_type'];
        $new_dep=$_POST['old_product_dep_id'];
        $new_id_magazine=$_POST['old_product_magaizne_id'];
        $product->update($id_old,$new_name,$new_cost,$new_net_cost,$new_quantity,$new_type,$new_dep,$new_id_magazine);
        $_GET['task'] = 'product_list_2';
    }
    $product = new product();
    $res = $product->getid($id_old);
    $old_name=$res['name_product'];
    $old_cost = $res['cost'];
    $old_net_cost = $res['net_cost'];
    $old_quantity=$res['quantity_product'];
    $old_type=$res['type'];
    $old_dep=$res['id_dep'];
    $old_id_magazine=$res['id_magazine'];
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
        $res=R::findAll("department" );
        ?>
        <?php
        foreach($res as $row){
            if($row['id'] == $old_dep ){
                ?>
                <option selected><?=$row['id'];?></option>
                <?
            }
            else {
                ?>
                <option><?= $row['id']; ?></option>
                <?
            }
        }
        ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="old_product_magaizne_id" ">
        <?php
        $res=R::findAll("magazine" );
        ?>
        <?php
        foreach($res as $row){
            if($row['id'] == $old_id_magazine){
                ?>
                <option selected><?=$row['id'];?></option>
                <?
            }
            else {
                ?>
                <option><?= $row['id']; ?></option>
                <?
            }
        }
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
        $product=new product();
        $res=R::findAll("sale" );
        ?>
        <?php
        foreach ($res as $row){
            ?>
            <option><?=$row['id'];?></option>
            <?
        }
        ?>
        </select>
        <br>
        <p></p>
        <input type="submit" name="sell" value="Продать">
    </form>
    <?
    if($_POST['sell']){
        $id_old=$_GET['id_product'];
        $res=R::load("product",$id_old);
        $res = $res->export();
        if($_POST['quantity'] < $res['quantity_product']){
            $new_quantity=$res['quantity_product']-$_POST['quantity'];
            $res = R::exec( "UPDATE `product` 
                SET 
                 `quantity_product`='$new_quantity'
                WHERE `product`.`id` = '$id_old'");

            $id_sale = $_POST['id_sale'];
            $quantity = $_POST['quantity'];
            $res =R::exec( "INSERT INTO `sale_product` 
                ( 
                `id_sale`,
                `id_product`,
                `quantity_sale`
                ) 
                VALUES (
                    '$id_sale',
                    '$id_old',
                    $quantity                  
                    )");
            echo "Товар продан в количестве ", $_POST['quantity'];
        }
        else{
            echo "Количество не может быть больше чем ", $res['quantity_product'];
        }
    }
}
if($_GET['task'] == 'product_list_2')
{
    $res = R::findAll('product');
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
        foreach ($res as $row) {
            ?>
            <tr>
                <td><?=$row['id'];?></td>
                <td><?=$row['name_product'];?></td>
                <td><?=$row['cost'];?></td>
                <td><?=$row['net_cost'];?></td>
                <td><?=$row['quantity_product'];?></td>
                <td><?=$row['type'];?></td>
                <td><?=$row['id_dep'];?></td>
                <td><?=$row['id_magazine'];?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?php
}

?>
</html>
