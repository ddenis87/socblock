<template>
  <div class="ocenka-card">
    <div class="title">
      <h2>Сведения о застрахованном лице: </h2><h2><i>{{ 'СНИЛС: 157-475-853 98' }}</i></h2>
    </div>
    <table>
      <tr><td width="50%">Застрахованное лицо:</td><td>{{ 'Иванов' }} {{ 'Иван' }} {{ 'Иванович' }}</td></tr>
      <tr><td>Дата рождения:</td><td>{{ '22.05.1987' }}</td></tr>
      <tr><td>Наименование территориального органа:</td><td>{{ '38010 - Новобурейск' }}</td></tr>
      <tr><td>Сведения о работе:</td><td>{{ 'Отсутствуют' }}</td></tr>
      <tr><td>СЗВ-К:</td><td>{{ 'Да' }}</td></tr>
      <tr><td>СлПриз:</td><td>{{ 'Нет' }}</td></tr>
    </table>

    
    <div class="sved">
      <h3>Сведения об обработке</h3>
      <div class="sved-control">
        <hr>
        <label for="">Укажите решение:</label>
        <select><option></option><option>Не служил в СА</option></select>
        <button>Добавить решение</button>
        <hr>
      </div>
      <table>
        <tr>
          <th>Специалист</th>
          <th width="100px">Дата</th>
          <th>Решение</th>
          <th width="30px"></th>
        </tr>
        <tr v-for="(rowDataPerson, index) in arrDataPerson" :key="index">
          <td>{{ rowDataPerson[1] }}</td>
          <td>{{ rowDataPerson[2] }}</td>
          <td>{{ rowDataPerson[3] }}</td>
          <td></td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardPerson',
  data: function() {
    return {
      arrDataPerson: [
        ['1','Найдина Е.П.','12.05.2020','Направлено уведомление страхователю'],
        ['2','Музыченко Е.П.','21.02.2020','Направлен межведомственный запрос'],
        ['3','Найдина Е.П.','26.12.2019','Поступило заявление о КОРР ИЛС'],
      ]
    }
  }
}
</script>

<style scoped>
  .ocenka-card {
    padding-left: 10px;
    width: 100%;
    max-width: 800px;
    font-size: 14px;
  }
  /* ------title------ */
  .title {
    display: flex;
    align-items: center;
  }
  h2 {margin-right: 10px;}
  i {color: black;font-size: 14px;}
  /* ----------------- */

  /* ------table------ */
  table {
    width: 100%;
    margin: 10px 0px;
    font-size: 16px;
    border-spacing: 0px;
  }
  th {text-align: left; background-color: limegreen; color: white; padding: 3px;}
  td {
    padding: 5px;
    border-bottom: 2px solid grey;
  }

  td:last-child {font-style: italic;}

/* ------sved-control------- */
  hr {margin: 10px 0px; padding: 0px;}

  .sved {
    margin: 20px 0px;
    font-size: 16px;
  }

  label {margin-right: 10px;}
  select {width: 200px;margin-right: 10px;}
  
/* ------------------------- */
</style>