<?php

$strip = $_SERVER['REMOTE_ADDR'];
switch($_GET['function']) {
  case 'getUserInfo': echo selectDB("SELECT * FROM ZXOCENKA_SPEC WHERE CIP = '" . $strip . "'"); break;
  case 'getUserIp': echo json_encode($strip); break;
}

function selectDB($stringQuery) {
  if (!$stringConnection = oci_connect("C##QSECOFR","Ufkfrnbrf","XE","AL32UTF8")) {return json_encode("Error connecting to Database#");}
  $arrReturn = [];
  $stringQuery = ociparse($stringConnection, $stringQuery);
  ociexecute($stringQuery, OCI_DEFAULT);
  while($row = oci_fetch_assoc($stringQuery)) {
    $arrReturn[] = $row;
  }
  return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
}
?>