<template>
  <div class="date-range" >
    <h5 class="date-range__title">Период формирования отчета</h5>
    <div class="date-range__body">
      <div class="input-body">
        <label class="input-body__title">Начало периода</label>
        <input class="input-body__input" 
               type="date" 
               v-model="dateStart"
               @input="setDateRange" />
      </div>
      <div class="input-body">
        <label class="input-body__title">Окончание периода</label>
        <input class="input-body__input" 
               type="date" 
               v-model="dateEnd"
               @input="setDateRange" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DateRange',
  props: {
  },
  data: function() {
    return {
      dateStart: '',
      dateEnd: '',
      dateRange: [],
    }
  },
  created: function() {
    let dateNow = new Date();
    let mm = (+dateNow.getMonth() < 9) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
    let yyyy = dateNow.getFullYear();
    let dateStart = new Date(yyyy, mm, 0);
    let dd = (+dateStart.getDate() < 10) ? '0' + dateStart.getDate() : dateStart.getDate();

    this.dateEnd = yyyy + '-' + mm + '-' + dd;
    this.dateStart = yyyy + '-' + mm + '-' + '01';
    this.setDateRange();
  },
  methods: {
    setDateRange: function() {
      this.dateRange = [];
      this.dateRange.push(this.dateStart, this.dateEnd);
      this.$emit('input', this.dateRange);
    }
  }
}
</script>

<style lang="scss" scoped>

.date-range {
  display: flex;
  flex-direction: column;
  box-sizing: border-box;
  &__title {
    margin: 0px;
    font-family: 'Open sans';
    font-weight: bold;
    text-transform: uppercase;
  }
  &__body {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
    box-sizing: border-box;
    .input-body {
      position: relative;
      box-sizing: border-box;
      &__title {
        position: absolute;
        display: inline-block;
        left: 6px;
        top: 3px;

        font-size: 10px;
        color: grey;
        text-transform: uppercase;
      }
      &__input {
        width: 140px;
        padding: 3px;
        padding-left: 6px;
        padding-top: 16px;
        border: 1px solid grey;
        outline: none;
        border-radius: 3px;
        box-sizing: border-box;
        font-family: 'Open sans';
      }
    }
  }
}
</style>