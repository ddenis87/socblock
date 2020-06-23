<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
 <meta http-equiv="refresh" content="3;URL=http://sw03800008064.0038.pfr.ru/ocenka.php">
  <STYLE type="text/css" media="print">
   @media print {
   .hidden { display: none; }
   h4 { page-break-before: always; }
   }
 </STYLE>
 <style type="text/css">
  <!--
   .tab { margin-left: 120px; }
  -->
 </style>
</head>
<body>

<?php
date_default_timezone_set ('Asia/Irkutsk');
setlocale(LC_ALL, 'ru_RU.UTF-9');
$username="db2admin";
$password="Centr023";

$d = getdate(); // использована текущаЯ дата
$current_date = $d[mday].".".$d[mon].".".$d[year];
//$hostip = $_SERVER['REMOTE_ADDR'];
//$log_path = './logs/'.$hostip.'_17.txt';
//$log_string = file_get_contents($log_path);//$snils;$usr
//$array = explode(';',$log_string);
//$snils = $array[0];
//$usr = $array[1];
//unlink($log_path);
$snils=strip_tags($_POST['snils']);
$usr=strip_tags($_POST['usr']);
$rez=strip_tags($_POST['rezult']);
if ($rez == "r1") {$rez="направлено уведомление (приглашение) гражданину";}
if ($rez == "r2") {$rez="направлено уведомление страхователю";}
if ($rez == "r3") {$rez="поступило заявление о КОРР ИЛС";}
if ($rez == "r4") {$rez="направлен межведомственный запрос";}
if ($rez == "r5") {$rez="оформлен проект решения о КОРР ИЛС";}
if ($rez == "r6") {$rez="проверен проект решения о КОРР ИЛС";}
if ($rez == "r7") {$rez="ИЛС дополнен (скорректирован)";}
if ($rez == "r8") {$rez="не служил в СА";}
if ($rez == "r9") {$rez="пенсионер МО, УВД, ФСИН";}
if ($rez == "r10") {$rez="работа по устранению множ.регистрации (СНИЛС)";}
if ($rez == "r11") {$rez="нет периодов работы/иной деятельности до 01.01.2002";}
if ($rez == "r12") {$rez="выбыл";}
if ($rez == "r13") {$rez="умер";}

//Подключаемся к БД
$database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
$DB_conn1=odbc_connect($database1, $username, $password) or die(odbc_errormsg());

 if($DB_conn1 === false) {
    var_dump(odbc_errormsg());   
    die();} 

$sql1="insert into history values ('".$snils."','".$current_date."','".$usr."','".$rez."')";//Добавляем снилс+

$resultset1 = odbc_prepare($DB_conn1, $sql1);
$success1 = odbc_execute($resultset1);

echo "Данные обновлены успешно";
//echo $sql1;
?>

</body>
</html>
