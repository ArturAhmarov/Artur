<html>
<?php
include 'db.php';
if($_GET['task'] == 'add_buyer'){
    ?>
    <form method="post">
        <br>
        <p>Дата визита</p>
        <input type="date" name="date" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer">
            <?
            $query = "CALL get_marketer()";
            $res = mysqli_query($connection,$query);
            while($row = $res->fetch_object()) {
                ?>
                <option><? echo $row->id_marketer ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Номер отдела</p>
        <select name="id_dep">
            <?
            $query = "CALL get_dep()";
            $res = mysqli_query($connection,$query);
            while($row = $res->fetch_object()) {
                ?>
                <option><? echo $row->id_dep ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine">
            <?
            $query = "CALL get_magazine()";
            $res = mysqli_query($connection,$query);
            while($row = $res->fetch_object()) {
                ?>
                <option><? echo $row->id_magazine ?></option>
                <?
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <p> </p>
        <?
        $query = "CALL get_sale()";
        $res = mysqli_query($connection,$query);
        while($row = $res->fetch_object()) {
            $per=$row->id_sale;
        }
        $value=$per+2;
        mysqli_next_result($connection);
        ?>
        <p> </p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if($_POST['add']) {
        $date = $_POST['date'];
        $id_marketer = $_POST['id_marketer'];
        $id_dep = $_POST['id_dep'];
        $id_magazine = $_POST['id_magazine'];

        $sql = "CALL add_buyer (
                        '$date',
                        '$id_marketer',
                        '$id_dep',
                        '$id_magazine'
                        )";
        $add = mysqli_query($connection, $sql);
        $_GET['task'] = 'buyer_list_2';
    }
}
if($_GET['task'] == 'edit_buyer'){
    $id_old=$_GET['id_buyer'];
    if($_POST['upd']) {
        $buyer_date = $_POST['buyer_date'];
        $id_market = $_POST['id_marketer'];
        $id_dep = $_POST['id_dep'];
        $id_magazine = $_POST['id_magazine'];
        $query = "CALL upd_buyer(
        '$id_old','$buyer_date','$id_market','$id_dep','$id_magazine')";
        $res=mysqli_query($connection,$query);
        $_GET['task'] = 'buyer_list_2';
    }
    $query="CALL get_buyer_id($id_old)";
    $res=mysqli_query($connection,$query);
    $row=$res->fetch_object();
    $old_date=$row->date_visit;
    $id_marketer=$row->id_marketer;
    $id_dep=$row->id_dep;
    $id_magazine=$row->id_magazine;
    mysqli_next_result($connection);
    ?>
    <form method="post">
        <br>
        <p>Дата</p>
        <input type = "date" name="buyer_date" value="<? echo $old_date ?>" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $query='CALL get_marketer()';
            $res=mysqli_query($connection,$query);
            while($row=mysqli_fetch_object($res)){
                if($row->id_marketer == $id_marketer){
                    ?>
                    <option selected><?= $row->id_marketer ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_marketer ?></option>
                    <?
                }
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Номер отдела</p>
        <select name="id_dep" required>
            <?
            $query="CALL get_dep()";
            $res=mysqli_query($connection,$query);
            while($row=mysqli_fetch_object($res)){
                if($row->id_dep == $id_dep){
                    ?>
                    <option selected><?= $row->id_dep ?></option>
                    <?
                }
                else {
                    ?>
                    <option><?= $row->id_dep ?></option>
                    <?
                }
            }
            mysqli_next_result($connection);
            ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine" required>
            <?
            $query="CALL get_magazine();";
            $res=mysqli_query($connection,$query);
            while($row=$res->fetch_object()){
                if($row->id_magazine == $id_magazine){
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
if($_GET['task'] == 'del_buyer' ){
    $del_per=$_GET['id_buyer'];
    $query="CALL delete_buyer($del_per)";
    $del=mysqli_query($connection, $query);
    $_GET['task'] = 'buyer_list_2';
}
if($_GET['task'] == 'buyer_list_2'){
    $res = mysqli_query($connection,'CALL get_buyer()');
    ?>
    <H3> Покупатели </H3>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер покупателя</th>
        <th>Дата визита</th>
        <th>Номер продавца</th>
        <th>Номер отдела</th>
        <th>Номер магазина</th>
        <th colspan="2">Настройки</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_buyer;?></td>
            <td><?=$row->date_visit;?></td>
            <td><?=$row->id_marketer;?></td>
            <td><?=$row->id_dep;?></td>
            <td><?=$row->id_magazine;?></td>
        </tr>
        <?
    }
    mysqli_next_result($connection);
    ?>
    </table>
    <?php
}

?>
</html>
