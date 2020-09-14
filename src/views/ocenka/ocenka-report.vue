<template>
  <div class='report'>
    <div class="report-title">
      <h2 class="report-title__title">Оценка пенсионных прав застрахованного лица</h2>
      <button class="report-title__button" @click="goBase">Перейти к базе</button>
    </div>
    <report-control @selectedMRU="selectedMRU"
                    @selectedDistrict="selectedDistrict"
                    @selectedReshenie="selectedReshenie"
                    @buildingReport="buildingReport"></report-control>

    <fieldset>
      <!-- <legend>Отчет</legend> -->
      <table>
        <!-- столбцы - вынесенные решения -->
        <tr>
          <td class="empty-first"></td>
          <td v-for="(row, index) in arrReshenie" 
              :key="index" 
              class="title-collumn"><div class="vertical-text">{{ row.CNAME }}</div>
          </td>
          <td class="title-collumn"><div class="vertical-text">Всего вынесено результатов работы</div></td>
        </tr>
        <!-- ---------------------------- -->

        <!-- ----------------строки - тер.органы---------------- -->
        <template v-for="(row, rowIndex) in arrReport">
            <tr :key="rowIndex">
              <td class="title-row" :class="{'title-row-mru': (+row[0]) ? true : false }" >{{ row[1] }}</td>
              
                 <td v-for="col in arrReshenie.length" 
                     :key="col + 1000"
                     class="count-content"
                     :class="{'title-row-mru': (+row[0]) ? true : false }">{{ (row[col + 1]) ? row[col + 1] : '0' }}</td> 
              
              <td class="count-content itog"
                :class="{'title-row-mru': (+row[0]) ? true : false }">{{ sumCollumn(row) }}</td>
            </tr>
        </template>
        <!-- ------------------------------------------------ -->
        <tr>
          <td class="table-footer">Всего по территориям</td>
          <template v-for="(row, index) in arrReportAll">
            <td  :key="index"
                 class="table-footer">{{ row }}</td>
          </template>
          <td class="table-footer">{{ sumItog(arrReportAll) }}</td>
        </tr>
        <tr>

        </tr>
      </table>
    </fieldset>
    <div class="warning-insert" :class="{'is-visible' : (isWarning) ? true : false}">
      Не выбран ни один территориальный орган или МРУ
    </div>
  </div>
</template>

<script>
import ReportControl from '@/components/ocenka/report-control';
export default {
  name: 'OcenkaReport',
  components: {
    ReportControl,
  },
  data: function() {
    return {
      sumRow: 0,
      typeFilter: false,
      isWarning: true,
      arrReport: Array, // итоговый отчет [["0", "Благовещенск", "3", "1", ...]] [["MRU", "DISTRICT", "COUNT-DECISION", ...]]
      arrReportAll: Array, //['0','0','0','0','0','0','0','0','0','0','0','0','0',],
      arrDistrict: [], // значения тер.органов для выбоки данных [ID]
      arrReshenie: [], // столбцы отчета [{ID: '1', CNAME: 'Пример решения'}]
    }
  },
  methods: {
    sumItog: function(rowValue) {
      let sum = 0;
      for (let i = 0; i < rowValue.length; i++) {
        if (rowValue[i]) {
          sum += +rowValue[i];
        }
      }
      return sum;
    },
    sumCollumn: function(rowValue) {
      let sum = 0;
      for (let i = 2; i < rowValue.length; i++) {
        if (rowValue[i]) {
          sum += +rowValue[i];
        }
      }
      return sum;
    },
    goBase: function() {this.$router.push(`/ocenka`);},
    selectedMRU: function(arrValue, typeFilter) {this.arrDistrict = arrValue; this.typeFilter = typeFilter; /*console.log(this.typeFilter);*/ }, // событие фильтра
    selectedDistrict: function(arrValue, typeFilter) {this.arrDistrict = arrValue; this.typeFilter = typeFilter; /*console.log(this.typeFilter);*/ }, // событие фильтра
    selectedReshenie: function(arrValue) {this.arrReshenie = arrValue;}, // событие фильтра

    buildingReport: function(dateReport) {
      if (!this.arrDistrict.length) {
        this.isWarning = false;
        setTimeout(() => {this.isWarning = true}, 2000);
        return;
      }
      this.arrReport = [];
      this.arrReportAll = [];
      for (let i = 0; i < this.arrReshenie.length; i++) this.arrReportAll.push('0');

      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(`function=buildReport&arrDistrict=${this.arrDistrict}&typeFilter=${this.typeFilter}&dateStart=${dateReport[0]}&dateEnd=${dateReport[1]}`);
      request.onload = () => {
        let newArrReport = [];
        this.arrReport = request.response;
        for(let i = 0; i < this.arrReport.length; i++) {
          for(let j = 2; j < this.arrReport[i].length; j++) {
            this.arrReportAll[j - 2] = +this.arrReportAll[j - 2] + +this.arrReport[i][j];
          }
        }
      }
    },
  },
  created: function() {
    //console.log(this.arrReport);
  }
}
</script>

<style lang="scss" scoped>
.report {
    padding-left: 10px;
    width: 98%;
    // max-width: 1000px;
    font-size: 14px;
    &-title {
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
  hr {margin: 2px 0px;}
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

// button {
//     width: 150px;
//     padding: 3px;
//   }

  @media print {
    .print {display: none;}
  }
</style>