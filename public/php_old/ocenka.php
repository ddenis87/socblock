<?php

switch($_POST['function']) {
case 'getPersonInfoSnils': echo getPersonInfoSnils($_POST['Snils']); break;
case 'getPersonInfoFio': echo getPersonInfoFio(iconv('utf-8', 'cp1251', $_POST['Fio'])); break;
case 'getPersonInfoCard': echo getPersonInfoCard($_POST['snils']); break;
case 'getPersonInfoCardHistiry': echo getPersonInfoCardHistiry($_POST['snils']); break;
case 'insertHistoryRecord': echo insertHistoryRecord(iconv('utf-8', 'cp1251', $_POST['snils']), 
                                                     iconv('utf-8', 'cp1251', $_POST['reshenie']),
                                                     iconv('utf-8', 'cp1251', $_POST['userName'])); break;
}

function getPersonInfoSnils($vsnils) {
    date_default_timezone_set ('Asia/Irkutsk');
    setlocale(LC_ALL, 'ru_RU.UTF-8');

    $username="db2admin";
    $password="Centr023";
    $snils=strip_tags($vsnils);
    $database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
    $DB_conn1 = odbc_connect($database1, $username, $password) or die(odbc_errormsg());

    if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 

    $sql1="select rn1, familiya, name, middlename, Birth, job, szvk, slpriz, snils, mru from sved where snils='".$snils."'"; // sved
    
    $resultset1 = odbc_prepare($DB_conn1, $sql1);
    $success1 = odbc_execute($resultset1);
    $arrRow = [];
    $arrReturn = [];
    while($row=odbc_fetch_row($resultset1)){
        $arrRow[] = endecode(trim(odbc_result($resultset1, 2))) . 
                    ' ' . endecode(trim(odbc_result($resultset1, 3))) .
                    ' ' . endecode(trim(odbc_result($resultset1, 4)));
        $arrRow[] = endecode(trim(odbc_result($resultset1, 5)));
        $arrRow[] = getTO(trim(odbc_result($resultset1, 1)));
        $arrRow[] = endecode(trim(odbc_result($resultset1, 9)));
        $arrRow[] = endecode(trim(odbc_result($resultset1, 10)));
        $arrReturn[] =  $arrRow;
        $arrRow = [];
    }
    return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
}

function getPersonInfoFio($vfio) {
    date_default_timezone_set ('Asia/Irkutsk');
    setlocale(LC_ALL, 'ru_RU.UTF-8');

    $username="db2admin";
    $password="Centr023";
    $database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
    $DB_conn1 = odbc_connect($database1, $username, $password) or die(odbc_errormsg());

    if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 
    $param = mb_strtoupper($vfio, 'cp1251');
    $sql1="select rn1, familiya, name, middlename, Birth, job, szvk, slpriz, snils, mru from sved where UPPER(familiya) like '".$param."%'"; // sved

    $resultset1 = odbc_prepare($DB_conn1, $sql1);
    $success1 = odbc_execute($resultset1);
    $arrRow = [];
    $arrReturn = [];
    while($row=odbc_fetch_row($resultset1)){
        $arrRow[] = endecode(trim(odbc_result($resultset1, 2))) . 
                    ' ' . endecode(trim(odbc_result($resultset1, 3))) .
                    ' ' . endecode(trim(odbc_result($resultset1, 4)));
        $arrRow[] = endecode(trim(odbc_result($resultset1, 5)));
        $arrRow[] = getTO(trim(odbc_result($resultset1, 1)));
        $arrRow[] = endecode(trim(odbc_result($resultset1, 9)));
        $arrRow[] = endecode(trim(odbc_result($resultset1, 10)));
        $arrReturn[] = $arrRow;
        $arrRow = [];
    }
    return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
}

function getPersonInfoCard($vsnils) {
    date_default_timezone_set ('Asia/Irkutsk');
    setlocale(LC_ALL, 'ru_RU.UTF-8');

    $username="db2admin";
    $password="Centr023";
    $snils=strip_tags($vsnils);
    $database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
    $DB_conn1 = odbc_connect($database1, $username, $password) or die(odbc_errormsg());

    if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 

    $sql1="select rn1, familiya, name, middlename, Birth, job, szvk, slpriz, snils, mru from sved where snils='".$snils."'"; // sved
    
    $resultset1 = odbc_prepare($DB_conn1, $sql1);
    $success1 = odbc_execute($resultset1);
    $arrRow = [];
    $arrReturn = [];
    while($row=odbc_fetch_row($resultset1)){
        $arrRow[] = getTO(trim(odbc_result($resultset1, 1))); //0 rn1
        $arrRow[] = endecode(trim(odbc_result($resultset1, 2))) . 
                    ' ' . endecode(trim(odbc_result($resultset1, 3))) .
                    ' ' . endecode(trim(odbc_result($resultset1, 4))); //1 fio
        $arrRow[] = endecode(trim(odbc_result($resultset1, 5))); //2 date
        $arrRow[] = (endecode(trim(odbc_result($resultset1, 6)))); //3 job  == 'Да') ? endecode(trim(odbc_result($resultset1, 9))) : 'Нет'; //4
        $arrRow[] = endecode(trim(odbc_result($resultset1, 7))); //4 szvk
        $arrRow[] = (endecode(trim(odbc_result($resultset1, 8)))); //5 slpriz  == '') ? 'Нет' : endecode(trim(odbc_result($resultset1, 8))); //6
        $arrRow[] = endecode(trim(odbc_result($resultset1, 9))); //6 snils
        $arrRow[] = endecode(trim(odbc_result($resultset1, 10))); //7 mru
        
        $arrReturn[] =  $arrRow;
        $arrRow = [];
    }
    return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
}

function getPersonInfoCardHistiry($vsnils) {
    date_default_timezone_set ('Asia/Irkutsk');
    setlocale(LC_ALL, 'ru_RU.UTF-8');

    $username="db2admin";
    $password="Centr023";
    $snils=strip_tags($vsnils);
    $database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
    $DB_conn1 = odbc_connect($database1, $username, $password) or die(odbc_errormsg());

    if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 

    // $sql1="select workdate, workspec, workrez from history
    // where workdate=(select max(workdate) from history where snils='".$snils."') and snils='".$snils."'"; // history

    $sql1="select workdate, workspec, workrez, id_str from history
    where snils='".$snils."' order by id_str desc"; // history

    $resultset1 = odbc_prepare($DB_conn1, $sql1);
    $success1 = odbc_execute($resultset1);

    $arrRow = [];
    $arrReturn = [];
    while($row=odbc_fetch_row($resultset1)){
        $arrRow[] = endecode(trim(odbc_result($resultset1, 1))); // if ($v2p1 == '01.01.1900') $v2p1 = " "; //workdate
        $arrRow[] = endecode(trim(odbc_result($resultset1, 2))); // if ($v2p2 == NULL ) $v2p2 = " ";//wspec
        $arrRow[] = endecode(trim(odbc_result($resultset1, 3))); // if ($v2p3 == NULL ) $v2p3 = " ";//wrez
        $arrRow[] = endecode(trim(odbc_result($resultset1, 4))); // if ($v2p3 == NULL ) $v2p3 = " ";//wrez
        $arrReturn[] =  $arrRow;
        $arrRow = [];
    }
    
    return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
}

function insertHistoryRecord($snils, $rez, $usr) {
    date_default_timezone_set ('Asia/Irkutsk');
    setlocale(LC_ALL, 'ru_RU.UTF-8');

    $username="db2admin";
    $password="Centr023";
    $d = getdate(); // использована текущаЯ дата
    $current_date = $d[mday].".".$d[mon].".".$d[year];
    $database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
    $DB_conn1=odbc_connect($database1, $username, $password) or die(odbc_errormsg());

    if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 

    $sql1="insert into history(snils, workdate, workspec, workrez) values ('".$snils."','".$current_date."','".$usr."','".$rez."')";//Добавляем снилс+

    //return "insert into history values ('".$snils."','".$current_date."','".$usr."','".$rez."')";
    $resultset1 = odbc_prepare($DB_conn1, $sql1);
    $success1 = odbc_execute($resultset1);

    echo "Данные обновлены успешно";
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
        default: {return "Отсутствует или не определено"; break;}
    }
}

?>
