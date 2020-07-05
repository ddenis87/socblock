<?php

switch($_POST['function']) {
  case 'getListReshenie': { echo getListReshenie(); break; }
}

function getListReshenie() {
  $arrList = [];
  $arrList[] = 'Направлено уведомление (приглашение) гражданину';
  $arrList[] = 'Направлено уведомление страхователю';
  $arrList[] = 'Поступило заявление о КОРР ИЛС';
  $arrList[] = 'Направлен межведомственный запрос';
  $arrList[] = 'Оформлен проект решения о КОРР ИЛС';
  $arrList[] = 'Проверен проект решения о КОРР ИЛС';
  $arrList[] = 'ИЛС дополнен (скорректирован)';
  $arrList[] = 'Не служил в СА';
  $arrList[] = 'Пенсионер МО, УВД, ФСИН';
  $arrList[] = 'Работа по устранению множ.регистрации (СНИЛС)';
  $arrList[] = 'Нет периодов работы/иной деятельности до 01.01.2002';
  $arrList[] = 'Выбыл';
  $arrList[] = 'Умер';

  return json_encode($arrList, JSON_UNESCAPED_UNICODE);
}

?>