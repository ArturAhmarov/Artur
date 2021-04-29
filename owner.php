<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_owner'){
    ?>
    <form method="post">
        <br>
        <p>ФИО владельца</p>
        <input type="text" name="fio_owner" required>
        <br>
        <p>Номер телефона</p>
        <input type="number" name="telephone_owner" required>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']){
        $new_fio_owner = $_POST['fio_owner'];
        $new_telephone_owner = $_POST['telephone_owner'];
        $query="INSERT INTO `owner`
                (
                `name_owner`,
                `telephone_owner`
                )
                VALUES
                (
                '$new_fio_owner',
                '$new_telephone_owner'
                )";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'owner_list_2';
    }
}
if($_GET['task'] == 'edit_owner'){
    $id_old=$_GET['id_owner'];
    if($_POST['upd']){
        $new_name=$_POST['old_owner_name'];
        $new_telephone=$_POST['old_telephone_owner'];
        $query="UPDATE `owner` 
                SET 
                `name_owner`='$new_name',
                 `telephone_owner`='$new_telephone'
                WHERE `owner`.`id_owner` = '$id_old'";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'owner_list_2';
    }
    $query="SELECT * FROM `owner` WHERE `owner`.`id_owner` ='$id_old'";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $old_name=$row->name_owner;
    $old_telephone=$row->telephone_owner;
    ?>
    <form method="post">
        <br>
        <p>ФИО владельца</p>
        <input type = "text" name="old_owner_name" value="<? echo $old_name ?>" required>
        <br>
        <p>Телефон</p>
        <input type = "number" name="old_telephone_owner" value="<?php echo $old_telephone?>" required>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_owner')
{
    $del_per=$_GET['id_owner'];
    $query="DELETE FROM `owner` WHERE `owner`.`id_owner` = '$del_per'";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'owner_list';
}
if($_GET['task'] == 'owner_list_2'){
    $res = mysqli_query($connection,'SELECT* FROM owner');
    ?>
    <H3> Владельцы </H3>
    <table class="table table-bordered table-hover table-striped" style="width: 600px;" ">
    <tr>
        <th>Номер владельца</th>
        <th>ФИО владельца</th>
        <th>Номер телефона</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_owner;?></td>
            <td><?=$row->name_owner;?></td>
            <td><?=$row->telephone_owner;?></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
?>
</html>
