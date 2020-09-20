<?php

$strip = $_SERVER['REMOTE_ADDR'];

switch($_GET['function']) {
  case 'getListUser': echo selectDB("SELECT * FROM ZXOCENKA_SPEC ORDER BY CNAME"); break;
  case 'insertUser': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.INSERT_USER('" . $_GET['userFio'] . "', '" 
                                                                                  . $_GET['userIp'] . "'); END;"); break;
  case 'disabledUser': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.DISABLED_USER('" . $_GET['userId'] . "'); END;"); break;
  case 'getUser': echo selectDB("SELECT * FROM ZXOCENKA_SPEC WHERE CACCESS = '1' AND CIP = '" . $strip . "'"); break;

  case 'getPersonInfoSnils': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_INFO WHERE SNILS = '" . $_GET['Snils'] . "'"); break;
  case 'getPersonInfoFio': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_INFO WHERE UPPER(FA) LIKE UPPER('" . $_GET['Fio'] . "%')"); break;
  case 'changePerson': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.CHANGE_PERSON('" . $_GET['personId'] . "', '" 
																					  . $_GET['districtId'] . "'); END;"); break;
	
  case 'getPersonInfo': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_INFO WHERE ID = '" . $_GET['personId'] . "'"); break;
  case 'getPersonHistiry': echo selectDB("SELECT * FROM ZXOCENKA_PERSON_HISTORY WHERE PERSON_ID = '" . $_GET['personId'] . "'"); break;

  case 'getListDecision': echo selectDB("SELECT * FROM ZXOCENKA_DECISION ORDER BY ID"); break;
  case 'getListDistrict': echo selectDB("SELECT * FROM ZXOCENKA_DISTRICT_INFO"); break;

  case 'insertHistory': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.INSERT_HISTORY('" . $_GET['personId'] . "', '" 
                                                                                        . $_GET['specId'] . "', '" 
                                                                                        . $_GET['decisionId'] . "'); END;"); break;
  case 'deleteHistory': echo executeDB("BEGIN :stringReturn:=ZXOCENKA.DELETE_HISTORY('" . $_GET['historyId'] . "'); END;"); break;
  
  case 'buildReport': echo buildReport($_GET['arrDistrict'], 
                                       $_GET['typeDistrict'],
                                       $_GET['dateStart'],
                                       $_GET['dateEnd']); break;
  case 'buildReportType': echo buildReportType($_GET['arrDistrict'], 
											   $_GET['typeReport'],
											   $_GET['dateStart'],
											   $_GET['dateEnd']); break;
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
//typeDistrict
function buildReport($strDistrict, $typeDistrict, $dateStart, $dateEnd) {
  if (!$stringConnection = oci_connect("C##QSECOFR","Ufkfrnbrf","XE","AL32UTF8")) {return json_encode("Error connecting to Database#");}
  $arrDistrict = explode(',',$strDistrict);
  $arrReturn = [];
	
  for($i = 0; $i < count($arrDistrict); $i++) {
    $rowReturn = [];
	
    if($typeDistrict == "true") {
      $stringQuery = "SELECT * FROM ZXOCENKA_MRU WHERE ID='" . $arrDistrict[$i] . "'" ;
    }
    elseif($typeDistrict == "false") {
      $stringQuery = "SELECT * FROM ZXOCENKA_DISTRICT WHERE ID = '" . $arrDistrict[$i] . "'" ;
	  
    }
    $stringQuery = ociparse($stringConnection, $stringQuery);
    ociexecute($stringQuery, OCI_DEFAULT);
    while($row = oci_fetch_assoc($stringQuery)) {
      $rowReturn[] = ($typeDistrict == 'true') ? '1' : $row["FLAG_MRU"];
      $rowReturn[] = $row["CNAME"];
    }
    if($typeDistrict == 'true') {
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
						  
    } elseif ($typeDistrict == 'false') {
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
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
//typeFilter
function buildReportType($strDistrict, $typeReport, $dateStart, $dateEnd) {
  if (!$stringConnection = oci_connect("C##QSECOFR","Ufkfrnbrf","XE","AL32UTF8")) {return json_encode("Error connecting to Database#");}
  $arrDistrict = explode(',',$strDistrict);
  $arrReturn = [];
  switch($typeReport) {
    case 'szvk': $strWhereType = "ZXOCENKA_PROPS.SZVK = '1' AND"; break;
	case 'slpriz': $strWhereType = "ZXOCENKA_PROPS.SLPRIZ = '1' AND"; break;
	case 'uhod': $strWhereType = "ZXOCENKA_PROPS.UHOD = '1' AND"; break;
	
  }
  //return json_encode($strWhereType, JSON_UNESCAPED_UNICODE);
  for($i = 0; $i < count($arrDistrict); $i++) {
    $rowReturn = [];
    $stringQuery = "SELECT * FROM ZXOCENKA_DISTRICT WHERE ID = '" . $arrDistrict[$i] . "'" ;

    $stringQuery = ociparse($stringConnection, $stringQuery);
    ociexecute($stringQuery, OCI_DEFAULT);
    while($row = oci_fetch_assoc($stringQuery)) {
      $rowReturn[] = $row["FLAG_MRU"]; // $rowReturn[] = ($typeFilter == 'true') ? '1' : $row["FLAG_MRU"];
      $rowReturn[] = $row["CNAME"];
    }
//    if($typeFilter == 'true') {
//      $stringQuery = "SELECT 
//                          ZXOCENKA_DECISION.ID AS DECISIONID, 
//                          ZXOCENKA_DECISION.CNAME AS DECISIONNAME, 
//                          TB1.DECISIONCOUNT AS DECISIONCOUNT 
//                      FROM ZXOCENKA_DECISION
//                      LEFT OUTER JOIN (
//                      SELECT 
//                          ZXOCENKA_REPORT_MRU.DECISIONID AS DECISIONID,
//                          COUNT(ZXOCENKA_REPORT_MRU.DECISIONID) AS DECISIONCOUNT
//                          FROM ZXOCENKA_REPORT_MRU
//                          WHERE ZXOCENKA_REPORT_MRU.MRUID = '" . $arrDistrict[$i] . "' AND 
//                                ZXOCENKA_REPORT_MRU.CDATE BETWEEN TO_DATE('" . $dateStart . "', 'YYYY-MM-DD') AND (TO_DATE('" . $dateEnd . "', 'YYYY-MM-DD') + 1) 
//                          GROUP BY ZXOCENKA_REPORT_MRU.DECISIONID) TB1 ON ZXOCENKA_DECISION.ID = TB1.DECISIONID";
//						  
//    } elseif ($typeFilter == 'false') {
      $stringQuery = "SELECT ZXOCENKA_DECISION.ID AS DECISIONID, ZXOCENKA_DECISION.CNAME AS DECISIONNAME, TB1.DECISIONCOUNT AS DECISIONCOUNT 
                      FROM ZXOCENKA_DECISION
                      LEFT OUTER JOIN (
                                SELECT 
                                ZXOCENKA_HISTORY.DECISION_ID AS RESHENIEID,
                                ZXOCENKA_PERSON.DISTRICT_ID AS DISTRICTID,
    	                        COUNT(ZXOCENKA_HISTORY.DECISION_ID) AS DECISIONCOUNT 
                                FROM ZXOCENKA_PERSON
                                LEFT JOIN ZXOCENKA_HISTORY ON ZXOCENKA_PERSON.ID = ZXOCENKA_HISTORY.PERSON_ID
                                LEFT JOIN ZXOCENKA_PROPS ON ZXOCENKA_PERSON.ID = ZXOCENKA_PROPS.PERSON_ID 
                                WHERE " . $strWhereType . " ZXOCENKA_PERSON.DISTRICT_ID = '" . $arrDistrict[$i] . "' AND ZXOCENKA_HISTORY.CDATE BETWEEN TO_DATE('" . $dateStart . "', 'YYYY-MM-DD') AND (TO_DATE('" . $dateEnd . "', 'YYYY-MM-DD') + 1) 
	                              GROUP BY ZXOCENKA_HISTORY.DECISION_ID, ZXOCENKA_PERSON.DISTRICT_ID) TB1 ON ZXOCENKA_DECISION.ID = TB1.RESHENIEID
	                              ORDER BY ZXOCENKA_DECISION.ID";
//    }
//return json_encode($stringQuery, JSON_UNESCAPED_UNICODE);
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