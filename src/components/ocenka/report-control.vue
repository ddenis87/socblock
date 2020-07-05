<template>
  <div class="report-control">
    <hr>
    <!-- дата отчета -->
    <input-date widthInput="150px" @input="inputDate" positionLabel="left">Укажите дату на которую необходимо сформировать отчет:</input-date>

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
        <fieldset class="block-checkbox">
          <legend>МРУ</legend>
          <div class="blue">
            <label class="rn-title"><input type="checkbox" 
                                                v-model="isCheckAllMRU"
                                                @change="selectMRUAll" >Все (сводно)</label>
          </div>
          <hr>
          <template v-for="(row, index) in arrListDistrict">
            <div v-if="(+row.MRU == 0)" :key="index">
              <label class="rn-row"><input type="checkbox" 
                                           :value="row.ID"
                                           :disabled="isDisabledMRU"
                                           v-model="arrFilterMRU"
                                           @change="selectMRU">{{ row.CNAME }}</label>
            </div>
          </template>
        </fieldset>
        <!-- блок территориальные органы -->
        <fieldset class="block-checkbox">
          <legend>Территориальные органы</legend>
          <div class="blue">
            <label class="rn-title blue"><input type="checkbox" 
                                                v-model="isCheckAllDistrict"
                                                @change="selectDistrictAll">Все</label>
          </div>
          <hr>
          <div class="two-collumn">
            <template v-for="(row, index) in arrListDistrict">
              <label :key="index" 
                     v-if="(+row.MRU == 0)" 
                     class="rn-title"><input type="checkbox" 
                                             :value="row.ID"
                                             :disabled="isDisabledDistrict"
                                             v-model="arrFilterDistrict"
                                             @change="selectDistrict" >{{ row.CNAME }}</label>
              <label :key="index" 
                     v-else class="rn-row"><input type="checkbox" 
                                                  :value="row.ID"
                                                  :disabled="isDisabledDistrict"
                                                  v-model="arrFilterDistrict"
                                                  @change="selectDistrict">{{ row.CNAME }}</label>
            </template>
          </div>
        </fieldset>
        <!-- блок решений -->
        <fieldset class="block-checkbox">
          <legend>Вынесенные решения</legend>
          <div class="green">
            <label class="rn-title green"><input type="checkbox" 
                                          v-model="isCheckAllReshenie"
                                          @change="selectReshenieAll">Все</label>
          </div>
          <hr>
          <div class="two-collumn">
            <template v-for="(row, index) in arrListReshenie">
              <label :key="index" class="rn-row"><input type="checkbox"
                                                        :value="row"
                                                        :disabled="isDisabledReshenie"
                                                        v-model="arrFilterReshenie"
                                                        @change="selectReshenie" >{{ row.CNAME }}</label>
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
        <div class="filter-header-element button-build" @click="buildingReport">
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
    
  },
  data: function() {
    return {
      heightFilter: 30,
      dateReport: '', // дата отчета // дата в формате yyyy-mm-dd
      dateReportText: '..', // дата отчета // дата в формате dd.mm.yyyy
      arrListDistrict: [ // список тер.органов
          {ID: '1',   CNAME: 'Благовещенск',         MRU: '0'},
          {ID: '2',   CNAME: 'Ивановка',             MRU: '1'},
          {ID: '3',   CNAME: 'Тамбовка',             MRU: '1'},
          {ID: '4',   CNAME: 'Константиновка',       MRU: '1'},
          {ID: '5',   CNAME: 'Белогорск',            MRU: '0'},
          {ID: '6',   CNAME: 'Зея',                  MRU: '1'},
          {ID: '7',   CNAME: 'Тында',                MRU: '1'},
          {ID: '8',   CNAME: 'Октябрьский район',    MRU: '1'},
          {ID: '9',   CNAME: 'Ромненский район',     MRU: '1'},
          {ID: '10',  CNAME: 'Серышевский район',    MRU: '1'},
          {ID: '11',  CNAME: 'Райчихинск',           MRU: '0'},
          {ID: '12',  CNAME: 'Архаринский район',    MRU: '1'},
          {ID: '13',  CNAME: 'Бурейский',            MRU: '1'},
          {ID: '14',  CNAME: 'Завитинский район',    MRU: '1'},
          {ID: '15',  CNAME: 'Михайловский район',   MRU: '1'},
          {ID: '16',  CNAME: 'Свободный',            MRU: '0'},
          {ID: '17',  CNAME: 'Шимановский район',    MRU: '1'},
          {ID: '18',  CNAME: 'Магдагачинский район', MRU: '1'},
          {ID: '19',  CNAME: 'Мазановский район',    MRU: '1'},
          {ID: '20',  CNAME: 'Селемджинский район',  MRU: '1'},
          {ID: '21',  CNAME: 'Сковородинский район', MRU: '1'},
        ],
      arrListReshenie: [ // список решений
        {ID: '1', CNAME: 'Корректировка СНИЛС'},
        {ID: '2', CNAME: 'Не служил'},
        {ID: '3', CNAME: 'Отправлено уведомление страхователю на прием'},
        {ID: '4', CNAME: 'Направлен межведомственный запрос'},
        {ID: '5', CNAME: 'Отправлено уведомление страхователю'},
        {ID: '6', CNAME: 'Направлено приглашение гражданину'},
        {ID: '7', CNAME: 'Направлено приглашение гражданину'},
        {ID: '8', CNAME: 'Направлено приглашение гражданину'},
        {ID: '9', CNAME: 'Направлено приглашение гражданину'},
        {ID: '10', CNAME: 'Направлено приглашение гражданину'},
        {ID: '11', CNAME: 'Направлено приглашение гражданину'},
        {ID: '12', CNAME: 'Направлено приглашение гражданину'},
        {ID: '13', CNAME: 'Направлено приглашение гражданину'},
        {ID: '14', CNAME: 'Направлено приглашение гражданину'},
        {ID: '15', CNAME: 'Направлено приглашение гражданину'},
        // {ID: '16', CNAME: 'Направлено приглашение гражданину'},
        // {ID: '17', CNAME: 'Направлено приглашение гражданину'},
        // {ID: '18', CNAME: 'Направлено приглашение гражданину'},
        // {ID: '19', CNAME: 'Направлено приглашение гражданину'},
        // {ID: '20', CNAME: 'Направлено приглашение гражданину'},
      ],
      arrFilterMRU: [],
      arrFilterDistrict: [],
      arrFilterReshenie: [],

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
    //this.arrListDistrict = this.ajaxQuery('php/ocenka-report.php', 'function=getListDistrict');
    //this.arrListReshenie = this.ajaxQuery('php/ocenka-report.php', 'function=getListReshenie');

    this.selectReshenieAll(); // отмечаем все решения по умолчанию
    this.selectDistrictAll(); // отмечаем все тер.органы по умолчанию
  },
  methods: {
    selectMRU: function() { // выбор МРУ
      // отключаем фильтр по тер.органам-----
      this.isDisabledDistrict = false;    //|
      this.isCheckAllDistrict = false;    //|
      this.arrFilterDistrict.length = 0;  //|
      // ------------------------------------
      this.textFilterDistrict = 'Определено пользователем';
      this.$emit('selectedMRU', this.arrFilterMRU);
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
        if (+this.arrListDistrict[i].MRU == 0) this.arrFilterMRU.push(this.arrListDistrict[i].ID);
      }
      this.$emit('selectedMRU', this.arrFilterMRU);
    },

    selectDistrict: function() { // выбор тер.органов
      // отключаем фильтр по МРУ--------
      this.isDisabledMRU = false;    //|
      this.isCheckAllMRU = false;    //|
      this.arrFilterMRU.length = 0;  //|
      // -------------------------------
      this.textFilterDistrict = 'Определено пользователем';
      this.$emit('selectedDistrict', this.arrFilterDistrict);
    },
    selectDistrictAll: function() { // выбор всех тер.органов (по умолчанию)
      this.arrFilterDistrict.length = 0;
      this.isDisabledDistrict = !this.isDisabledDistrict;
      // отключаем фильтр по МРУ--------
      this.isDisabledMRU = false;    //|
      this.isCheckAllMRU = false;    //|
      this.arrFilterMRU.length = 0;  //|
      // -------------------------------
      for (let i = 0; i < this.arrListDistrict.length; i++) this.arrFilterDistrict.push(this.arrListDistrict[i].ID);
      this.$emit('selectedDistrict', this.arrFilterDistrict);
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
      this.$emit('buildingReport', this.dateReport);
    },

    ajaxQuery: function(fileQuery, stringQuery, collBackFunction) { // колбэк функция под вопросом
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + fileQuery, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(stringQuery);
      request.onload = () => {
        return request.response;
      };
    },
    dropFilter: function() { // слайдер расширенного отчета
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
    width: 100%;
    /* margin: 5px 3px; */
    font-style: italic;
    font-weight: bold;
  }
  .blue {width: 100%; background-color: lightblue;}
  .green {width: 100%; background-color: lightgreen;}

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