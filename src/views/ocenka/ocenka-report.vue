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
        <ocenka-report-type></ocenka-report-type>
      </div>
    </div>
    <div class="report__filter">
      <ocenka-report-filter v-model="arrDistrict" @change="setReportType"></ocenka-report-filter>
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
      reportType: false,
      isWarning: true,
      arrReport: Array, // итоговый отчет [["0", "Благовещенск", "3", "1", ...]] [["MRU", "DISTRICT", "COUNT-DECISION", ...]]
      arrReportAll: Array, //['0','0','0','0','0','0','0','0','0','0','0','0','0',],
      arrReportDateRange: [],
      arrDistrict: [], // значения тер.органов для выбоки данных [ID]
      arrReshenie: [], // столбцы отчета [{ID: '1', CNAME: 'Пример решения'}]
      arrLetter: [], 
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
    setReportType: function(arr, type) {
      this.reportType = type;
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
        typeFilter: this.reportType,
        dateStart: this.arrReportDateRange[0],
        dateEnd: this.arrReportDateRange[1],
      };

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
        max-width: 500px;
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

  table {
    border-spacing: 0px;
    width: 100%;
    border-collapse: collapse;
  }
  .title-collumn {
    position: relative;
    border-left: 1px solid grey;
    border-bottom: 1px solid grey;
    border-top: 0px solid grey;
    height: 180px;
    width: 40px;
    /* min-width: 40px; */
    vertical-align: bottom;
    overflow: hidden;
  }
  .title-collumn:nth-child(2n) {
    background-color: lightgreen;
  }

  .title-collumn:last-child {
    border-right: 1px solid grey;
  }

  tr {
    border-bottom: 2px solid grey;
  }

  td {
    padding: 5px 0px;
  }
  td:first-child {
    border-right: 2px solid grey;
  }

  .vertical-text {
    position: absolute;
    width: 195px;
    left: 3px;
    border: 0px solid black;
    transform: rotate(-90deg);
    transform-origin: left top 0px;
  }

  .count-content {
    text-align: center;
    border-bottom: 0px solid grey;
  }
  .itog {
    background-color: lightblue;
  }

  .title-row {
    width: 150px;
    max-width: 150px;
    padding-left: 10px;
    border-bottom: 0px solid grey;
  }

  .title-row-mru {
    font-weight: bold;
    background-color: lightblue; /*:cadetblue;*/
  }
  .title-row-mru:first-child {
    font-style: italic;
    padding-left: 5px;
  }

  .table-footer {
    text-align: center;
    background-color: rgb(54, 95, 147);
    color: white;
  }
  .table-footer:first-child {
    text-align: left;
    padding-left: 5px;
  }

  fieldset {border: 1px solid black; padding: 10px;}
  // hr {margin: 2px 0px;}
  .no-m-p {
    margin-top: 0px;
    padding-top: 0px;
  }
  .empty-first {
    border-top: 2px solid grey;
    border-left: 2px solid grey;
    width: 150px;
    max-width: 150px;
    text-decoration: un;
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