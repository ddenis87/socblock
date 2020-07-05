<template>
  <div class='report'>
    <div class="title">
      <h2>Оценка пенсионных прав - Отчеты</h2>
    </div>
    <report-control @selectedMRU="selectedMRU"
                    @selectedDistrict="selectedDistrict"
                    @selectedReshenie="selectedReshenie"
                    @buildingReport="buildingReport"></report-control>

    <fieldset>
      <legend>Вариант 1</legend>
      <table>
        <!-- столбцы - вынесенные решения -->
        <tr>
          <td class="empty-first"></td>
          <td v-for="(row, index) in arrReshenie" 
              :key="index" 
              class="title-collumn"><div class="vertical-text">{{ row.CNAME }}</div>
          </td>
          <td class="title-collumn"><div class="vertical-text">Всего вынесено решений</div></td>
        </tr>
        <!-- <tr :key="index + 1000"><td class="no-m-p" :colspan="arrDistrict.length"><hr></td></tr> -->
        <!-- ---------------------------- -->

        <!-- ----------------строки - тер.органы---------------- -->
        <template v-for="(row, index) in arrReport">
          <tr :key="index" >
            <td class="title-row" :class="{'title-row-mru': (!+row[0]) ? true : false }" >{{ row[1] }}</td>
            <td v-for="(col, indexCol) in arrReshenie.length" 
                :key="indexCol + 2"
                class="count-content"
                :class="{'title-row-mru': (!+row[0]) ? true : false }">{{ row[indexCol + 2] }}</td>
            <td class="count-content"
                :class="{'title-row-mru': (!+row[0]) ? true : false }">{{ sumCollumn(row) }}</td>
            <!-- <td class="title-row" >{{ row.CNAME }}</td>
            <td class="count-content">{{ row.R1 }}</td>
            <td class="count-content">{{ row.R2 }}</td>
            <td class="count-content">{{ row.R3 }}</td>
            <td class="count-content">{{ +row.R1 + +row.R2 + +row.R3 }}</td> -->
          <!-- ------------------------------------------------ -->
 
        </tr>
        <!-- <tr :key="index + 1000"><td :colspan="arrDistrict.length"><hr></td></tr> -->
      </template>
      <tr>
        <td>Итого по решениям:</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      </table>
    </fieldset>
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
      // textFilterDistrict: 'Все',
      // textFilterReshenie: 'Все',
      sumRow: 0,
      arrReport: [
        ['0', 'Благовещенск',        '2',  '45', '76', '11',   '0',   '77'], //
        ['1', 'Тамбовка',            '5',  '1',  '2',  '2',    '0',   '6'],  // [MRU, NAME-DISTRICT, COUNT(), ..., arrReshenie.length]
        ['1', 'Селемджинский район', '3',  '9',  '1',  '8',    '4',   '4'],  //
        ['1', 'Экимчан',             '0',  '4',  '5',  '4',    '1',   '3'],  //
        ['0', 'Белогорск',           '2',  '2',  '2',  '2',    '2',   '1'],  //
      ], // результат запроса []
      arrDistrict: [], // значения тер.органов для выбоки данных [ID]
      arrReshenie: [], // столбцы отчета [{ID: '1', CNAME: 'Пример решения'}]
    }
  },
  methods: {
    sumCollumn: function(rowValue) {
      let sum = 0;
      for (let i = 2; i < rowValue.length; i++) {
        sum += +rowValue[i];
      }
      return sum;
    },
    selectedMRU: function(arrValue) {this.arrDistrict = arrValue;}, // событие фильтра
    selectedDistrict: function(arrValue) {this.arrDistrict = arrValue;}, // событие фильтра
    selectedReshenie: function(arrValue) {this.arrReshenie = arrValue;}, // событие фильтра

    buildingReport: function(dateReport) {
      console.log(dateReport);
      console.log(this.arrDistrict);
    },
  },
  created: function() {
    console.log(this.arrReport);
  }
}
</script>

<style scoped>
.report {
    padding-left: 10px;
    width: 100%;
    max-width: 1000px;
    font-size: 14px;
  }
  table {
    border-spacing: 0px;
    width: 100%;
    border-collapse: collapse;
  }
  .title-collumn {
    border-left: 1px solid grey;
    border-bottom: 1px solid grey;
    border-top: 2px solid grey;
    height: 180px;
    min-width: 40px;
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
    margin: 0px;
    padding: 5px 0px;
    /* border: 0px solid black;
    border-left: 0px solid cadetblue;
    border-right: 0px solid cadetblue; */
  }
  td:first-child {
    border-right: 2px solid grey;
  }

  .vertical-text {
    display: flex;
    height: 100%;
    width: 40px;
    writing-mode: sideways-lr;
    border: 0px solid black;
    align-items: center;
  }

  .count-content {
    text-align: center;
    border-bottom: 0px solid grey;
  }

  .title-row {
    width: 150px;
    padding-left: 10px;
    border-bottom: 0px solid grey;
  }

  .title-row-mru {
    font-weight: bold;
    font-style: italic;
    padding-left: 5px;
    background-color: lightblue; /*:cadetblue;*/
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

  }
</style>