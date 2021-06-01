<html>
<?php
include 'db.php';
require_once 'src/dep.php';
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
            $res=R::findAll("magazine");
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
        $new_name_dep = $_POST['name_dep'];
        $floor = $_POST['floor'];
        $id_magazine=$_POST['id_magazine'];
        $dep = new dep();
        $dep->add($new_name_dep,$floor,$id_magazine);
        $_GET['task'] = 'dep_list_2';
    }
}
if($_GET['task'] == 'edit_dep'){
    $id_old=$_GET['id_dep'];
    $dep = new dep();
    if($_POST['upd']){
        $new_name=$_POST['old_dep_name'];
        $new_floor=$_POST['old_floor_dep'];
        $new_id_magazine=$_POST['id_magazine'];
        $dep->update($id_old,$new_name,$new_floor,$new_id_magazine);
        $_GET['task'] = 'dep_list_2';
    }
    $res=$dep->getid($id_old);
    $old_name=$res['name_dep'];
    $old_floor=$res['floor_dep'];
    $old_id_magazine=$res['id_magazine'];
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
            $res=R::findAll("magazine");
            foreach($res as $row){
                if($row['id'] == $old_id_magazine){
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
if($_GET['task'] == 'del_dep')
{
    $del_per=$_GET['id_dep'];
    $dep = new dep();
    $dep->delete($del_per);
    $_GET['task'] = 'dep_list';
}
if($_GET['task'] == 'dep_list_2'){
    $dep = new dep();
    $res = $dep->read();
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
    foreach ($res as $row) {
        ?>
        <tr>
            <td><?=$row['id'];?></td>
            <td><?=$row['name_dep'];?></td>
            <td><?=$row['floor_dep'];?></td>
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

