<html>
<?php
    include 'db.php';
    if($_GET['task'] == 'add_marketer'){
        ?>
          <form method="post">
              <br>
              <p>Имя продавца</p>
              <input type = "text" name="new_marketer_name" required>
              <br>
              <p>Возраст</p>
              <input type = "number" name="new_marketer_age" required>
              <br>
              <p>Пол</p>
              <input type = "text" name="new_marketer_gender" required>
              <br>
              <p>Номер отдела</p>
              <select name="new_marketer_dep_id">
                <?php
                $res=mysqli_query($connection,"SELECT `id_dep` FROM `department`" );
                ?>
                <?php
                while($row=$res->fetch_object()){
                    ?>
                    <option><?=$row->id_dep;?></option>
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
            $new_name = mysqli_real_escape_string($connection, $_POST['new_marketer_name']);
            $new_age = $_POST['new_marketer_age'];
            $new_gender = $_POST['new_marketer_gender'];
            $new_dep = $_POST['new_marketer_dep_id'];

            $sql = "INSERT INTO `marketer` 
                    ( 
                    `name_marketer`,
                    `age_marketer`,
                    `gender`,
                    `id_dep`
                    ) 
                    VALUES (
                        '$new_name',
                        '$new_age',
                        '$new_gender',
                        '$new_dep'
                        )";
            $add = mysqli_query($connection, $sql);
            $_GET['task'] = 'marketer_list_2';
        }
    }
    if($_GET['task'] == 'del_marketer')
    {
        $del_per=$_GET['id_marketer'];
        $query="DELETE FROM `marketer` WHERE `marketer`.`id_marketer` = '$del_per'";
        $del=mysqli_query($connection, $query);
        $_GET['task'] = 'marketer_list';
    }
    if($_GET['task'] == 'edit_marketer'){
        $id_old=$_GET['id_marketer'];
        if($_POST['upd']){
            $new_name=$_POST['old_marketer_name'];
            $new_age=$_POST['old_marketer_age'];
            $new_gender=$_POST['old_marketer_gender'];
            $new_dep=$_POST['old_marketer_dep_id'];
            $query="UPDATE `marketer` 
                SET 
                `name_marketer`='$new_name',
                 `age_marketer`='$new_age' , 
                 `gender`= '$new_gender', 
                 `id_dep`= '$new_dep'
                WHERE `marketer`.`id_marketer` = '$id_old'";
            $res=mysqli_query($connection,$query);
            $_GET['task'] = 'marketer_list_2';
        }
        $query="SELECT * FROM `marketer` WHERE `marketer`.`id_marketer` ='$id_old'";
        $res=mysqli_query($connection,$query);
        $row=$res->fetch_object();
        $old_name=$row->name_marketer;
        $old_age=$row->age_marketer;
        $old_gender=$row->gender;
        $old_dep=$row->id_dep;
        ?>
        <form method="post">
            <br>
            <p>Имя продавца</p>
            <input type = "text" name="old_marketer_name" value="<? echo $old_name ?>" required>
            <br>
            <p>Возраст</p>
            <input type = "number" name="old_marketer_age" value="<?php echo $old_age?>" required>
            <br>
            <p>Пол</p>
            <input type = "text" name="old_marketer_gender" value="<? echo $old_gender ?>" required>
            <br>
            <p>Номер отдела</p>
            <select name="old_marketer_dep_id">
                <?php
                $res=mysqli_query($connection,"SELECT `id_dep` FROM `department`" );
                ?>
                <?php
                while($row=$res->fetch_object()){
                    if($row->id_dep == $old_dep){
                        ?>
                        <option selected><?= $row->id_dep; ?></option>
                        <?
                    }
                    else {
                        ?>
                        <option><?= $row->id_dep; ?></option>
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
