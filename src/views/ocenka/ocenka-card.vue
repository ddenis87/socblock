<template>
  <div class="ocenka-card">
    <div class="back">
      <img src="img/back.png" class="back-img" @click="goBack"/>
    </div>

    <div class="title">
      <h2>Сведения о застрахованном лице: </h2><h2><i>{{ arrDataPerson[0].SNILS }}</i></h2>
    </div>
    <table>
      <tr><td width="50%">Застрахованное лицо:</td><td>{{ arrDataPerson[0].FA + " " + arrDataPerson[0].IM + " " + arrDataPerson[0].OT}}</td></tr>
      <tr><td>Дата рождения:</td><td>{{ arrDataPerson[0].BIRTHDAY }}</td></tr>
      <tr><td>Наименование территориального органа:</td><td>{{ arrDataPerson[0].NAME_DISTRICT }}</td></tr>
      <tr><td>Наименование МРУ:</td><td>{{ (arrDataPerson[0].NAME_MRU) ? arrDataPerson[0].NAME_MRU : 'Является МРУ' }}</td></tr>

      <tr><td>Работающий:</td><td>{{ (+arrDataPerson[0].JOB) ? 'Да' : 'Нет' }}</td></tr>
      <tr><td>Включен в список "СЗВ-К":</td><td>{{ (arrDataPerson[0].SZVK) ? 'Да' : 'Нет' }}</td></tr>
      <tr><td>Включен в список "СлПриз":</td><td>{{ (+arrDataPerson[0].SLPRIZ) ? 'Да' : 'Нет' }}</td></tr>
    </table>

    <div class="title">
      <h2>Сведения об обработке</h2>
    </div>
    <div class="sved">
      <hr>
      <div class="sved-control" v-if="(access)"> <!-- access - может использовать глобальную переменную -->
        
        <label for="">Укажите решение:</label>
        <select v-model="decisionId">
          <option value="" selected disabled>Выберите решение из списка</option>
          <option v-for="(rowList, index) in arrList" 
                  :key="index" 
                  :value='rowList.ID'>{{ rowList.CNAME }}</option>
        </select>
        <button @click="insertHistoryRecord">Добавить решение</button>
        
      </div>
      <hr>
      <table>
        <tr>
          <th>Специалист</th>
          <th width="80px">Дата</th>
          <th>Решение</th>
          <th width="30px">Действие</th>
        </tr>
        <tr v-for="(rowDataHistory, index) in arrDataHistory" :key="index">
          <td>{{ rowDataHistory.SPEC }}</td>
          <td>{{ rowDataHistory.CDATE }}</td>
          <td>{{ rowDataHistory.DECISION }}</td>
          <td align="right"><img src="img/button-row-delete.png" class="button-row-control" 
                                    title="Удалить запись" 
                                    @click="deleteHistoryRecord(rowDataHistory[3])" disabled /></td>
        </tr>
      </table>
      <p>{{ selectEmpty }}</p>
    </div>
    <div class="progress-load" :class="{'is-visible' : (isLoad) ? true : false}">
      <img src="img/load.gif">
    </div>
    <div class="warning-insert" :class="{'is-visible' : (isWarning) ? true : false}">
      Не указано решение!
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardPerson',
  data: function() {
    return {
      arrDataPerson: [['','','','','','','','']],
      arrDataHistory: [['','','']],
      arrList: [],
      isLoad: true, isWarning: true,
      personId: decodeURI(window.location.search.slice(window.location.search.indexOf("=") + 1)),
      access: accessUser,
      decisionId: '',
      selectEmpty: '',
    }
  },
  methods: {
    goBack: function() {
      this.$router.push(`/ocenka`);
    },
    insertHistoryRecord: function() {
      if(this.decisionId != '') {
        console.log(this.personId);
        console.log(accessUserId);
        console.log(this.decisionId);

        this.isLoad = false;
        let request = new XMLHttpRequest();
        request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(`function=insertHistory&personId=${this.personId}&specId=${accessUserId}&decisionId=${this.decisionId}`);
        request.onload = () => {
          this.loadHistory();
          this.decisionId = '';
          this.isLoad = true;
        }
      } else {
        this.isWarning = false,
        setTimeout(() => { this.isWarning = true }, 1200)
      }
    },
    deleteHistoryRecord: function(param) {
      console.log(param);
    },
    loadInfo: function() {
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(`function=getPersonInfo&personId=${this.personId}`);
      request.onload = () => {
        this.arrDataPerson = request.response;
        console.log(request.response);
      }
    },
    loadHistory: function() {
      let requestHistory = new XMLHttpRequest();
      this.selectEmpty = '';
      requestHistory.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      requestHistory.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      requestHistory.responseType = 'json';
      requestHistory.send(`function=getPersonHistiry&personId=${this.personId}`);
      requestHistory.onload = () => {
        this.arrDataHistory = requestHistory.response;
        if (this.arrDataHistory.length == 0) this.selectEmpty = 'Записи отсутствуют';
      }
    },
  },
  created: function() {
    this.isLoad = false;
    // load person info
    this.loadInfo();
    // load history
    this.loadHistory();
    // load list reshenie if user access
    if(this.access) {
      this.isLoad = false;
      let requestList = new XMLHttpRequest();
      requestList.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      requestList.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      requestList.responseType = 'json';
      requestList.send(`function=getListDecision`);
      requestList.onload = () => {
        this.arrList = requestList.response;
      }
    }
    this.isLoad = true;
  }
}
</script>

<style scoped>
  h2 {margin: 0px; margin-right: 10px;font-size: 18px;}

  .ocenka-card {
    padding-left: 10px;
    width: 100%;
    max-width: 1000px;
    font-size: 14px;
  }
  /* ------back-button------ */
  .back-img {
    width: 30px;
    height: auto;
    cursor: pointer;
  }
  /* ----------------------- */
  /* ------title------ */
  .title {
    display: flex;
    /* align-items: center;
    margin-top: 20px; */
  }
  i {color: black;font-size: 16px;}
  /* ----------------- */

  /* ------table------ */
  table {
    width: 100%;
    margin: 10px 0px;
    margin-bottom: 20px;
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
  .sved-control {
    display: flex;
    justify-content: space-between;
    padding-left: 15px;
    padding-right: 15px;
  }

  hr {margin: 10px 0px; padding: 0px;}

  .sved {
    margin: 0px;
    font-size: 16px;
  }

  label {width: 220px;}
  select {
    width: 100%;
    min-width: 350px;
    margin-right: 10px;
    padding: 2px;
  }

  button {width: 220px;}
  
/* ------------------------- */

/* ------delete-reshenie------ */
.button-row-control {
  width: 18px;
  height: 18px;
  margin: 3px 3px 0px 3px;
  padding: 0px;
  border: 0px solid black;
  background-color: white;
  outline: none;
  cursor: pointer;
}
/* -------------------------- */

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
/* ---------------------- */

/* ------warning------- */
.warning-insert {
  display: flex;
  position: fixed;
  left: 45%;
  top: 40%;
  margin: auto;
  width: 250px;
  height: 30px;
  background-color: black;
  color: white;
  justify-content: center;
  align-items: center;
  font-size: 16px;
  border-radius: 3px;
  box-shadow: 2px 2px 2px grey;
}
/* -------------------- */
  .is-visible {
    visibility: hidden;
  }

</style>