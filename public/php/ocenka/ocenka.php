<?php

$strip = $_SERVER['REMOTE_ADDR'];

switch($_POST['function']) {
  case 'getListUser': echo selectDB("SELECT * FROM ZXOCENKA_SPEC ORDER BY CNAME"); break;
  case 'insertUser': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.INSERT_USER('" . $_POST['userFio'] . "', '" 
                                                                                  . $_POST['userIp'] . "'); END;"); break;
  case 'deleteUser': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.DELETE_USER('" . $_POST['userId'] . "'); END;"); break;
  case 'getUser': echo selectDB("SELECT * FROM ZXOCENKA_SPEC WHERE CIP = '" . $strip . "'"); break;

  case 'getPersonInfoSnils': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_INFO WHERE SNILS = '" . $_POST['Snils'] . "'"); break;
  case 'getPersonInfoFio': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_INFO WHERE UPPER(FA) LIKE UPPER('" . $_POST['Fio'] . "%')"); break;
  case 'changePerson': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.CHANGE_PERSON('" . $_POST['personId'] . "', '" 
																					  . $_POST['districtId'] . "'); END;"); break;
	
  case 'getPersonInfo': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_INFO WHERE ID = '" . $_POST['personId'] . "'"); break;
  case 'getPersonHistiry': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_HISTORY WHERE PERSON_ID = '" . $_POST['personId'] . "'"); break;

  case 'getListDecision': echo selectDB("SELECT * FROM ZXOCENKA_DECISION ORDER BY ID"); break;
  case 'getListDistrict': echo selectDB("SELECT * FROM ZXOCENKA_DISTRICT_INFO"); break;

  case 'insertHistory': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.INSERT_HISTORY('" . $_POST['personId'] . "', '" 
                                                                                        . $_POST['specId'] . "', '" 
                                                                                        . $_POST['decisionId'] . "'); END;"); break;
  case 'deleteHistory': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.DELETE_HISTORY('" . $_POST['historyId'] . "'); END;"); break;
  
  case 'buildReport': echo buildReport($_POST['arrDistrict'], 
                                       $_POST['typeFilter'],
                                       $_POST['dateStart'],
                                       $_POST['dateEnd']); break;
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

function buildReport($strDistrict, $typeFilter, $dateStart, $dateEnd) {
  if (!$stringConnection = oci_connect("C##QSECOFR","Ufkfrnbrf","XE","AL32UTF8")) {return json_encode("Error connecting to Database#");}
  $arrDistrict = explode(',',$strDistrict);
  
  $arrReturn = [];
  for($i = 0; $i < count($arrDistrict); $i++) {
    $rowReturn = [];
    if($typeFilter == "true") {
      $stringQuery = "SELECT * FROM ZXOCENKA_MRU WHERE ID='" . $arrDistrict[$i] . "'" ;
    }
    elseif($typeFilter == "false") {
      $stringQuery = "SELECT * FROM ZXOCENKA_DISTRICT WHERE ID = '" . $arrDistrict[$i] . "'" ;
    }
    $stringQuery = ociparse($stringConnection, $stringQuery);
    ociexecute($stringQuery, OCI_DEFAULT);
    while($row = oci_fetch_assoc($stringQuery)) {
      $rowReturn[] = ($typeFilter == 'true') ? '1' : $row["FLAG_MRU"];
      $rowReturn[] = $row["CNAME"];
    }
    if($typeFilter == 'true') {
      $stringQuery = "SELECT 
                          ZXOCENKA_DECISION.ID AS DECISIONID, 
                          ZXOCENKA_DECISION.CNAME AS DECISIONNAME, 
                          TB1.DECISIONCOUNT AS DECISIONCOUNT 
                      FROM ZXOCENKA_DECISION
                      LEFT OUTER JOIN (
                      SELECT 
                          ZXOCENKA_REPORT_MRU.DECISIONID AS DECISIONID,
                          COUNT(ZXOCENKA_REPORT_MRU.DECISIONID) AS DECISIONCOUNT
                          FROM ZXOCENKA_REPORT_MRU
                          WHERE ZXOCENKA_REPORT_MRU.MRUID = '" . $arrDistrict[$i] . "' AND 
                                ZXOCENKA_REPORT_MRU.CDATE BETWEEN TO_DATE('" . $dateStart . "', 'YYYY-MM-DD') AND (TO_DATE('" . $dateEnd . "', 'YYYY-MM-DD') + 1) 
                          GROUP BY ZXOCENKA_REPORT_MRU.DECISIONID) TB1 ON ZXOCENKA_DECISION.ID = TB1.DECISIONID";
    } elseif ($typeFilter == 'false') {
      $stringQuery = "SELECT ZXOCENKA_DECISION.ID AS DECISIONID, ZXOCENKA_DECISION.CNAME AS DECISIONNAME, TB1.DECISIONCOUNT AS DECISIONCOUNT 
                      FROM ZXOCENKA_DECISION
                      LEFT OUTER JOIN (
                                SELECT 
                                ZXOCENKA_HISTORY.DECISION_ID AS RESHENIEID,
                                ZXOCENKA_PERSON.DISTRICT_ID AS DISTRICTID,
    	                          COUNT(ZXOCENKA_HISTORY.DECISION_ID) AS DECISIONCOUNT 
                                FROM ZXOCENKA_PERSON
                                LEFT JOIN ZXOCENKA_HISTORY ON ZXOCENKA_PERSON.ID = ZXOCENKA_HISTORY.PERSON_ID 
                                WHERE ZXOCENKA_PERSON.DISTRICT_ID = '" . $arrDistrict[$i] . "' AND ZXOCENKA_HISTORY.CDATE BETWEEN TO_DATE('" . $dateStart . "', 'YYYY-MM-DD') AND (TO_DATE('" . $dateEnd . "', 'YYYY-MM-DD') + 1) 
	                              GROUP BY ZXOCENKA_HISTORY.DECISION_ID, ZXOCENKA_PERSON.DISTRICT_ID) TB1 ON ZXOCENKA_DECISION.ID = TB1.RESHENIEID
	                              ORDER BY ZXOCENKA_DECISION.ID";
    }
    $stringQuery = ociparse($stringConnection, $stringQuery);
    ociexecute($stringQuery, OCI_DEFAULT);
    while($row = oci_fetch_assoc($stringQuery)) {
      $rowReturn[] = $row["DECISIONCOUNT"];
    }
    $arrReturn[] = $rowReturn;
  }
  return json_encode($arrReturn, JSON_UNESCAPED_UNICODE);
}

?>