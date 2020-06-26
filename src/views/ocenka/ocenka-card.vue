<template>
  <div class="ocenka-card">
    <div class="title">
      <h2>Сведения о застрахованном лице: </h2><h2><i>{{ arrDataPerson[0][7] }}</i></h2>
    </div>
    <table>
      <tr><td width="50%">Застрахованное лицо:</td><td>{{ arrDataPerson[0][1] }}</td></tr>
      <tr><td>Дата рождения:</td><td>{{ arrDataPerson[0][2] }}</td></tr>
      <tr><td>Наименование территориального органа:</td><td>{{ arrDataPerson[0][0] }}</td></tr>
      <tr><td>Сведения о работе(ИНН):</td><td>{{ arrDataPerson[0][3] }}</td></tr>
      <tr><td>Включен в список "СЗВ-К":</td><td>{{ arrDataPerson[0][4] }}</td></tr>
      <tr><td>Включен в список "СлПриз":</td><td>{{ arrDataPerson[0][5] }}</td></tr>
    </table>

    
    <div class="sved">
      <h2>Сведения об обработке</h2>
      <div class="sved-control" v-if="(access)">
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
        <tr v-for="(rowDataHistory, index) in arrDataHistory" :key="index">
          <td>{{ rowDataHistory[1] }}</td>
          <td>{{ rowDataHistory[0] }}</td>
          <td>{{ rowDataHistory[2] }}</td>
          <td></td>
        </tr>
      </table>
    </div>
    <div class="progress-load" :class="{'is-visible' : (isLoad) ? true : false}">
      <img src="/img/load.gif">
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardPerson',
  data: function() {
    return {
      arrDataPerson: [['','','','','','','']],
      arrDataHistory: [['','','']],
      isLoad: true, 
      snils: decodeURI(window.location.search.slice(window.location.search.indexOf("=") + 1)),
      access: accessUser,
    }
  },
  created: function() {
    this.isLoad = false;
    let requestInfo = new XMLHttpRequest();
    requestInfo.open('POST', pathBackEnd + 'php/ocenka.php', true);
    requestInfo.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requestInfo.responseType = 'json';
    requestInfo.send(`function=getPersonInfoCard&snils=${this.snils}`);
    requestInfo.onload = () => {
      this.arrDataPerson = requestInfo.response;
      this.isLoad = true;
      //console.log(requestInfo.response);
    }
    this.isLoad = false;
    let requestHistory = new XMLHttpRequest();
    requestHistory.open('POST', pathBackEnd + 'php/ocenka.php', true);
    requestHistory.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requestHistory.responseType = 'json';
    requestHistory.send(`function=getPersonInfoCardHistiry&snils=${this.snils}`);
    requestHistory.onload = () => {
      this.arrDataHistory = requestHistory.response;
      this.isLoad = true;
      console.log(requestHistory.response);
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
  h2 {margin: 0px; margin-right: 10px;font-size: 18px;}
  i {color: black;font-size: 16px;}
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
    margin: 0px;
    font-size: 16px;
  }

  label {margin-right: 10px;}
  select {width: 200px;margin-right: 10px;}
  
/* ------------------------- */

/* ------progress-load------ */
.progress-load {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    text-align: center;
  }

  .progress-load img {
    margin-top: 300px;
    width: 50px;
    height: 50px;
  }

  .is-visible {
    visibility: hidden;
  }
/* ---------------------- */
</style>