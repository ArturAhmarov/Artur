<html>
<?php
    include 'db.php';
    require_once 'src/product_ship.php';
    if($_GET['task'] == 'add_ship_product'){
        ?>
          <form method="post">
              <br>
              <p>Товар</p>
              <select name="id_product">
                <?php
                $product_ship = new product_ship();
                $res = R::findAll('product');
                ?>
                <?php
                foreach($res as $row){
                    ?>
                    <option value="<?=$row['id'];?>"><?=$row['name_product'];?></option>
                    <?
                }
                ?>
              </select>
              <br>
              <p>Поставщик</p>
              <select name="id_shipper">
                  <?php
                  $res = R::findAll('shipper');
                  ?>
                  <?php
                  foreach($res as $row){
                      ?>
                      <option value="<?=$row['id'];?>"><?=$row['name_shipper'];?></option>
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
            $id_product = $_POST['id_product'];
            $id_shipper = $_POST['id_shipper'];
            $product_ship->add($id_product,$id_shipper);
            $_GET['task'] = 'ship_product';
        }
    }
    if($_GET['task'] == 'del_ship_product')
    {
        $del_per=$_GET['id_ship_product'];
        $product_ship = new product_ship();
        $product_ship->delete($del_per);
        $_GET['task'] = 'ship_product';
    }
    if($_GET['task'] == 'edit_ship_product'){
        $id_old=$_GET['id_ship_product'];
        $product_ship = new product_ship();
        if($_POST['upd']){
            $id_product=$_POST['id_product'];
            $id_shipper=$_POST['id_shipper'];
            $product_ship->update($id_old,$id_product,$id_shipper);
            $_GET['task'] = 'ship_product';
        }
        $product_ship = new product_ship();
        $row=$product_ship->getid($id_old);
        $id_product=$row['id_product'];
        $id_shipper=$row['id_shipper'];
        ?>
        <form method="post">
            <br>
            <p>Товар</p>
            <select name="id_product">
                <?php
                $res = R::findAll('product');
                ?>
                <?php
                foreach($res as $row){
                    if($row['id'] == $id_product ){
                        ?>
                        <option value="<?=$row['id'];?>" selected><?=$row['name_product'];?></option>
                        <?
                    }
                    else{
                        ?>
                        <option value="<?=$row['id'];?>"><?=$row['name_product'];?></option>
                        <?
                    }
                }
                ?>
            </select>
            <br>
            <p>Поставщик</p>
            <select name="id_shipper">
                <?php
                $res = R::findAll('shipper');
                ?>
                <?php
                foreach($res as $row){
                    if($row['id'] == $id_shipper) {
                        ?>
                        <option value="<?=$row['id'];?>" selected><?=$row['name_shipper'];?></option>
                        <?
                    }
                    else{
                        ?>
                        <option value="<?=$row['id'];?>"><?=$row['name_shipper'];?></option>
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
?>
</html>
