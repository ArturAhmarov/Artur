<html>
<?php
include 'db.php';
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
            $query="SELECT `id_owner` FROM `owner`";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_owner ?></option>
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
        $query="INSERT INTO `magazine`
                (
                `name_magazine`,
                `magazine_type`,
                `id_owner`
                )
                VALUES
                (
                '$new_name_mag',
                '$type',
                '$id_owner'
                )";
        $res=mysqli_query($connection,$query);
        $_GET['task'] ='magazine_list_2';
    }
}
if($_GET['task'] == 'edit_magazine'){
    $id_old=$_GET['id_magazine'];
    if($_POST['upd']){
        $new_name=$_POST['magazine_name'];
        $new_magazine_type=$_POST['type_magazine'];
        $new_id_owner=$_POST['id_owner'];
        $query="UPDATE `magazine` 
                SET 
                `name_magazine` = '$new_name',
                 `magazine_type` = '$new_magazine_type',
                 `id_owner` = $new_id_owner
                WHERE `magazine`.`id_magazine` = '$id_old'";
        $res=mysqli_query($connection,$query);
        $_GET['task'] ='magazine_list_2';
    }
    $query="SELECT * FROM `magazine` WHERE `magazine`.`id_magazine` ='$id_old'";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $old_name=$row->name_magazine;
    $old_magazine_type=$row->magazine_type;
    $old_id_owner=$row->id_owner;
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
            $query="SELECT `id_owner` FROM `owner`";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_owner == $old_id_owner){
                    ?>
                    <option selected><?= $row->id_owner ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_owner ?></option>
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
    $query="DELETE FROM `magazine` WHERE `magazine`.`id_magazine` = '$del_per'";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'magazine_list';
}
if($_GET['task'] == 'magazine_list_2'){
    $res = mysqli_query($connection,'SELECT* FROM magazine');
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
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_magazine;?></td>
            <td><?=$row->name_magazine;?></td>
            <td><?=$row->magazine_type;?></td>
            <td><?=$row->id_owner;?></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
?>
</html>

