<?php

if(isset($_POST['fio'])) {
 echo startFind(iconv('utf-8', 'cp1251', $_POST['fio']));
}

function startFind($param) {
  $opekadate = '20-05-2020';
  $opekadate = mb_substr($opekadate,0,10);
  $strConnect = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OPEKA;";
  if($DB_conn1=odbc_connect($strConnect,"db2admin","Centr023")) {
	$result = '';
	//$arrRow = ();
    $param = mb_strtoupper($param, 'cp1251');
    $strQuery = "select FIOg, SNILSg, Mg, DataF, DataR, FIOr, SNILSr, Mr, vid from sved where UPPER(FIOg) like '". trim($param) ."%'";
    $resultset1 = odbc_prepare($DB_conn1, $strQuery);
    $success1 = odbc_execute($resultset1);
    $i = 0;
    while($row=odbc_fetch_row($resultset1)) {
      $v1p1 = odbc_result($resultset1, 1);
      $v1p2 = odbc_result($resultset1, 2);
      $v1p3 = odbc_result($resultset1, 3);
      $v1p4 = odbc_result($resultset1, 4);
      $v1p5 = odbc_result($resultset1, 5);
      $v1p6 = odbc_result($resultset1, 6);
      $v1p7 = odbc_result($resultset1, 7);
      $v1p8 = odbc_result($resultset1, 8);
      $v1p9 = odbc_result($resultset1, 9);


      $result =  trimSpace($v1p1) . ';' . trimSpace($v1p2) . ';' . trimSpace($v1p3) . ';' . trimSpace($v1p4) . ';' . trimSpace($v1p5) . ';' . trimSpace($v1p6) . ';' .
      trimSpace($v1p7) . ';' . trimSpace($v1p8) . ';' . trimSpace($v1p9) . '#';
	  
      echo mb_convert_encoding($result,
                               mb_detect_encoding($result),
                               'cp1251');
    }
	if ($result == '') {echo "0";}
  } else {
    echo "9#Ошибка подключения к БД";
  }
}

function trimSpace($_strText) {
  return preg_replace('/^ +| +$|( ) +/m', '$1', $_strText);
}

?>