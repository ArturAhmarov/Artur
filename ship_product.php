<html>
<?php
    include 'db.php';
    if($_GET['task'] == 'add_ship_product'){
        ?>
          <form method="post">
              <br>
              <p>Товар</p>
              <select name="id_product">
                <?php
                $res = mysqli_query($connection,'SELECT id_product,name_product FROM product');
                ?>
                <?php
                while($row=$res->fetch_object()){
                    ?>
                    <option value="<?=$row->id_product;?>"><?=$row->name_product;?></option>
                    <?
                }
                ?>
              </select>
              <br>
              <p>Поставщик</p>
              <select name="id_shipper">
                  <?php
                  $res = mysqli_query($connection,'SELECT id_shipper,name_shipper FROM shipper');
                  ?>
                  <?php
                  while($row=$res->fetch_object()){
                      ?>
                      <option value="<?=$row->id_shipper;?>"><?=$row->name_shipper;?></option>
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
            $id_product = mysqli_real_escape_string($connection, $_POST['id_product']);
            $id_shipper = mysqli_real_escape_string($connection, $_POST['id_shipper']);

            $sql = "INSERT INTO `ship_product` 
                    ( 
                    `id_product`,
                    `id_shipper`
                    ) 
                    VALUES (
                        '$id_product',
                        '$id_shipper'
                        )";
            $add = mysqli_query($connection, $sql);
            $_GET['task'] = 'ship_product';
        }
    }
    if($_GET['task'] == 'del_ship_product')
    {
        $del_per=$_GET['id_ship_product'];
        $query="DELETE FROM `ship_product` WHERE `ship_product`.`id` = '$del_per'";
        $del=mysqli_query($connection, $query);
        $_GET['task'] = 'ship_product';
    }
    if($_GET['task'] == 'edit_ship_product'){
        $id_old=$_GET['id_ship_product'];
        if($_POST['upd']){
            $id_product=$_POST['id_product'];
            $id_shipper=$_POST['id_shipper'];
            $query="UPDATE `ship_product` 
                SET 
                `id_product`='$id_product',
                 `id_shipper`='$id_shipper' 
                WHERE `ship_product`.`id` = '$id_old'";
            $res=mysqli_query($connection,$query);
            $_GET['task'] = 'ship_product';
        }
        $query="SELECT * FROM `ship_product` WHERE `ship_product`.`id` ='$id_old'";
        $res=mysqli_query($connection,$query);
        $row=$res->fetch_object();
        $id_product=$row->id_product;
        $id_shipper=$row->id_shipper;
        ?>
        <form method="post">
            <br>
            <p>Товар</p>
            <select name="id_product">
                <?php
                $res = mysqli_query($connection,'SELECT id_product,name_product FROM product');
                ?>
                <?php
                while($row=$res->fetch_object()){
                    if($row->id_product == $id_product ){
                        ?>
                        <option value="<?=$row->id_product;?>" selected><?=$row->name_product;?></option>
                        <?
                    }
                    else{
                        ?>
                        <option value="<?=$row->id_product;?>"><?=$row->name_product;?></option>
                        <?
                    }
                }
                ?>
            </select>
            <br>
            <p>Поставщик</p>
            <select name="id_shipper">
                <?php
                $res = mysqli_query($connection,'SELECT id_shipper,name_shipper FROM shipper');
                ?>
                <?php
                while($row=$res->fetch_object()){
                    if($row->id_shipper == $id_shipper) {
                        ?>
                        <option value="<?=$row->id_shipper;?>" selected><?=$row->name_shipper;?></option>
                        <?
                    }
                    else{
                        ?>
                        <option value="<?=$row->id_shipper;?>"><?=$row->name_shipper;?></option>
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
    if($_GET['task'] == 'marketer_list_2'){
        $res = mysqli_query($connection,'SELECT* FROM marketer');
        ?>
        <H3> Продавцы </H3>
        <table class="table table-bordered table-hover table-striped" style="width:600px;">
            <tr>
                <th>Номер продавца</th>
                <th>Имя продавца</th>
                <th>Возраст</th>
                <th>Пол</th>
                <th>Номер отдела</th>
            </tr>
            <?php
            while ($row = $res->fetch_object()) {
                ?>
                <tr>
                    <td><?=$row->id_marketer;?></td>
                    <td><?=$row->name_marketer;?></td>
                    <td><?=$row->age_marketer;?></td>
                    <td><?=$row->gender;?></td>
                    <td><?=$row->id_dep;?></td>
                </tr>
                <?
            }
            ?>
        </table>
        <?php
    }
?>
</html>
