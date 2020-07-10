<template>
<div class="input-date" >
  <div class="date-title">
    Период формирования отчета
  </div>
  <div class="date-box">
    <label>Начало периода</label>
    <input type="date" 
           v-model="dateReportStart"

           @input="inputDate" >
  </div>
  <div class="date-box">
    <label>Окончание периода</label>
    <input type="date" 
           v-model="dateReportEnd"
 
           @input="inputDate" >
  </div>
</div>
</template>

<script>
export default {
  name: 'InputDatePeriod',
  props: {
  },
  data: function() {
    return {
      dateReportStart: '',
      dateReportEnd: '',
    }
  },
  created: function() {
    let dateNow = new Date();
    let mm = (+dateNow.getMonth() < 10) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
    let yyyy = dateNow.getFullYear();
    let dateStart = new Date(yyyy, mm, 0);
    let dd = (+dateStart.getDate() < 10) ? '0' + dateStart.getDate() : dateStart.getDate();

    this.dateReportEnd = yyyy + '-' + mm + '-' + dd;
    this.dateReportStart = yyyy + '-' + mm + '-' + '01';
    this.inputDate();
  },
  methods: {
    inputDate: function() {
      this.$emit('input', this.dateReportStart, this.dateReportEnd);
    }
  }
}
</script>

<style scoped>
.input-date {
  display: flex;
  border: 0px solid grey;
  font-size: 16px;
  align-items: flex-end;
}

.date-title {
  margin-bottom: 5px;
  margin-right: 5px;
}

.date-box {
  position: relative;
  margin: 0px 5px;
}

.date-box label {
  position: absolute;
  display: inline-block;
  left: 5px;
  top: 3px;

  font-size: 12px;
  color: grey;
}

input[type="date"] {
  width: 140px;
  padding: 3px;
  padding-left: 6px;
  padding-top: 20px;
  border: 1px solid grey;
  outline: none;
  border-radius: 3px;
}

</style>