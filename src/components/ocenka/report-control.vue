<template>
  <div class="report-control">
    <hr>
    <!-- дата отчета -->
    <input-date-period @input="selectDatePeriod"></input-date-period>

    <!-- блок расширенного фильтра -->
    <div class="report-control-filter" :style="{height: heightFilter + 'px'}">
      <div class="filter-header">
        <div class="filter-header-element">
          Фильтр по умолчанию: Территории - {{ textFilterDistrict }} | Решения - {{ textFilterReshenie }}
        </div>
        <div class="filter-header-element button-build" @click="dropFilter">
          Расширенный фильтр <img src="/img/report-setting.png" >
        </div>
      </div>
      <div class="filter-body">
        <!-- -----блок МРУ----- -->
        <fieldset class="block-checkbox block-checkbox-mru">
          <legend>МРУ (сводно)</legend>
          <div class="blue">
            <label class="rn-title"><input type="checkbox" 
                                                v-model="isCheckAllMRU"
                                                @change="selectMRUAll" >Все</label>
          </div>
          <hr>
          <template v-for="(row, index) in arrListDistrict">
            <div v-if="(+row.ISMRU == 1)" :key="index">
              <label class="rn-row"><input type="checkbox" 
                                           :value="row.MRUID"
                                           :disabled="isDisabledMRU"
                                           v-model="arrFilterMRU"
                                           @change="selectMRU">{{ row.MRUNAME }}</label>
            </div>
          </template>
        </fieldset>
        <!-- блок территориальные органы -->
        <fieldset class="block-checkbox block-checkbox-district">
          <legend>Территориальные органы (отдельно по каждому)</legend>
          <div class="blue">
            <label class="rn-title blue"><input type="checkbox" 
                                                v-model="isCheckAllDistrict"
                                                @change="selectDistrictAll">Все</label>
          </div>
          <hr>
          <div class="two-collumn">
            <template v-for="(row, index) in arrListDistrict">
              <label :key="index" 
                     v-if="(+row.ISMRU == 1)" 
                     class="rn-title"><input type="checkbox" 
                                             :value="row.DISTRICTID"
                                             :disabled="isDisabledDistrict"
                                             v-model="arrFilterDistrict"
                                             @change="selectDistrict" >{{ row.DISTRICTNAME }}</label>
              <label :key="index" 
                     v-else class="rn-row"><input type="checkbox" 
                                                  :value="row.DISTRICTID"
                                                  :disabled="isDisabledDistrict"
                                                  v-model="arrFilterDistrict"
                                                  @change="selectDistrict">{{ row.DISTRICTNAME }}</label>
            </template>
          </div>
        </fieldset>
        <!-- блок решений -->
        <fieldset class="block-checkbox">
          <legend>Вынесенные решения</legend>
          <div class="green">
            <label class="rn-title green"><input type="checkbox" 
                                          v-model="isCheckAllReshenie"
                                          @change="selectReshenieAll" disabled>Все</label> <!--убрать превент-->
          </div>
          <hr>
          <div class="">
            <template v-for="(row, index) in arrListReshenie">
              <label :key="index" class="rn-row rn-row-title"><input type="checkbox"
                                                        :value="row"
                                                        :disabled="isDisabledReshenie"
                                                        v-model="arrFilterReshenie"
                                                        @change="selectReshenie" >{{ row.CNAME }}</label> <!--убрать превент-->
            </template>
          </div>
        </fieldset>
      </div>
    </div>

    <!-- блок события формирование отчета -->
    <div class="report-control-filter">
      <div class="filter-header">
        <div class="filter-header-element">
          <!-- Отчет будет сформирован на дату: {{ dateReportText }} -->
        </div>
        <div class="filter-header-element button-build" @click="buildingReport">
          Построить отчет <img src="/img/report-build.png" >
        </div>
      </div>
    </div>
    <hr>
  </div>
</template>

<script>
import InputDatePeriod from '@/components/elements/input-date-period';

export default {
  name: "ReportControl",
  components: {
    InputDatePeriod,
  },
  props: {
    
  },
  data: function() {
    return {
      heightFilter: 30,
      dateReportStart: '', // дата начала отчета // дата в формате yyyy-mm-dd
      dateReportEnd: '', // дата окончания отчета // дата в формате yyyy-mm-dd
      dateReportText: '..', // дата отчета // дата в формате dd.mm.yyyy ???? надо ли...
      arrListDistrict: [], // список тер.органов,
      arrListReshenie: [],// список решений
      
      arrFilterMRU: [],
      arrFilterDistrict: [],
      arrFilterReshenie: [],
      arrFilterDatePeriod: [],

      isCheckAllMRU: false,
      isCheckAllReshenie: true,
      isCheckAllDistrict: true,

      isDisabledMRU: false,
      isDisabledReshenie: false,
      isDisabledDistrict: false,

      textFilterDistrict: 'Все',
      textFilterReshenie: 'Все',
    }
  },
  created: function() {
    this.ajaxQuery('php/ocenka/ocenka.php', 'function=getListDecision', this.loadDecision);
    this.ajaxQuery('php/ocenka/ocenka.php', 'function=getListDistrict', this.loadDistrict);
  },
  mounted: function() {
  },
  methods: {
    selectDatePeriod: function(dateStart, dateEnd) {
      this.arrFilterDatePeriod = [];
      this.arrFilterDatePeriod.push(dateStart, dateEnd);
    },
    loadDecision: function(arrList){
      this.arrListReshenie = arrList;
      this.selectReshenieAll();
    },
    loadDistrict: function(arrList){
      this.arrListDistrict = arrList;
      //console.log(arrList);
      this.selectDistrictAll();
    },
    selectMRU: function() { // выбор МРУ
      // отключаем фильтр по тер.органам-----
      this.isDisabledDistrict = false;    //|
      this.isCheckAllDistrict = false;    //|
      this.arrFilterDistrict.length = 0;  //|
      // ------------------------------------
      this.textFilterDistrict = 'Определено пользователем';
      this.$emit('selectedMRU', this.arrFilterMRU, true); // 3 arg - тип отчета true -> МРУ
    },
    selectMRUAll: function() { // выбор всех МРУ
      this.arrFilterMRU.length = 0;
      this.isDisabledMRU = !this.isDisabledMRU;
      // отключаем фильтр по тер.органам-----
      this.isDisabledDistrict = false;    //|
      this.isCheckAllDistrict = false;    //|
      this.arrFilterDistrict.length = 0;  //|
      // ------------------------------------
      this.textFilterDistrict = 'Определено пользователем';
      for (let i = 0; i < this.arrListDistrict.length; i++) {
        if (+this.arrListDistrict[i].ISMRU == 1) this.arrFilterMRU.push(this.arrListDistrict[i].MRUID);
      }
      this.$emit('selectedMRU', this.arrFilterMRU, true); // 3 arg - тип отчета true -> МРУ
    },

    selectDistrict: function() { // выбор тер.органов
      // отключаем фильтр по МРУ--------
      this.isDisabledMRU = false;    //|
      this.isCheckAllMRU = false;    //|
      this.arrFilterMRU.length = 0;  //|
      // -------------------------------
      this.textFilterDistrict = 'Определено пользователем';
      this.$emit('selectedDistrict', this.arrFilterDistrict, false); // 3 arg - тип отчета false -> Территория
    },
    selectDistrictAll: function() { // выбор всех тер.органов (по умолчанию)
      this.arrFilterDistrict.length = 0;
      this.isDisabledDistrict = !this.isDisabledDistrict;
      // отключаем фильтр по МРУ--------
      this.isDisabledMRU = false;    //|
      this.isCheckAllMRU = false;    //|
      this.arrFilterMRU.length = 0;  //|
      // -------------------------------
      if (!this.isDisabledDistrict) {return;}
      for (let i = 0; i < this.arrListDistrict.length; i++) this.arrFilterDistrict.push(this.arrListDistrict[i].DISTRICTID);
      this.$emit('selectedDistrict', this.arrFilterDistrict, false); // 3 arg - тип отчета false -> Территория
    },

    selectReshenie: function() { // выбор решения
      this.textFilterReshenie = 'Определено пользователем';
      this.$emit('selectedReshenie', this.arrFilterReshenie); // выбор решений
    },
    selectReshenieAll: function() { // выбор всех решений (по умолчанию)
      this.arrFilterReshenie.length = 0;
      this.isDisabledReshenie = !this.isDisabledReshenie;
      for (let i = 0; i < this.arrListReshenie.length; i++) this.arrFilterReshenie.push(this.arrListReshenie[i]);
      this.$emit('selectedReshenie', this.arrFilterReshenie);
    },

    buildingReport: function() {
      // this.dropFilter();
      this.$emit('buildingReport', this.arrFilterDatePeriod);
    },

    ajaxQuery: function(fileQuery, stringQuery, collBackFunction) { // колбэк функция под вопросом
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + fileQuery, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(stringQuery);
      request.onload = () => {
        collBackFunction(request.response);
        //return request.response;
      };
    },
    dropFilter: function() { // слайдер расширенного отчета
      if (this.heightFilter <= 30) {  //drop down
        let intervalHeight = setInterval(() => {
          if (this.heightFilter > 380) {clearInterval(intervalHeight); return;};
          this.heightFilter = +this.heightFilter + +10;
        }, 2);
      } else if (this.heightFilter >= 380) {  //drop up
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

  .date-period {
    display: flex;
    flex-direction: row;
    justify-content: left;
    align-items: flex-end;
    padding-bottom: 5px;
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
  }
/* ---------------- */

  .filter-body {
    display: flex;
    flex-direction: row;
    width: 100%;
    padding: 5px;
  }
  .block-checkbox {
    height: auto;
    margin-right: 10px;
    border: 1px solid grey;
    padding: 5px;
    font-size: 0.9em;
  }
  .block-checkbox-mru { width: 150px; }

  .block-checkbox label {
    display: block;
    width: 100%;
  }
  input[type="checkbox"] {
    margin-right: 5px;
  }
  .rn-title {
    width: 100%;
    font-style: italic;
    font-weight: bold;
  }
  .blue {width: 100%; background-color: lightblue;}
  .green {width: 100%; background-color: lightgreen;}

  .rn-row {
    margin: 3px 10px;
    font-size: 13px;
  }
  .rn-row-title {margin: 3px 0px;}

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

  @media print {
    .report-control {display: none;}
  }
</style>