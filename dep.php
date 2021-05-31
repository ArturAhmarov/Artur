<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_dep'){
    ?>
    <form method="post">
        <br>
        <p>Название отдела</p>
        <input type="text" name="name_dep" required>
        <br>
        <p>Этаж</p>
        <input type="number" name="floor" required>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine" required>
            <?
            $query="CALL get_magazine()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                ?>
                <option><?= $row->id_magazine ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']){
        $new_name_dep = $_POST['name_dep'];
        $floor = $_POST['floor'];
        $id_magazine=$_POST['id_magazine'];
        $query="CALL add_dep('$new_name_dep',$floor,$id_magazine)";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'dep_list_2';
    }
}
if($_GET['task'] == 'edit_dep'){
    $id_old=$_GET['id_dep'];
    if($_POST['upd']){
        $new_name=$_POST['old_dep_name'];
        $new_floor=$_POST['old_floor_dep'];
        $new_id_magazine=$_POST['id_magazine'];
        $query="CALL upd_dep($id_old,'$new_name',$new_floor,$new_id_magazine)";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'dep_list_2';
    }
    $query="CALL get_dep_id($id_old)";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $old_name=$row->name_dep;
    $old_floor=$row->floor_dep;
    $old_id_magazine=$row->id_magazine;
    mysqli_next_result($connection);
    ?>
    <form method="post">
        <br>
        <p>Название отдела</p>
        <input type = "text" name="old_dep_name" value="<? echo $old_name ?>" required>
        <br>
        <p>Этаж</p>
        <input type = "number" name="old_floor_dep" value="<?php echo $old_floor?>" required>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine" required>
            <?
            $query="CALL get_magazine()";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_magazine == $old_id_magazine){
                    ?>
                    <option selected><?= $row->id_magazine ?></option>
                    <?
                }
                else {
                ?>
                <option><?= $row->id_magazine ?></option>
                <?
                }
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <p></p>
        <input type = "submit" name="upd" value = Изменить>
    </form>
    <?
}
if($_GET['task'] == 'del_dep')
{
    $del_per=$_GET['id_dep'];
    $query="CALL del_dep($del_per)";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'dep_list';
}
if($_GET['task'] == 'dep_list_2'){
    $res = mysqli_query($connection,'CALL get_dep()');
    ?>
    <H3> Отделы </H3>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер отдела</th>
        <th>Название отдела </th>
        <th>Этаж</th>
        <th>Номер магазина</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_dep;?></td>
            <td><?=$row->name_dep;?></td>
            <td><?=$row->floor_dep;?></td>
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

