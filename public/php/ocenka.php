<?php

switch($_POST['function']) {
  case 'getPersonInfoSnils': echo getPersonInfoSnils('SELECT * FROM ZXOCENKA_PERSON WHERE SNILS = "' . $_POST['Snils'] . '"'); break;
  case 'getPersonInfoFio': echo getPersonInfoFio('SELECT * FROM ZXOCENKA_PERSON WHERE FA = "' . $_POST['Fio'] . '"'); break;
}

function getPersonInfoFio($strQuery) {
  $strConnect = oci_connect("Q##SECOFR","Ufkfrnbrf",'XE','AL32UTF8');
  if(!$strConnect) return json_encode("Error connect to database");

  $strFetch=ociparse($strConnect,$strQuery);
  ociexecute($strFetch,OCI_DEFAULT);
  $rowPerson = [];
  $arrPerson = [];
  while($row = oci_assocc($strFetch)) {
    $rowPerson[] = $row;
  }
  $arrPerson[] = $rowPerson;
  return json_encode($arrPerson);
}

?>