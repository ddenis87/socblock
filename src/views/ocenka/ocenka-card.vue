<template>
  <div class="ocenka-card">
    <div class="ocenka-card-title">
      <!-- <div class="ocenka-card-title__title"> -->
        <h2 class="ocenka-card-title__title">Сведения о застрахованном лице: <i class="ocenka-card-title__title-black">{{ arrDataPerson[0].SNILS }}</i></h2>
      <!-- </div> -->
      <button class="title__button" @click="goBack">Вернуться</button>
    </div>

    <table>
      <tr><td width="50%">Застрахованное лицо:</td><td>{{ arrDataPerson[0].FA + " " + arrDataPerson[0].IM + " " + arrDataPerson[0].OT}}</td></tr>
      <tr><td>Дата рождения:</td><td>{{ arrDataPerson[0].BIRTHDAY }}</td></tr>
      <tr>
        <td>Наименование территориального органа:</td>
        <td>
          <select class="select-mru" 
                  
                  v-model="districtId"
                  @change="changeMru"
                   :class="{}"><!--:disabled="!access" -->
            <option v-for="(row, index) in arrDistrict" :key="index" :value="row.DISTRICTID">{{ row.DISTRICTNAME }}</option>
          </select>
        </td>
      </tr>
      <!-- <tr><td>Наименование территориального органа:</td><td>{{ arrDataPerson[0].NAME_DISTRICT }}</td></tr> -->
      <tr><td>Наименование МРУ:</td><td>{{ (arrDataPerson[0].NAME_MRU) ? arrDataPerson[0].NAME_MRU : 'Является МРУ' }}</td></tr>

      <tr><td>Работающий:</td><td>{{ (+arrDataPerson[0].JOB) ? 'Да' : 'Нет' }}</td></tr>
      <tr><td>Включен в список "СЗВ-К":</td><td>{{ (+arrDataPerson[0].SZVK) ? 'Да' : 'Нет' }}</td></tr>
      <tr><td>Включен в список "СлПриз":</td><td>{{ (+arrDataPerson[0].SLPRIZ) ? 'Да' : 'Нет' }}</td></tr>
      <tr><td>Уход:</td><td>{{ (+arrDataPerson[0].UHOD) ? 'Да' : 'Нет' }}</td></tr>
    </table>
    <div class="person-control" :class="{'person-control_warning' : !isPersonControl}" > <!-- v-if="(access)" -->
      <div class="person-control__item person-control__item_hidden" :class="{'person-control__item_warning' : !isPersonControl}">Изменения не сохранены</div>
      <div class="person-control__item" :class="{'person-control_warning' : !isPersonControl}"><button class="person-control__button" :disabled="isPersonControl" @click="savePerson">Сохранить</button></div>
    </div>

    <div class="title">
      <h2>Сведения об обработке</h2>
    </div>
    <div class="sved">
      <hr>
      <div class="sved-control" > <!--v-if="(access)" access - может сразу использовать глобальную переменную -->
        
        <label for="">Укажите результат:</label>
        <select v-model="decisionId">
          <option value="" selected disabled>Выберите результат из списка</option>
          <option v-for="(rowList, index) in arrList" 
                  :key="index" 
                  :value='rowList.ID'>{{ rowList.CNAME }}</option>
        </select>
        <button @click="insertHistoryRecord">Добавить результат</button>
        
      </div>
      <hr>
      <table>
        <tr>
          <th width="280px">Специалист</th>
          <th width="85px">Дата</th>
          <th>Результат</th>
          <th width="30px">Действие</th>
        </tr>
        <tr v-for="(rowDataHistory, index) in arrDataHistory" :key="index">
          <td>{{ rowDataHistory.SPEC }}</td>
          <td>{{ modDate(rowDataHistory.CDATE),  }}</td>
          <td>{{ rowDataHistory.DECISION }}</td>
          <td align="center"><img v-if="administrator" 
                                  src="img/button-row-delete.png" 
                                  class="button-row-control" 
                                  title="Удалить запись" 
                                  @click="deleteHistoryRecord(rowDataHistory.ID)"  /></td>
        </tr>
      </table>
      <p>{{ selectEmpty }}</p>
    </div>
    <div class="progress-load" :class="{'is-visible' : (isLoad) ? true : false}">
      <img src="img/load.gif">
    </div>
    <div class="warning-insert" :class="{'is-visible' : (isWarning) ? true : false}">
      {{ warningText }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'CardPerson',
  computed: {
    //access() { return this.$store.state.userProfile.accessResource.ocenka.access; },
    administrator() { return this.$store.state.userProfile.accessResource.ocenka.administrator; }
  },
  data: function() {
    return {
      arrMonth: ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'],
      arrDataPerson: [['','','','','','','','']],
      arrDataHistory: [['','','']],
      arrList: [],
      arrDistrict: [],
      isLoad: true, 
      isWarning: true,
      isPersonControl: true,
      personId: decodeURI(window.location.search.slice(window.location.search.indexOf("=") + 1)),
      // access: accessUser,
      decisionId: '',
      districtId: '',
      selectEmpty: '',
      warningText: '',
    }
  },
  methods: {
    modDate: function(val) {
      let nVal = String(val);
      let nDay = nVal.slice(0,2);
      let nMonth = ((this.arrMonth.indexOf(nVal.slice(3,6)) + 1) < 10) ? '0' + String(this.arrMonth.indexOf(nVal.slice(3,6)) + 1) : String(this.arrMonth.indexOf(nVal.slice(3,6)) + 1);
      let nYear = '20' + String(nVal.slice(7,9));
      nVal = nDay + '.' + nMonth + '.' + nYear;
      return nVal;
    },
    goBack: function() {
      this.$router.push(`/ocenka`);
    },
    changeMru: function() {
      this.isPersonControl = false;
    },
    savePerson: function() {
      this.isLoad = false;
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.send(`function=changePerson&personId=${this.personId}&districtId=${this.districtId}`);
      request.onload = () => {
        this.loadInfo();
        this.isPersonControl = true;
        this.isLoad = true;
      }
    },
    insertHistoryRecord: function() {
      if(this.decisionId != '') {
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
        this.warningText = 'Не указано решение!';
        this.isWarning = false;
        setTimeout(() => { this.isWarning = true }, 1200);
      }
    },
    deleteHistoryRecord: function(param) {
      // if (accessUserAdmin == true) {
        this.isLoad = false;
        let request = new XMLHttpRequest();
        request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(`function=deleteHistory&historyId=${param}`);
        request.onload = () => {
          this.loadHistory();
          this.isLoad = true;
          if (request.response == '1') {alert("Запись удалена");}
          else {alert("БД: Ошибка удаления");}
        }
      // } else {
      //   this.warningText = 'Нет прав на удаление!';
      //   this.isWarning = false;
      //   setTimeout(() => { this.isWarning = true }, 1500);
      // }
    },
    loadDistrict: function() {
      axios
        .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDistrict'}})
        .then(response => {
          this.arrDistrict = response.data;
        })
    },
    loadInfo: function() {
      let requestOption = {
        function: 'getPersonInfo',
        personId: this.personId
      }
      axios
        .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: requestOption})
        .then(response => {
          this.arrDataPerson = response.data;
          this.districtId = this.arrDataPerson[0].ID_DISTRICT;
        })
    },
    loadHistory: function() {
      let requestOption = {
        function: 'getPersonHistiry',
        personId: this.personId
      }
      axios
        .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: requestOption})
        .then(response => {
          this.arrDataHistory = response.data;
          if (this.arrDataHistory.length == 0) this.selectEmpty = 'Записи отсутствуют';
        })
    },
  },
  created: function() {
    this.isLoad = false;
    // load list district
    this.loadDistrict();
    // load person info
    this.loadInfo();
    // load history
    this.loadHistory();
    // load list reshenie if user access
    // if(this.access) {
      // this.isLoad = false;
    axios
      .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDecision'}})
      .then(response => {
        this.arrList = response.data;
      })
    // }
    this.isLoad = true;
  }
}
</script>

<style lang="scss" scoped>
.ocenka-card {
  padding-left: 10px;
  width: 98%;
  font-size: 14px;
  &-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    &__title {
      margin: 5px 0px;
      padding: 0px;
      &-black { color: black;}
    }
    &__button {
      width: 150px;
      padding: 3px;
    }
  }
}
</style>

<style scoped>
  /* h2 {margin: 0px; margin-right: 10px;font-size: 18px;} */

  /* ------table------ */
  table {
    width: 100%;
    margin: 10px 0px;
    margin-bottom: 5px;
    font-size: 16px;
    border-spacing: 0px;
  }

  th {text-align: left; background-color: rgb(54, 95, 147); color: white; padding: 3px;}
  td {
    padding: 5px;
    border-bottom: 2px solid grey;
  }

  td:last-child {font-style: italic;}
/* ------------------------- */

/* table select-mru */
  .select-mru {
    font-style: italic;
    font-size: 14px;
    padding: 3px;
    margin-left: -8px;
    border: 0px;
  }

/* ---------------- */

/* --- person-control --- */
  .person-control {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .person-control_warning {
    background-color: red;
    color: white;
  }
  .person-control__item_hidden {
    padding-left: 10px;
    visibility: hidden;
  }
  .person-control__item_warning {
    visibility: visible;
  }
/* --------------- */

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
    max-width: 550px;
    margin-right: 10px;
    padding: 2px;
  }

  button {
    width: 150px;
    padding: 3px;
  }
  
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