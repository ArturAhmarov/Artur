<?php
$connection = mysqli_connect('127.0.0.1', 'mysql', 'mysql', 'kursach');
if ($connection == false) {
    die ('Ошибка подключения: ' . mysqli_connect_error());
}
mysqli_query($connection,"SET CHARACTER SET 'cp1251'");
mysqli_query($connection,"SET NAMES 'cp1251'");
$tablename = $_GET['tablename'];
$result = mysqli_query($connection,"SELECT * FROM `$tablename` ");
while( $row = $result->fetch_assoc() ) {
    $items[] = $row;
}
$fileName = "table.xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$fileName);
$heading = false;
if(!empty($items)) {
    foreach($items as $item) {
        if(!$heading) {
            echo implode("\t", array_keys($item)) . "\n";
            $heading = true;
        }
        echo implode("\t", array_values($item)) . "\n";
    }
}
$csv_text = file_get_contents($fileName);
$csv_text_converted = mb_convert_encoding($csv_text, "CP1251", "UTF-8");
if ($csv_text_converted) {
    file_put_contents($fileName, $csv_text_converted);
}
exit();