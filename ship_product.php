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
                $res = mysqli_query($connection,'CALL get_product()');
                ?>
                <?php
                while($row=$res->fetch_object()){
                    ?>
                    <option value="<?=$row->id_product;?>"><?=$row->name_product;?></option>
                    <?
                }
                mysqli_next_result($connection);
                ?>
              </select>
              <br>
              <p>Поставщик</p>
              <select name="id_shipper">
                  <?php
                  $res = mysqli_query($connection,'CALL get_shipper()');
                  ?>
                  <?php
                  while($row=$res->fetch_object()){
                      ?>
                      <option value="<?=$row->id_shipper;?>"><?=$row->name_shipper;?></option>
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
            $id_product = mysqli_real_escape_string($connection, $_POST['id_product']);
            $id_shipper = mysqli_real_escape_string($connection, $_POST['id_shipper']);

            $sql = "CALL add_product_ship (
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
        $query="CALL del_product_ship($del_per)";
        $del=mysqli_query($connection, $query);
        $_GET['task'] = 'ship_product';
    }
    if($_GET['task'] == 'edit_ship_product'){
        $id_old=$_GET['id_ship_product'];
        if($_POST['upd']){
            $id_product=$_POST['id_product'];
            $id_shipper=$_POST['id_shipper'];
            $query="CALL upd_product_ship($id_old,$id_product,$id_shipper)";
            $res=mysqli_query($connection,$query);
            $_GET['task'] = 'ship_product';
        }
        $query="CALL get_product_ship_id($id_old)";
        $res=mysqli_query($connection,$query);
        $row=$res->fetch_object();
        $id_product=$row->id_product;
        $id_shipper=$row->id_shipper;
        mysqli_next_result($connection);
        ?>
        <form method="post">
            <br>
            <p>Товар</p>
            <select name="id_product">
                <?php
                $res = mysqli_query($connection,'CALL get_product()');
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
                mysqli_next_result($connection);
                ?>
            </select>
            <br>
            <p>Поставщик</p>
            <select name="id_shipper">
                <?php
                $res = mysqli_query($connection,'CALL get_shipper()');
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
                mysqli_next_result($connection);
                ?>
            </select>
            <br>
            <p></p>
            <input type = "submit" name="upd" value = Изменить>
        </form>
        <?
    }
?>
</html>
