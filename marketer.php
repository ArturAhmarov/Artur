<html>
<?php
    include 'db.php';
    require_once 'src/marketer.php';
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
                $marketer = new marketer();
                $res=R::findAll("department" );
                ?>
                <?php
                foreach($res as $row){
                    ?>
                    <option><?=$row['id'];?></option>
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
            $new_name = $_POST['new_marketer_name'];
            $new_age = $_POST['new_marketer_age'];
            $new_gender = $_POST['new_marketer_gender'];
            $new_dep = $_POST['new_marketer_dep_id'];
            $marketer->add($new_name,$new_age,$new_gender,$new_dep);
            $_GET['task'] = 'marketer_list_2';
        }
    }
    if($_GET['task'] == 'del_marketer')
    {
        $del_per=$_GET['id_marketer'];
        $marketer = new marketer();
        $marketer->delete($del_per);
        $_GET['task'] = 'marketer_list';
    }
    if($_GET['task'] == 'edit_marketer'){
        $id_old=$_GET['id_marketer'];
        $marketer = new marketer();
        if($_POST['upd']){
            $new_name=$_POST['old_marketer_name'];
            $new_age=$_POST['old_marketer_age'];
            $new_gender=$_POST['old_marketer_gender'];
            $new_dep=$_POST['old_marketer_dep_id'];
            $marketer->update($id_old,$new_name,$new_age,$new_gender,$new_dep);
            $_GET['task'] = 'marketer_list_2';
        }
        $row = $marketer->getid($id_old);
        $old_name=$row['name_marketer'];
        $old_age=$row['age_marketer'];
        $old_gender=$row['gender'];
        $old_dep=$row['id_dep'];
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
                $res=R::findAll("department" );
                ?>
                <?php
                foreach($res as $row){
                    if($row['id'] == $old_dep){
                        ?>
                        <option selected><?= $row['id']; ?></option>
                        <?
                    }
                    else {
                        ?>
                        <option><?= $row['id']; ?></option>
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
        $marketer = new marketer();
        $res = $marketer->read()
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
            foreach ($res as $row) {
                ?>
                <tr>
                    <td><?=$row['id'];?></td>
                    <td><?=$row['name_marketer'];?></td>
                    <td><?=$row['age_marketer'];?></td>
                    <td><?=$row['gender'];?></td>
                    <td><?=$row['id_dep'];?></td>
                </tr>
                <?
            }
            ?>
        </table>
        <?php
    }
?>
</html>
