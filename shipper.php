<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_shipper'){
    ?>
    <form method="post">
        <br>
        <p>ФИО поставщика</p>
        <input type="text" name="fio_shipper" required>
        <br>
        <p>Номер телефона</p>
        <input type="number" name="telephone_shipper" required>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']){
        $new_fio_shipper = $_POST['fio_shipper'];
        $new_telephone_shipper = $_POST['telephone_shipper'];
        $query="CALL add_shipper
                (
                '$new_fio_shipper',
                '$new_telephone_shipper'
                )";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'shipper_list_2';
    }
}
if($_GET['task'] == 'edit_shipper'){
    $id_old=$_GET['id_shipper'];
    if($_POST['upd']){
        $new_name=$_POST['old_shipper_name'];
        $new_telephone=$_POST['old_telephone_shipper'];
        $query="CALL upd_shipper($id_old,'$new_name','$new_telephone')";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'shipper_list_2';
    }
    $query="CALL get_shipper_id_upd($id_old)";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $old_name=$row->name_shipper;
    $old_telephone=$row->telephone_shipper;
    mysqli_next_result($connection);
    ?>
    <form method="post">
        <br>
        <p>ФИО владельца</p>
        <input type = "text" name="old_shipper_name" value="<? echo $old_name ?>" required>
        <br>
        <p>Телефон</p>
        <input type = "number" name="old_telephone_shipper" value="<?php echo $old_telephone?>" required>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_shipper')
{
    $del_per=$_GET['id_shipper'];
    $query="CALL del_shipper($del_per)";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'shipper_list';
}
if($_GET['task'] == 'shipper_list_2'){
    $res = mysqli_query($connection,'CALL get_shipper()');
    ?>
    <H3> Поставщики </H3>
    <table class="table table-bordered table-hover table-striped" style="width: 600px;" ">
    <tr>
        <th>Номер поставщика</th>
        <th>ФИО поставщика</th>
        <th>Номер телефона</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_shipper;?></td>
            <td><?=$row->name_shipper;?></td>
            <td><?=$row->telephone_shipper;?></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
?>
</html>

