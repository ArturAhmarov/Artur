<html>
<?php
include 'db.php';
require_once 'src/magazine.php';
if($_GET['task'] == 'add_magazine'){
    ?>
    <form method="post">
        <br>
        <p>Название магазина</p>
        <input type="text" name="name_magazine" required>
        <br>
        <p>Тип</p>
        <input type="text" name="type" required>
        <br>
        <p>Номер хозяйна</p>
        <select name="id_owner" required>
            <?
            $res=R::findAll("owner");
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
        $new_name_mag = $_POST['name_magazine'];
        $type = $_POST['type'];
        $id_owner=$_POST['id_owner'];
        $magazine = new magazine();
        $magazine->add($new_name_mag,$type,$id_owner);
        $_GET['task'] ='magazine_list_2';
    }
}
if($_GET['task'] == 'edit_magazine'){
    $id_old=$_GET['id_magazine'];
    $magazine = new magazine();
    if($_POST['upd']){
        $new_name=$_POST['magazine_name'];
        $new_magazine_type=$_POST['type_magazine'];
        $new_id_owner=$_POST['id_owner'];
        $magazine->update($id_old,$new_name,$new_magazine_type,$new_id_owner);
        $_GET['task'] ='magazine_list_2';
    }
    $row = $magazine->getid($id_old);
    $old_name=$row['name_magazine'];
    $old_magazine_type=$row['magazine_type'];
    $old_id_owner=$row['id_owner'];
    ?>
    <form method="post">
        <br>
        <p>Название магазина</p>
        <input type = "text" name="magazine_name" value="<? echo $old_name ?>" required>
        <br>
        <p>Тип</p>
        <input type = "text" name="type_magazine" value="<?php echo $old_magazine_type?>" required>
        <br>
        <p>Номер хозяйна</p>
        <select name="id_owner" required>
            <?
            $res=R::findAll('owner');
            foreach($res as $row){
                if($row['id'] == $old_id_owner){
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
if($_GET['task'] == 'del_magazine' ){
    $del_per=$_GET['id_magazine'];
    $magazine = new magazine();
    $magazine->delete($del_per);
    $_GET['task'] = 'magazine_list_2';
}
if($_GET['task'] == 'magazine_list_2'){
    $magazine = new magazine();
    $res = $magazine->read();
    ?>
    <H3> Магазины </H3>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер магазина</th>
        <th>Название магазина </th>
        <th>Тип</th>
        <th>Номер владельца</th>
    </tr>
    <?php
    foreach ($res as $row) {
        ?>
        <tr>
            <td><?=$row['id'];?></td>
            <td><?=$row['name_magazine'];?></td>
            <td><?=$row['magazine_type'];?></td>
            <td><?=$row['id_owner'];?></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
?>
</html>

