<?php

switch($_GET['function']) {
  case 'taskAdd': echo executeDB("BEGIN :stringReturn:=ZRREPORT.TASKADD('" . $_GET['specId'] . "', '" 
                                                                           . $_GET['taskText'] . "', '" 
                                                                           . $_GET['taskStatus'] . "'); END;"); break;
  case 'taskDelete': echo executeDB("BEGIN :stringReturn:=ZRREPORT.TASKDELETE('" . $_GET['taskId'] . "'); END;"); break;
	
  case 'taskGet': echo selectDB("SELECT * FROM ZRREPORT_HISTORY_VI"); break;

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

function executeDB($stringQuery) {
  if (!$stringConnection = oci_connect("C##QSECOFR","Ufkfrnbrf","XE","AL32UTF8")) {return json_encode("Error connecting to Database#");}
  $stringReturn = "0";
  $stringQuery = ociparse($stringConnection, $stringQuery);
  ocibindbyname($stringQuery,':stringReturn',$stringReturn, 255);
  ociexecute($stringQuery, OCI_DEFAULT);
  oci_close($stringConnection);
  return $stringReturn;
}

?>