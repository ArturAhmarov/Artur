<html>
<?php
include 'db.php';
require_once 'src/buyer.php';
require_once 'rb\rb.php';
if ($_GET['task'] == 'add_buyer') {
    ?>
    <form method="post">
        <br>
        <p>Дата визита</p>
        <input type="date" name="date" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer">
            <?
            $res = R::findAll("marketer");
            foreach ($res as $row) {
                ?>
                <option><? echo $row['id'] ?></option>
                <?
            }
            ?>
        </select>
        <br>
        <p>Номер отдела</p>
        <select name="id_dep">
            <?
            $res = R::findAll("department");
            foreach ($res as $row) {
                ?>
                <option><? echo $row['id'] ?></option>
                <?
            }
            ?>
        </select>
        <br>s
        <p>Номер магазина</p>
        <select name="id_magazine">
            <?
            $res = R::findAll("magazine");
            foreach ($res as $row) {
                ?>
                <option><? echo $row['id'] ?></option>
                <?
            }
            ?>
        </select>
        <p></p>
        <input type="submit" name="add" value="Добавить">
    </form>
    <?
    if ($_POST['add']) {
        $date = $_POST['date'];
        $id_marketer = $_POST['id_marketer'];
        $id_dep = $_POST['id_dep'];
        $id_magazine = $_POST['id_magazine'];
        $buyer = new buyer();
        $buyer->add($date, $id_marketer, $id_dep, $id_magazine);
        $_GET['task'] = 'buyer_list';
    }
}
if ($_GET['task'] == 'edit_buyer') {
    $id_old = $_GET['id_buyer'];
    if ($_POST['upd']) {
        $buyer_date = $_POST['buyer_date'];
        $id_market = $_POST['id_marketer'];
        $id_dep = $_POST['id_dep'];
        $id_magazine = $_POST['id_magazine'];
        $buyer = new buyer();
        $buyer->update($id_old, $buyer_date, $id_market, $id_dep, $id_magazine);
        $_GET['task'] = 'buyer_list';
    }
    $res = R::load("buyer", $id_old);
    $res =$res->export();
    $old_date = $res['date_visit'];
    $id_marketer = $res['id_marketer'];
    $id_dep = $res['id_dep'];
    $id_magazine = $res['id_magazine'];
    ?>
    <form method="post">
        <br>
        <p>Название магазина</p>
        <input type="date" name="buyer_date" value="<? echo $old_date ?>" required>
        <br>
        <p>Номер продавца</p>
        <select name="id_marketer" required>
            <?
            $res = R::findAll("marketer");
            foreach ($res as $row) {
                if ($row['id'] == $id_marketer) {
                    ?>
                    <option selected><?= $row['id'] ?></option>
                    <?
                } else {
                    ?>
                    <option><?= $row['id'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <br>
        <p>Номер отдела</p>
        <select name="id_dep" required>
            <?
            $res = R::findAll("department");
            foreach ($res as $row) {
                if ($row['id'] == $id_dep) {
                    ?>
                    <option selected><?= $row['id'] ?></option>
                    <?
                } else {
                    ?>
                    <option><?= $row['id'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <br>
        <p>Номер магазина</p>
        <select name="id_magazine" required>
            <?
            $res = R::findAll("magazine");
            foreach ($res as $row) {
                if ($row['id'] == $id_magazine) {
                    ?>
                    <option selected><?= $row['id'] ?></option>
                    <?
                } else {
                    ?>
                    <option><?= $row['id'] ?></option>
                    <?
                }
            }
            ?>
        </select>
        <p></p>
        <input type="submit" name="upd" value=Изменить>
    </form>
    <?
}
if ($_GET['task'] == 'del_buyer') {
    $del_per = $_GET['id_buyer'];
    $buyer = new buyer();
    $buyer->delete($del_per);
    $_GET['task'] = 'buyer_list';
}

?>
</html>
