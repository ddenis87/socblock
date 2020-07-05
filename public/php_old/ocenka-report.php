
<table>
<?php

// switch($_POST['function']) {
//   case "getReportAll": echo getReportAll(); break;
// }

echo "HI";
//function getReportAll() {
  date_default_timezone_set ('Asia/Irkutsk');
  setlocale(LC_ALL, 'ru_RU.UTF-8');

  $username="db2admin";
  $password="Centr023";
  $snils=strip_tags($vsnils);
  $database1 = "DRIVER={IBM DB2 ODBC DRIVER}; PROTOCOL=TCPIP; HOSTNAME=10.38.0.98; PORT=50000; DATABASE=OCENKA;";
  $DB_conn1 = odbc_connect($database1, $username, $password) or die(odbc_errormsg());

  if($DB_conn1 === false) {var_dump(odbc_errormsg()); die();} 

  $sql1 = "SELECT mru, rn1, count( * ) AS count
FROM sved
GROUP BY mru, rn1
ORDER BY mru"

  // $sql2 = "select * 
  //          from history
  //          left join sved on history.snils = sved.snils
  //          where sved.mru like '%001'";
   

  $resultset1 = odbc_prepare($DB_conn1, $sql1);
  $success1 = odbc_execute($resultset1);

  // $arrRow = [];
  // $arrReturn = [];
  while($row=odbc_fetch_row($resultset1)){
 
      echo "<tr>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 1))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 2))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 3))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 4))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 5))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 6))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 7))) . "</td>";
      echo "<td>" . endecode(trim(odbc_result($resultset1, 8))) . "</td>";
      // echo "<td>" . endecode(trim(odbc_result($resultset1, 9))) . "</td>";
      // echo "<td>" . endecode(trim(odbc_result($resultset1, 10))) . "</td>";
      echo "</tr>";
  }
  
 // return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
//}

?>
</table>