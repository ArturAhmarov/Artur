<html>
<head>
    <div class="one"><h1>Учетная система магазина</h1></div>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
        <style>
        .menu a {
            padding:10px;
            margin:10px;
        }
    </style>
</head>
<body style="padding:30px;">
<?php
// Объявляем нужные константы
define('DB_HOST', 'localhost');
define('DB_USER', 'mysql');
define('DB_PASSWORD', 'mysql');
define('DB_NAME', 'kursach');
define('DB_TABLE_VERSIONS', 'versions');
define('DB_TABLE_HASH', 'hash');

$connection = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'kursach');
if ($connection == false) {
    die ('Ошибка подключения: ' . mysqli_connect_error());
}

include 'menu.php';
include 'product.php';
include 'marketer.php';
include 'owner.php';
include 'shipper.php';
include 'dep.php';
include 'magazine.php';
include 'buyer.php';
include 'sale.php';
include 'sh.php';
include 'query_designer.php';

// Получаем список файлов для миграций
function getMigrationFiles($connection) {
    // Находим папку с миграциями
    $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
    // Получаем список всех sql-файлов
    $allFiles = glob($sqlFolder . '*.sql');

    $arr_number =preg_replace('~\D+~','', $allFiles);
    $flag = true;
    $j = 1;
    for ($i = 0; $i < count($arr_number); $i++){
        $n = (int)$arr_number[$i];
        if($j != $n){
            $flag = false;
        }
        $j++;
    }
    if($flag == false){
        echo "Ошибка в названии файла!";
        exit();
    }


    // Проверяем, есть ли таблица versions
    // Так как versions создается первой, то это равносильно тому, что база не пустая
    $query = sprintf('show tables from `%s` like "%s"', DB_NAME, DB_TABLE_VERSIONS);
    $data = $connection->query($query);
    $firstMigration = !$data->num_rows;

    // Первая миграция, возвращаем все файлы из папки sql
    if ($firstMigration) {
        foreach($allFiles as $file){
            $hashname = hash_file('md5', $file);
            $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_HASH, $hashname);
            // Выполняем запрос
            $connection->query($query);
        }
        return $allFiles;
    }
    $arr_hash = '';
    foreach($allFiles as $file){
        $hash = hash_file('md5', $file);
        $arr_hash = ''.$arr_hash.' '.$hash.'';
    }
    $arr_hash = explode(" ", $arr_hash);

    // Выбираем из таблицы versions все названия файлов
    $query = sprintf('select `name` from `%s`', DB_TABLE_HASH);
    $data = $connection->query($query)->fetch_all(MYSQLI_ASSOC);
    $i = 1;
    foreach ($data as $row) {
        if($row['name'] != $arr_hash[$i]){
            echo 'Ошибка в данных файла';
            print( $arr_hash[$i]);
            exit();
        }
        $i++;
    }
    // Ищем уже существующие миграции
    $versionsFiles = array();
    // Выбираем из таблицы versions все названия файлов
    $query = sprintf('select `name` from `%s`', DB_TABLE_VERSIONS);
    $data = $connection->query($query)->fetch_all(MYSQLI_ASSOC);
    // Загоняем названия в массив $versionsFiles
    // Не забываем добавлять полный путь к файлу
    foreach ($data as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }

    // Возвращаем файлы, которых еще нет в таблице versions
    return array_diff($allFiles, $versionsFiles);
}

// Накатываем миграцию файла
function migrate($connection, $file) {
    // Формируем команду выполнения mysql-запроса из внешнего файла
    $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', DB_USER, DB_PASSWORD, DB_HOST, DB_NAME, $file);
    // Выполняем shell-скрипт
    shell_exec($command);

    // Вытаскиваем имя файла, отбросив путь
    $baseName = basename($file);
    // Формируем запрос для добавления миграции в таблицу versions
    $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $baseName);
    // Выполняем запрос
    $connection->query($query);
}


if($_GET['task'] == 'migration') {


    // Получаем список файлов для миграций за исключением тех, которые уже есть в таблице versions
    $files = getMigrationFiles($connection);

    // Проверяем, есть ли новые миграции
    if (empty($files)) {
        echo 'Ваша база данных в актуальном состоянии.';
    } else {
        echo 'Начинаем миграцию...<br><br>';

        // Накатываем миграцию для каждого файла
        foreach ($files as $file) {
            migrate($connection, $file);
            // Выводим название выполненного файла
            echo basename($file) . '<br>';
        }

        echo '<br>Миграция завершена.';
    }
}




function link_bar($page, $pages_count)
{
    for ($j = 1; $j <= $pages_count; $j++)
    {
// Вывод ссылки
        if ($j == $page) {
            echo ' <a style="color: #808000;" ><b>'.$j.'</b></a> ';
        } else {
            echo ' <a style="color: #808000;" href='.$_SERVER['php_self'].'?task=product_list&page='.$j.'>'.$j.'</a> ';
        }
// Выводим разделитель после ссылки, кроме последней
// например, вставить "|" между ссылками
        if ($j != $pages_count) echo ' ';
    }
    return true;
} // Конец функции

if($_GET['task'] == 'product_list')
{
    $perpage = 2;
    if (empty(@$_GET['page']) || ($_GET['page'] <= 0)) {
        $page = 1;
    } else {
        $page = (int) $_GET['page']; // Считывание текущей страницы
    }
    $result = mysqli_query($connection,'SELECT* FROM product');
    $count = mysqli_num_rows($result);
    $pages_count = ceil($count / $perpage);
    if ($page > $pages_count) $page = $pages_count;
    $start_pos = ($page - 1) * $perpage;
    link_bar($page, $pages_count);
    $res= mysqli_query($connection,'SELECT* FROM product limit '.$start_pos.', '.$perpage);
    ?>
    <H3> Товары </H3>
    <a href="?task=add_product" class="c">Добавить товар</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th>Номер товара</th>
            <th>Наименование товара</th>
            <th>Цена</th>
            <th>Себестоимость</th>
            <th>Количество товара в магазине</th>
            <th>Вид</th>
            <th>Номер отдела</th>
            <th>Номер магазина</th>
            <th colspan="3">Настройки</th>
        </tr>
        <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_product;?></td>
            <td><?=$row->name_product;?></td>
            <td><?=$row->cost;?></td>
            <td><?=$row->net_cost;?></td>
            <td><?=$row->quantity_product;?></td>
            <td><?=$row->type;?></td>
            <td><?=$row->id_dep;?></td>
            <td><?=$row->id_magazine;?></td>

            <td><a href="?task=edit&id_product=<?=$row->id_product;?>">Изменить</a></td>
            <td><a href="?task=del_product&id_product=<?=$row->id_product;?>">Удалить</a></td>
            <td><a href="?task=sell_product&id_product=<?=$row->id_product;?>">Продать</a></td>
        </tr>
        <?
    }
    ?>
    </table>
<?php
}
if($_GET['task'] == 'marketer_list'){
    $res = mysqli_query($connection,'SELECT* FROM marketer');
    ?>
    <H3> Продавцы </H3>
    <a href="?task=add_marketer" class="c">Добавить продавца</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped" style="width:600px;">
        <tr>
            <th>Номер продавца</th>
            <th>Имя продавца</th>
            <th>Возраст</th>
            <th>Пол</th>
            <th>Зарплата</th>
            <th>Номер отдела</th>
            <th colspan="2">Настройки</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?=$row->id_marketer;?></td>
                <td><?=$row->name_marketer;?></td>
                <td><?=$row->age_marketer;?></td>
                <td><?=$row->gender;?></td>
                <td><?=$row->salary_marketer;?></td>
                <td><?=$row->id_dep;?></td>

                <td><a href="?task=edit_marketer&id_marketer=<?=$row->id_marketer;?>">Изменить</a></td>
                <td><a href="?task=del_marketer&id_marketer=<?=$row->id_marketer;?>">Удалить</a></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?php
}
if($_GET['task'] == 'buyer_list'){
    $res = mysqli_query($connection,'SELECT* FROM buyer');
    ?>
    <H3> Покупатели </H3>
    <a href="?task=add_buyer" class="c">Добавить покупателя</a>
    <p></p>
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
            <td><a href="?task=edit_buyer&id_buyer=<?=$row->id_buyer;?>">Изменить</a></td>
            <td><a href="?task=del_buyer&id_buyer=<?=$row->id_buyer;?>">Удалить</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'owner_list'){
    $res = mysqli_query($connection,'SELECT* FROM owner');
    ?>
    <H3> Владельцы </H3>
    <a href="?task=add_owner" class="c">Добавить владельца</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped" style="width: 600px;" ">
    <tr>
        <th>Номер владельца</th>
        <th>ФИО владельца</th>
        <th>Номер телефона</th>
        <th colspan="2">Настройка</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_owner;?></td>
            <td><?=$row->name_owner;?></td>
            <td><?=$row->telephone_owner;?></td>

            <td><a href="?task=edit_owner&id_owner=<?=$row->id_owner;?>">Изменить</a></td>
            <td><a href="?task=del_owner&id_owner=<?=$row->id_owner;?>">Удалить</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'shipper_list'){
    $res = mysqli_query($connection,'SELECT* FROM shipper');
    ?>
    <H3> Поставщики </H3>
    <a href="?task=add_shipper" class="c">Добавить поставщика</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped" style="width: 600px;" ">
    <tr>
        <th>Номер поставщика</th>
        <th>ФИО поставщика</th>
        <th>Номер телефона</th>
        <th colspan="2">Настройка</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_shipper;?></td>
            <td><?=$row->name_shipper;?></td>
            <td><?=$row->telephone_shipper;?></td>

            <td><a href="?task=edit_shipper&id_shipper=<?=$row->id_shipper;?>">Изменить</a></td>
            <td><a href="?task=del_shipper&id_shipper=<?=$row->id_shipper;?>">Удалить</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'sales_list'){
    $res = mysqli_query($connection,'SELECT* FROM sale');
    ?>
    <H3> Продажи </H3>
    <a href="?task=add_sale" class="c">Добавить продажу</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер продажи</th>
        <th>Номер покупателя</th>
        <th>Дата продажи</th>
        <th>Номер продавца</th>
        <th colspan="2">Настройки</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><a href="?task=sale_check&id_sale=<?=$row->id_sale;?>"><?=$row->id_sale;?></td></a>
            <td><?=$row->id_buyer;?></td>
            <td><?=$row->date_sale;?></td>
            <td><?=$row->id_marketer;?></td>
            <td><a href="?task=edit_sale&id_sale=<?=$row->id_sale;?>">Изменить</a></td>
            <td><a href="?task=del_sale&id_sale=<?=$row->id_sale;?>">Удалить</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'dep_list'){
    $res = mysqli_query($connection,'SELECT* FROM department');
    ?>
    <H3> Отделы </H3>
    <a href="?task=add_dep" class="c">Добавить отдел</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер отдела</th>
        <th>Название отдела </th>
        <th>Этаж</th>
        <th>Номер магазина</th>
        <th colspan="2">Настройка</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_dep;?></td>
            <td><?=$row->name_dep;?></td>
            <td><?=$row->floor_dep;?></td>
            <td><?=$row->id_magazine;?></td>

            <td><a href="?task=edit_dep&id_dep=<?=$row->id_dep;?>">Изменить</a></td>
            <td><a href="?task=del_dep&id_dep=<?=$row->id_dep;?>">Удалить</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'magazine_list'){
    $res = mysqli_query($connection,'SELECT* FROM magazine');
    ?>
    <H3> Магазины </H3>
    <a href="?task=add_magazine" class="c">Добавить магазин</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped" style="width: 1000px;"">
    <tr>
        <th>Номер магазина</th>
        <th>Название магазина </th>
        <th>Тип</th>
        <th>Номер владельца</th>
        <th colspan="2">Настройка</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_magazine;?></td>
            <td><?=$row->name_magazine;?></td>
            <td><?=$row->magazine_type;?></td>
            <td><?=$row->id_owner;?></td>

            <td><a href="?task=edit_magazine&id_magazine=<?=$row->id_magazine;?>">Изменить</a></td>
            <td><a href="?task=del_magazine&id_magazine=<?=$row->id_magazine;?>">Удалить</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}
if($_GET['task'] == 'sh_list'){
    $res = mysqli_query($connection,'SELECT* FROM storehouse');
    ?>
    <H3> Склад </H3>
    <a href="?task=add_order" class="c">Добавить заказ</a>
    <p></p>
    <table class="table table-bordered table-hover table-striped">
    <tr>
        <th>Номер заказа</th>
        <th>Номер товара </th>
        <th>Количество товара в заказе</th>
        <th>Номер поставщика</th>
        <th>Статус заказа</th>
        <th colspan="3">Настройка</th>
    </tr>
    <?php
    while ($row = $res->fetch_object()) {
        ?>
        <tr>
            <td><?=$row->id_order;?></td>
            <td><?=$row->id_product;?></td>
            <td><?=$row->quantity_in_sh;?></td>
            <td><?=$row->id_shipper;?></td>
            <td><?=$row->order_status;?></td>

            <td><a href="?task=edit_sh&id_order=<?=$row->id_order;?>">Изменить</a></td>
            <td><a href="?task=del_sh&id_order=<?=$row->id_order;?>">Удалить</a></td>
            <td><a href="?task=carry_product&id_order=<?=$row->id_order;?>">Перенести товар в магазин</a></td>
        </tr>
        <?
    }
    ?>
    </table>
    <?php
}

if($_GET['task'] == 'request_list'){
    ?>
    <div class="query">
        <a href="?task=query_designer">Конструктор запросов</a>
        <br>
        <p></p>
        <a href="?task=request_1">Поставщики товаров</a>
        <br>
        <p></p>
        <a href="?task=request_2">Cписок товаров в продаже</a>
        <br>
        <p></p>
        <a href="?task=request_3"> Количество продаж товара</a>
        <br>
        <p></p>
        <a href="?task=request_4">Количество покупателей по дате </a>
        <br>
        <p></p>
        <a href="?task=request_5">Покупатели купившие введенный товар</a>
        <br>
        <p></p>
        <a href="?task=request_6">Вывод цены и количества любого товара</a>
        <br>
        <p></p>
        <a href="?task=request_7">Товары определенного вида</a>
        <br>
        <p></p>
        <a href="?task=request_8">Посмотреть продавцов на определенном этаже</a>
        <br>
        <p></p>
        <a href="?task=request_9">Получить сведение о заказе на складе</a>
    </div>
    <?php
}
if($_GET['task'] == 'request_1'){
    ?>
    <form method="post">
        <H4>Введите номер товар для поиска поставщиков</H4>
        <input type="number" name="text_request">
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']&& $_POST['text_request'] != " ") {
        $buf=$_POST['text_request'];
        $res = mysqli_query($connection, "SELECT p.id_shipper,s.name_shipper FROM storehouse as p LEFT JOIN `shipper` s ON p.id_shipper = s.id_shipper WHERE p.id_product = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Номер поставщика</th>
            <th>ФИО поставщика</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_shipper; ?></td>
                <td><?= $row->name_shipper; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_2'){
    ?>
    <form method="post">
        <H4>Введите номер продажи для вывода купленных товаров</H4>
        <input type="text" name="text_request">
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']&& $_POST['text_request'] != " ") {
        $buf=$_POST['text_request'];
        $res = mysqli_query($connection, "SELECT b.id_sale,b.quantity_sale,s.name_product,s.cost FROM sale_product as b LEFT JOIN `product` s ON b.id_product = s.id_product WHERE b.id_sale ='$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Номер продажи</th>
            <th>Название товара </th>
            <th>Цена товара </th>
            <th>Количество купленного товара </th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_sale; ?></td>
                <td><?= $row->name_product; ?></td>
                <td><?= $row->cost; ?></td>
                <td><?= $row->quantity_sale; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_3'){
    ?>
    <form method="post">
        <H4>Введите номер товара у которого нужно посчитать количество продаж</H4>
        <input type="number" name="text_request">
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']&& $_POST['text_request'] != " ") {
        $buf = $_POST['text_request'];
        $res = mysqli_query($connection, "SELECT COUNT(*) as `count`, name_product
                                                FROM `sale_product` AS s LEFT JOIN product p ON s.id_product = p.id_product 
                                                WHERE s.id_product = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Количество продаж</th>
            <th>Название товара </th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {

            ?>
            <tr>
                <td><?= $row->count; ?></td>
                <td><?= $row->name_product; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_4'){
    ?>
    <form method="post">
        <H4>Введите дату для вывода количества покупателей</H4>
        <input type="date" name="text_request">
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']&& $_POST['text_request'] != " ") {
        $buf=$_POST['text_request'];
        $res = mysqli_query($connection, "SELECT * FROM `buyer` WHERE date_visit = '$buf'");
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
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_buyer; ?></td>
                <td><?= $row->date_visit; ?></td>
                <td><?= $row->id_marketer; ?></td>
                <td><?= $row->id_dep; ?></td>
                <td><?= $row->id_magazine; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_5'){
    ?>
    <form method="post">
        <H4>Введите номер товар для поиска покупателей</H4>
        <input type="number" name="text_request">
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']&& $_POST['text_request'] != " ") {
        $buf=$_POST['text_request'];
        $res = mysqli_query($connection, "SELECT p.id_sale,s.id_buyer FROM sale_product as p LEFT JOIN `sale` s ON p.id_sale = s.id_sale WHERE p.id_product = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Номер продажи</th>
            <th>Номер покупателя</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_sale; ?></td>
                <td><?= $row->id_buyer; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_6') {
    ?>
    <form method="post">
        <H4>Введите номер товар для вывода его цены и количества в магазине</H4>
        <input type="number" name="text_request">
        <input type="submit" name="submit" value="Выполнить запрос">
    </form>
    <?php
    if ($_POST['submit'] && $_POST['text_request'] != " ") {
        $buf = $_POST['text_request'];
        $res = mysqli_query($connection, "SELECT id_product,name_product,cost,quantity_product FROM product WHERE id_product = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Номер товара</th>
            <th>Название товара</th>
            <th>Цена</th>
            <th>Количество</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_product; ?></td>
                <td><?= $row->name_product; ?></td>
                <td><?= $row->cost; ?></td>
                <td><?= $row->quantity_product; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_7') {
    ?>
    <form method="post">
        <H4>Введите вид товара который хотите посмотреть</H4>
        <input type="text" name="text_request">
        <input type="submit" name="submit" value="Выполнить запрос">
    </form>
    <?php
    if ($_POST['submit'] && $_POST['text_request'] != " ") {
        $buf = mysqli_real_escape_string($connection,$_POST['text_request']);
        $res = mysqli_query($connection, "SELECT * FROM product WHERE type = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
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
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?=$row->id_product;?></td>
                <td><?=$row->name_product;?></td>
                <td><?=$row->id_shipper;?></td>
                <td><?=$row->cost;?></td>
                <td><?=$row->net_cost;?></td>
                <td><?=$row->quantity_product;?></td>
                <td><?=$row->type;?></td>
                <td><?=$row->id_dep;?></td>
                <td><?=$row->id_magazine;?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_8'){
    ?>
    <form method="post">
        <H4>Введите номер этажа для поиска продавцов</H4>
        <input type="number" name="text_request" required>
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']) {
        $buf=$_POST['text_request'];
        $res = mysqli_query($connection, "SELECT p.id_marketer,p.name_marketer,s.floor_dep 
                                                FROM marketer as p LEFT JOIN department s ON p.id_dep = s.id_dep 
                                                WHERE s.floor_dep = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Номер продавца</th>
            <th>Имя продавца</th>
            <th>Номер этажа</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_marketer; ?></td>
                <td><?= $row->name_marketer; ?></td>
                <td><?= $row->floor_dep; ?></td>
            </tr>
            <?
        }
    }
}
if($_GET['task'] == 'request_9'){
    ?>
    <form method="post">
        <H4>Введите номер заказа для посмотра его статуса, названия товара и количество товара</H4>
        <input type="number" name="text_request">
        <input type="submit" name = "submit" value="Выполнить запрос">
    </form>
    <?php
    if($_POST['submit']&& $_POST['text_request'] != " ") {
        $buf=$_POST['text_request'];
        $res = mysqli_query($connection, "SELECT s.id_product,s.name_product,p.quantity_in_sh,p.order_status
                                                FROM storehouse as p LEFT JOIN product s ON p.id_product = s.id_product 
                                                WHERE p.id_order = '$buf'");
        ?>
        <table class="table table-bordered table-hover table-striped" style="width: 500px;"">
        <tr>
            <th>Номер товара</th>
            <th>Название товара</th>
            <th>Количество товара</th>
            <th>Статус заказа</th>
        </tr>
        <?php
        while ($row = $res->fetch_object()) {
            ?>
            <tr>
                <td><?= $row->id_product; ?></td>
                <td><?= $row->name_product; ?></td>
                <td><?= $row->quantity_in_sh; ?></td>
                <td><?= $row->order_status; ?></td>
            </tr>
            <?
        }
    }
}
mysqli_close($connection);

?>

</body>
</html>