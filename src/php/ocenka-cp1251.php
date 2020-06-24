<?php

switch($_POST['function']) {
case 'getUserInfo': echo getUserInfo($_POST['snils']); break;
}

function getUserInfo($vsnils) {
date_default_timezone_set ('Asia/Irkutsk');

setlocale(LC_ALL, 'ru_RU.UTF-9');
$username="db2admin";
$password="Centr023";

$snils=strip_tags($vsnils);

$d = getdate(); // текущая дата
$current_date = $d[mday].".".$d[mon].".".$d[year];
$hostip = $_SERVER['REMOTE_ADDR'];
$usr="_";

if ($hostip == '10.38.0.209') $usr='Denis';


$database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
$DB_conn1 = odbc_connect($database1, $username, $password) or die(odbc_errormsg());

 if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 

$sql1="select rayonA, familiya, name, middlename, Birth, job, szvk, slpriz, ins2002 from sved
 where snils='".$snils."'"; // sved

$sql2="select workdate, workspec, workrez from history
 where workdate=(select max(workdate) from history where snils='".$snils."') and snils='".$snils."'"; // history
 
$resultset1 = odbc_prepare($DB_conn1, $sql1);
$success1 = odbc_execute($resultset1);

$resultset2 = odbc_prepare($DB_conn1, $sql2);
$success2 = odbc_execute($resultset2);

//echo odbc_result_all($resultset1);
$arrRow = [];
$arrReturn = [];
while($row=odbc_fetch_row($resultset1)){
    $arrRow[] = endecode(trim(odbc_result($resultset1, 2)));
    $arrRow[] = endecode(trim(odbc_result($resultset1, 3)));
    $arrRow[] = endecode(trim(odbc_result($resultset1, 4)));
    $arrRow[] = endecode(trim(odbc_result($resultset1, 5)));
    $arrRow[] = getTO(trim(odbc_result($resultset1, 1)));
    // $arrRow[] = endecode(trim(odbc_result($resultset1, 3)));
    // $arrRow[] = endecode(trim(odbc_result($resultset1, 4)));
    
     $arrReturn[] =  $arrRow;
}

// return mb_convert_encoding($arrReturn,
// mb_detect_encoding($arrReturn),
// 'cp1251');

return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);

}

function endecode($strVal) {
    return mb_convert_encoding($strVal, 'UTF-8', 'cp1251');
}

function getTO($strVal) {
    switch ($strVal) {
        case "38001": {return "Благовещенск"; break;}
        case "38002": {return "Белогорск"; break;}
        case "38003": {return "Зея"; break;}
        case "38004": {return "Райчихинск"; break;}
        case "38005": {return "Свободный"; break;}
        case "38006": {return "Тында"; break;}
        case "38007": {return "Шимановск"; break;}
        case "38008": {return "Архара"; break;}
        case "38010": {return "Новобурейск"; break;}
        case "38011": {return "Завитинск"; break;}
        case "38012": {return "Ивановка"; break;}
        case "38013": {return "Константиновка"; break;}
        case "38014": {return "Магдагачи"; break;}
        case "38015": {return "Новокиевский Увал"; break;}
        case "38016": {return "Поярково"; break;}
        case "38017": {return "Екатеринославка"; break;}
        case "38018": {return "Ромны"; break;}
        case "38019": {return "Серышево"; break;}
        case "38020": {return "Экимчан"; break;}
        case "38021": {return "Сковородино"; break;}
        case "38022": {return "Тамбовка"; break;}
    }
}

/*
while($row=odbc_fetch_row($resultset1)){
$v1p1 = trim(odbc_result($resultset1, 1));// $v1p1 = trim($v1p1);//rayonA
$v1p2 = trim(odbc_result($resultset1, 2));// $v1p2 = trim($v1p2);//fam
$v1p3 = trim(odbc_result($resultset1, 3));// $v1p3 = trim($v1p3);//nam
$v1p4 = trim(odbc_result($resultset1, 4));// $v1p4 = trim($v1p4);//mid
$v1p5 = odbc_result($resultset1, 5);//Birth
$v1p6 = trim(odbc_result($resultset1, 6));//job
$v1p7 = odbc_result($resultset1, 7);//szvk
$v1p8 = odbc_result($resultset1, 8);//slpriz if ($v1p8 == '   ') $v1p8 = "_";//slpriz
$v1p9 = odbc_result($resultset1, 9);//ins2002
}

$job='???';
if ($v1p6 == '??') $job='??, '.$v1p9;

$ks="_";
switch ($v1p1) {
    case "38001":
        $ks="????????????"; break;
    case "38002":
        $ks="?????????"; break;
    case "38003":
        $ks="???"; break;
    case "38004":
        $ks="??????????"; break;
    case "38005":
        $ks="?????????"; break;
    case "38006":
        $ks="?????"; break;
    case "38007":
        $ks="?????????"; break;
    case "38008":
        $ks="??????"; break;
    case "38010":
        $ks="???????????"; break;
    case "38011":
        $ks="?????????"; break;
    case "38012":
        $ks="????????"; break;
    case "38013":
        $ks="??????????????"; break;
    case "38014":
        $ks="?????????"; break;
    case "38015":
        $ks="???????????? ????"; break;
    case "38016":
        $ks="????????"; break;
    case "38017":
        $ks="???????????????"; break;
    case "38018":
        $ks="?????"; break;
    case "38019":
        $ks="????????"; break;
    case "38020":
        $ks="???????"; break;
    case "38021":
        $ks="???????????"; break;
    case "38022":
        $ks="????????"; break;
}

while($row=odbc_fetch_row($resultset2)){
$v2p1 = odbc_result($resultset2, 1); if ($v2p1 == '01.01.1900') $v2p1 = " "; //workdate
$v2p2 = odbc_result($resultset2, 2); if ($v2p2 == NULL ) $v2p2 = " ";//wspec
$v2p3 = odbc_result($resultset2, 3); if ($v2p3 == NULL ) $v2p3 = " ";//wrez
}
//echo "<table border=0><tr><td width=500 align=center><h3>???????</h3></td></tr></table>";
echo "<br><table border=1>";
echo "<caption><b>???????? ? ??<br>?????: ".$snils."</b><br><br></caption>";
echo "<tr>";
echo "<td><b>???????? ? ??????????:</b></td>";
echo  "<td> ".$v1p2." ".$v1p3." ".$v1p4.",<br>?.?.: ".$v1p5."</td>";
echo "</tr>";
echo "<tr>";
echo "<td width=200><b>&nbsp???????????? ???????????????? ??????:</b></td>";
echo  "<td width=300>".$v1p1." ".$ks."</td>";
echo "</tr>";
echo "<tr>";
echo "<td><b>???????? ? ??????:</b></td>";
echo  "<td> ".$job."</td>";
echo "</tr>";
echo "<tr>";
echo "<td><b>? ?????? ???-??</b></td>";
echo  "<td> ".$v1p7."</td>";
echo "</tr>";
echo "<tr>";
echo "<tr>";
echo "<td><b>? ?????? ???????</b></td>";
echo  "<td> ".$v1p8."</td>";
echo "</tr>";
echo "<tr>";

echo "<tr>";
echo "<td><b>???? ????? ?????????? ?????????:</b></td>";
echo "<td>".$v2p1."</td>";
echo "</tr>";
echo "<tr>";
echo "<td><b>??????????:</b></td>";
echo "<td>".$v2p2."</td>";
echo "</tr>";
echo "<tr>";
echo "<td><b>????????? ?????????:</b></td>";
echo "<td>".$v2p3."</td>";
echo "</tr>";

echo "</table>";
echo "<br>";
//echo "<h4> </h4>";
  
echo '<table border=0 class="hidden" >
  <tr>
  <td width=70>?????????: </td>
  <td>
  <form action="ocenka_upd.php" method="POST">
  <input type="hidden" name="snils" value="'.$snils.'">
  <input type="hidden" name="usr" value="'.$usr.'">
  <select name="rezult">
  <option value="r1" selected>?????????? ??????????? (???????????) ??????????</option>
  <option value="r2">?????????? ??????????? ????????????</option>
  <option value="r3">????????? ????????? ? ???? ???</option>
  <option value="r4">????????? ???????????????? ??????</option>
  <option value="r5">???????? ?????? ??????? ? ???? ???</option>
  <option value="r6">???????? ?????? ??????? ? ???? ???</option>
  <option value="r7">??? ???????? (??????????????)</option>
  <option value="r8">?? ?????? ? ??</option>
  <option value="r9">????????? ??, ???, ????</option>
  <option value="r10">?????? ?? ?????????? ????.??????????? (?????)</option>
  <option value="r11">??? ???????? ??????/???? ???????????? ?? 01.01.2002</option>
  <option value="r12">?????</option>
  <option value="r13">????</option>
  </select>';
if ($usr != '_' ) {
  echo '<input type="submit" value="??????">'; 
 } else echo '&nbsp?? ?? ?????? ??????? ?????????';
 
 echo '</form>
  </td>
  </tr>';
  */
?>
