<html>
<?php
include 'db.php';
require_once 'rb/rb.php';
if (!R::testConnection()) {
    R:: setup('mysql:host=127.0.0.1;dbname=kursach', 'mysql', 'mysql');
}
if($_GET['task'] == 'query_designer'){
    ?>
    <style>
        .c {
            border: 1px solid #333; /* Рамка */
            display: inline-block;
            padding: 5px 15px; /* Поля */
            text-decoration: none; /* Убираем подчёркивание */
            color: #000; /* Цвет текста */
        }

        .c:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Тень */
            background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
            color: #a00;
        }
    </style>
    <form method="get">
        <p>Название таблицы</p>
        <select name="table_name">
            <option value="product">Товары</option>
            <option value="buyer">Покупатели</option>
            <option value="sale">Продажи</option>
            <option value="marketer">Продавцы</option>
            <option value="owner">Владельцы</option>
            <option value="shipper">Поставщики</option>
            <option value="department">Отделы</option>
            <option value="magazine">Магазины</option>
        </select>
        <p></p>
        <input type="submit" name="select_table" value="Выбрать">
    </form>
    <?
}
if($_GET['table_name'] == 'product'){
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="product_row">
            <option value="id_product">Номер товара</option>
            <option value="name_product">Наименование товара </option>
            <option value="id_shipper"> Номер поставщика </option>
            <option value="cost">Цена </option>
            <option value="net_cost">Себестоимость  </option>
            <option value="quantity_product">Количество товара  </option>
            <option value="type">Вид</option>
            <option value="id_dep">Номер отдела</option>
            <option value="id_magazine">Номер магазина</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if($_POST['execute']) {
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $product_row = $_POST['product_row'];
        $act = $_POST['act'];
        $res =R::getAll( "SELECT * FROM `$table` WHERE `$table`.`$product_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th>Номер товара</th>
                <th>Наименование товара</th>
                <th>Номер поставщика</th>
                <th>Цена</th>
                <th>Себестоимость</th>
                <th>Количество товара в магазине</th>
                <th>Вид</th>
                <th>Номер отдела</th>
                <th>Номер магазина</th>
            </tr>
            <?php
            foreach ($res as $row) {
                ?>
                <tr>
                    <td><?=$row['id_product'];?></td>
                    <td><?=$row['name_product'];?></td>
                    <td><?=$row['id_shipper'];?></td>
                    <td><?=$row['cost'];?></td>
                    <td><?=$row['net_cost'];?></td>
                    <td><?=$row['quantity_product'];?></td>
                    <td><?=$row['type'];?></td>
                    <td><?=$row['id_dep'];?></td>
                    <td><?=$row['id_magazine'];?></td>
                </tr>
                <?
            }
            ?>
        </table>

        <?
    }
}
if($_GET['table_name'] == 'sale'){
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="sale_row">
            <option value="id_sale">Номер продажи</option>
            <option value="id_buyer">Номер покупателя</option>
            <option value="date_sale">Дата продажи</option>
            <option value="id_marketer">Номер продавца </option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if($_POST['execute']){
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['sale_row'];
        $act = $_POST['act'];
        $res = R::getAll( "SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
            <tr>
                <th>Номер продажи</th>
                <th>Номер покупателя</th>
                <th>Дата продажи</th>
                <th>Номер продавца</th>
            </tr>
            <?php
            foreach ($res as $row) {
                ?>
                <tr>
                    <td><?=$row['id_sale'];?></td>
                    <td><?=$row['id_buyer'];?></td>
                    <td><?=$row['date_sale'];?></td>
                    <td><?=$row['id_marketer'];?></td>
                </tr>
                <?
            }
            ?>
        </table>
        <?
    }
}
if($_GET['table_name'] == 'buyer'){
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="name_row">
            <option value="id_buyer">Номер покупателя</option>
            <option value="date_visit">Дата визита</option>
            <option value="id_marketer">Номер продавца</option>
            <option value="id_dep">Номер отдела</option>
            <option value="id_magazine">Номер магазина</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if($_POST['execute']){
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['name_row'];
        $act = $_POST['act'];
        $res = R::getAll( "SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
        <tr>
            <th>Номер покупателя</th>
            <th>Дата визита</th>
            <th>Номер продавца</th>
            <th>Номер отдела</th>
            <th>Номер магазина</th>
        </tr>
        <?php
        foreach ($res as $row) {
            ?>
            <tr>
                <td><?=$row['id_buyer'];?></td>
                <td><?=$row['date_visit'];?></td>
                <td><?=$row['id_marketer'];?></td>
                <td><?=$row['id_dep'];?></td>
                <td><?=$row['id_magazine'];?></td>
            </tr>
            <?
        }
        ?>
        </table>
        <?
    }
}
if($_GET['table_name'] == 'marketer') {
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="name_row">
            <option value="id_marketer">Номер продавца</option>
            <option value="name_marketer">Имя продавца</option>
            <option value="age_marketer">Возраст</option>
            <option value="gender">Пол</option>
            <option value="id_dep">Номер отдела</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if ($_POST['execute']) {
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['name_row'];
        $act = $_POST['act'];
        $res =R::getAll( "SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
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
                <td><?= $row['id_marketer']; ?></td>
                <td><?= $row['name_marketer']; ?></td>
                <td><?= $row['age_marketer']; ?></td>
                <td><?= $row['gender']; ?></td>
                <td><?= $row['id_dep']; ?></td>
            </tr>
            <?
        }
        ?>
        </table>
        <?
    }
}
if($_GET['table_name'] == 'owner') {
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="name_row">
            <option value="id_owner">Номер владельца</option>
            <option value="name_owner">ФИО владельца</option>
            <option value="telephone_owner">Телефон владельца</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if ($_POST['execute']) {
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['name_row'];
        $act = $_POST['act'];
        $res = R::getAll("SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
        <tr>
            <th>Номер владельца</th>
            <th>ФИО владельца</th>
            <th>Телефон</th>
        </tr>
        <?php
        foreach(res as $row) {
            ?>
            <tr>
                <td><?= $row['id_owner']; ?></td>
                <td><?= $row['name_owner']; ?></td>
                <td><?= $row['telephone_owner']; ?></td>
            </tr>
            <?
        }
        ?>
        </table>
        <?
    }
}
if($_GET['table_name'] == 'shipper') {
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="name_row">
            <option value="id_shipper">Номер поставщика</option>
            <option value="name_shipper">ФИО поставщика</option>
            <option value="telephone_shipper">Телефон поставщика</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if ($_POST['execute']) {
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['name_row'];
        $act = $_POST['act'];
        $res = R::getAll("SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
        <tr>
            <th>Номер поставщика</th>
            <th>ФИО поставщика</th>
            <th>Телефон</th>
        </tr>
        <?php
        foreach ($res as $row) {
            ?>
            <tr>
                <td><?= $row['id_shipper']; ?></td>
                <td><?= $row['name_shipper']; ?></td>
                <td><?= $row['telephone_shipper']; ?></td>
            </tr>
            <?
        }
        ?>
        </table>
        <?
    }
}
if($_GET['table_name'] == 'department') {
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="name_row">
            <option value="id_dep">Номер отдела</option>
            <option value="name_dep">Название отдела</option>
            <option value="floor_dep">Этаж</option>
            <option value="id_magazine">Номер магазина</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if ($_POST['execute']) {
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['name_row'];
        $act = $_POST['act'];
        $res = R::getAll("SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
        <tr>
            <th>Номер отдела</th>
            <th>Название отдела</th>
            <th>Этаж</th>
            <th>Номер магазина</th>
        </tr>
        <?php
        foreach ($res as $row) {
            ?>
            <tr>
                <td><?= $row['id_dep']; ?></td>
                <td><?= $row['name_dep']; ?></td>
                <td><?= $row['floor_dep']; ?></td>
                <td><?= $row['id_magazine']; ?></td>
            </tr>
            <?
        }
        ?>
        </table>
        <?
    }
}
if($_GET['table_name'] == 'magazine') {
    ?>
    <form method="post">
        <p>Название столбца</p>
        <select name="name_row">
            <option value="id_magazine">Номер магазина</option>
            <option value="name_magazine">Название магазина</option>
            <option value="magazine_type">Тип магазина</option>
            <option value="id_owner">Номер владельца</option>
        </select>
        <p></p>
        <p>Выбор действия</p>
        <select name="act">
            <option>></option>
            <option><</option>
            <option>=</option>
        </select>
        <input type="text" name="value" required>
        <p></p>
        <input type="submit" name="execute" value="Выполнить">
    </form>
    <?
    if ($_POST['execute']) {
        $table = $_GET['table_name'];
        $value = $_POST['value'];
        $name_row = $_POST['name_row'];
        $act = $_POST['act'];
        $res = R::getAll("SELECT * FROM `$table` WHERE `$table`.`$name_row` $act $value ");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
        <tr>
            <th>Номер магазина</th>
            <th>Название магазина</th>
            <th>Тип магазина</th>
            <th>Номер владельца</th>
        </tr>
        <?php
        foreach ($res as $row) {
            ?>
            <tr>
                <td><?= $row['id_magazine']; ?></td>
                <td><?= $row['name_magazine']; ?></td>
                <td><?= $row['magazine_type']; ?></td>
                <td><?= $row['id_owner']; ?></td>
            </tr>
            <?
        }
        ?>
        </table>
        <?
    }
}


?>
</html>

