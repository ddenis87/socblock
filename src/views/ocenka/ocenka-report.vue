<template>
  <div class='ocenka-report'>
    <div class="report-header">
      <h2 class="report-header__title">Оценка пенсионных прав застрахованного лица</h2>
      <button class="report-header__button" @click="goBase">Перейти к базе</button>
    </div>
    <hr class="separator"/>
    <div class="report__date-and-type">
      <div class="report__date-and-type_box">
        <date-range v-model="arrReportDateRange"></date-range>
      </div>
      <div class="report__date-and-type_box">
        <ocenka-report-type v-model="typeReport"></ocenka-report-type>
      </div>
    </div>
    <div class="report__filter">
      <ocenka-report-filter v-model="arrDistrict" @change="setTypeDistrict"></ocenka-report-filter>
    </div>
    <div class="report__control">
      <ocenka-report-control @build-report="buildReport"></ocenka-report-control>
    </div>
    <hr class="separator"/>
    <div class="report__list">
      <ocenka-report-list v-bind:arrInReport="arrReport"
                          v-bind:arrInReportAll="arrReportAll"></ocenka-report-list>
    </div>


    <div class="warning-insert" :class="{'is-visible' : (isWarning) ? true : false}">
      Не выбран ни один территориальный орган или МРУ
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import dateRange from '@/components/elements/date-range';
import ocenkaReportType from '@/components/units/ocenka/ocenka-report__type';
import ocenkaReportFilter from '@/components/units/ocenka/ocenka-report__filter';
import ocenkaReportControl from '@/components/units/ocenka/ocenka-report__control';
import ocenkaReportList from '@/components/units/ocenka/ocenka-report__list';
export default {
  name: 'OcenkaReport',
  components: {
    dateRange, ocenkaReportType, ocenkaReportFilter, ocenkaReportControl, ocenkaReportList
  },
  data: function() {
    return {
      sumRow: 0,
      typeDistrict: false,
      typeReport: '',
      isWarning: true,
      arrReport: Array, // итоговый отчет [["0", "Благовещенск", "3", "1", ...]] [["MRU", "DISTRICT", "COUNT-DECISION", ...]]
      arrReportAll: Array, //['0','0','0','0','0','0','0','0','0','0','0','0','0',],
      arrReportDateRange: [],
      arrDistrict: [], // значения тер.органов для выбоки данных [ID]
      arrReshenie: [], // столбцы отчета [{ID: '1', CNAME: 'Пример решения'}]
    }
  },
  created: function() {
    axios
      .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDecision'}})
      .then(response => {
        this.arrReshenie = response.data;
      })
  },
  methods: {

    goBase: function() {this.$router.push(`/ocenka`);},
    setTypeDistrict: function(arr, type) {
      this.typeDistrict = type;
    },

    buildReport: function() {
      if (!this.arrDistrict.length) {
        this.isWarning = false;
        setTimeout(() => {this.isWarning = true}, 2000);
        return;
      }
      this.arrReport = [];
      this.arrReportAll = [];
      for (let i = 0; i < this.arrReshenie.length; i++) this.arrReportAll.push('0');
      let requestOption = {
        function: 'buildReport',
        arrDistrict: this.arrDistrict.join(),
        typeDistrict: this.typeDistrict,
        dateStart: this.arrReportDateRange[0],
        dateEnd: this.arrReportDateRange[1],
      };
      switch(this.typeReport) {
        case 'szvk': {
          requestOption.function = 'buildReportType'; 
          requestOption.typeReport = this.typeReport; 
          delete requestOption.typeDistrict;
          break;
        }
        case 'slpriz': {
          requestOption.function = 'buildReportType'; 
          requestOption.typeReport = this.typeReport; 
          delete requestOption.typeDistrict;
          break;
        }
        case 'uhod': {
          requestOption.function = 'buildReportType'; 
          requestOption.typeReport = this.typeReport; 
          delete requestOption.typeDistrict;
          break;
        }
      }
      axios
        .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: requestOption})
        .then(response => {
          let newArrReport = [];
          this.arrReport = response.data;
          for(let i = 0; i < this.arrReport.length; i++) {
            for(let j = 2; j < this.arrReport[i].length; j++) {
              this.arrReportAll[j - 2] = +this.arrReportAll[j - 2] + +this.arrReport[i][j];
            }
          }
        })
    },
  },
}
</script>

<style lang="scss" scoped>
.ocenka-report {
  padding-left: 10px;
  width: 98%;
  font-size: 14px;
  .report {
    padding-left: 10px;
    width: 98%;
    font-size: 14px;
    &-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      &__title { 
        margin: 5px 0px; 
        padding: 0px;
      }
      &__button {
        width: 150px;
        padding: 3px;
      }
    }
    &__date-and-type {
      display: flex;
      padding-top: 5px;
      &_box {
        min-width: 300px;
        &:first-child {
          margin-right: 20px;
        }
      }
    }
  }
}

.separator {
  margin: 0px;
  margin-bottom: 5px;
}

/* ------warning------- */
.warning-insert {
  display: flex;
  position: fixed;
  left: 45%;
  top: 40%;
  margin: auto;
  width: 400px;
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

@media print {
  .report-title__button {display: none;}
}
</style>