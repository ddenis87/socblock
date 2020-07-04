<template>
  <div class="report-control">
    <hr>
    <!-- дата отчета -->
    <input-date widthInput="150px" @input="inputDate" positionLabel="left">Укажите дату на которую необходимо сформировать отчет:</input-date>

    <!-- блок расширенного фильтра -->
    <div class="report-control-filter" :style="{height: heightFilter + 'px'}">
      <div class="filter-header">
        <div class="filter-header-element">
          Фильтр по умолчанию: Решения - Все | Территории - Все
        </div>
        <div class="filter-header-element button-build" @click="dropFilter">
          Расширенный фильтр <img src="/img/report-setting.png" >
        </div>
      </div>
      <div class="filter-body">
        <!-- -----блок МРУ----- -->
        <fieldset class="block-checkbox">
          <legend>МРУ</legend>
          <label class="rn-title"><input type="checkbox" id="ch1">Все (сводно)</label>
          <hr>
          <template v-for="(row, index) in arrDistrict">
            <div v-if="(+row.MRU)" :key="index">
              <label class="rn-row"><input type="checkbox" 
                                           :value="row.ID"
                                           v-model="df">{{ row.CNAME }}</label>
            </div>
          </template>
        </fieldset>
        <!-- блок территориальные органы -->
        <fieldset class="block-checkbox">
          <legend>Территориальные органы</legend>
          <label class="rn-title"><input type="checkbox" id="ch1">Все</label>
          <hr>
          <div class="two-collumn">
            <template v-for="(row, index) in arrDistrict">
              <label :key="index" v-if="(+row.MRU)" class="rn-title"><input type="checkbox" id="">{{ row.CNAME }}</label>
              <label :key="index" v-else class="rn-row"><input type="checkbox" id="">{{ row.CNAME }}</label>
            </template>
          </div>
        </fieldset>
        <!-- блок решений -->
        <fieldset class="block-checkbox">
          <legend>Вынесенные решения</legend>
          <label class="rn-title"><input type="checkbox" id="ch1">Все</label>
          <hr>
          <div class="two-collumn">
            <template v-for="(row, index) in arrReshenie">
              <!-- <label :key="index" v-if="(+row.MRU)" class="rn-title"><input type="checkbox" id="">{{ row.CNAME }}</label> -->
              <label :key="index" class="rn-row"><input type="checkbox" id="">{{ row.CNAME }}</label>
            </template>
          </div>
        </fieldset>
      </div>
    </div>

    <!-- блок события формирование отчета -->
    <div class="report-control-filter">
      <div class="filter-header">
        <div class="filter-header-element">
          Отчет будет сформирован на дату: {{ dateReportText }}
        </div>
        <div class="filter-header-element button-build">
          Построить отчет <img src="/img/report-build.png" >
        </div>
      </div>
    </div>
    <hr>
  </div>
</template>

<script>
import InputDate from '@/components/elements/input-date';

export default {
  name: "ReportControl",
  components: {
    InputDate,
  },
  props: {
    arrDistrict: Array,
    arrReshenie: Array,
  },
  data: function() {
    return {
      heightFilter: 30,
      dateReport: '', // дата отчета // дата в формате yyyy-mm-dd
      dateReportText: '..' // дата отчета // дата в формате dd.mm.yyyy
    }
  },
  created: function() {
  },
  methods: {
    dropFilter: function() {
      if (this.heightFilter <= 30) {  //drop down
        let intervalHeight = setInterval(() => {
          if (this.heightFilter > 360) {clearInterval(intervalHeight); return;};
          this.heightFilter = +this.heightFilter + +10;
        }, 2);
      } else if (this.heightFilter >= 360) {  //drop up
        let intervalHeight = setInterval(() => {
          if (this.heightFilter <= 30) {clearInterval(intervalHeight); return;};
          this.heightFilter = +this.heightFilter - +10;
        }, 2);
      }
    },
    // выбор(установка) даты отчета
    inputDate(inputDate) {
      this.dateReport = inputDate; // дата в формате yyyy-mm-dd
      this.dateReportText = inputDate.substr(8, 2) + '.' + 
                            inputDate.substr(5, 2) + '.' + 
                            inputDate.substr(0, 4); // дата в формате dd.mm.yyyy
    }
  },
}
</script>

<style scoped>
  .report-control {
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  hr {
    margin: 5px 0px;
  }
/* -----filter----- */
  .report-control-filter {
    width: 100%;
    height: 30px;
    margin: 10px 0px;
    border: 1px solid grey;
    overflow: hidden;
  }
  .filter-header {
    display: flex;
    height: 30px;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    border: 0px solid grey;
  }

  .filter-header-element:first-child {
    color: grey;
    padding-left: 10px;
  }
  .filter-header-element:last-child {
    display: flex;
    width: 200px;
    height: 30px;
    padding: 0px 10px;
    justify-content: space-between;
    align-items: center;
    color: white;
    font-size: 13px;
    text-transform: uppercase;
    border-left: 1px solid grey;
    background-color: rgb(54, 95, 147);
    box-sizing: border-box;
    cursor: pointer;
  }
  .filter-header-element img {
    width: 20px;
    height: 20px;
    margin: 0px;
    /* margin-left: 8px; */
  }
/* ---------------- */

  .filter-body {
    display: flex;
    flex-direction: row;
    width: 100%;
    padding: 5px;

  }
  .block-checkbox {
    min-width: 180px;
    height: auto;
    margin-right: 10px;
    border: 1px solid grey;
    padding: 5px;
  }
  .block-checkbox label {
    display: block;
    width: 163px;
  }
  input[type="checkbox"] {
    margin-right: 5px;
  }
  .rn-title {
    margin: 5px 3px;
    font-style: italic;
    font-weight: bold;
  }
  .rn-row {
    margin: 5px 10px;
    font-size: 13px;
  }

  .two-collumn {
    column-count: 2;
  }

  .button-build img {
    transform: rotate(-90deg);
    transition: 1s transform;
  }

  .button-build:hover img {
    transform: rotate(45deg);
  }
</style>