<template>
  <div class="type-report">
    <h5 class="type-report__title">Тип отчета</h5>
    <div class="type-report__body">
      <div class="select-body">
        <label class="select-body__title">Укажите тип отчета</label>
        <select class="select-body__select" v-model="typeReport" @change="setTypeReport">
          <option value="empty">Без типа</option>
          <option value="szvk">Нет "СЗВ-К" - письмо ПФР от 23.04.2020 № СЧ-25-24/8528</option>
          <option value="slpriz">Нет кода "СЛПРИЗ" - письмо ПФР от 12.03.2020 № СЧ-25-24/5350</option>
          <option value="uhod">Нет периодов "УХОД"  - письмо ПФР от 16.07.2020 № МТ-25-24/14079</option>
        </select>
      </div>
      <span class="select-warning" :class="{'select-warning_show' : (this.typeReport == 'empty') ? false : true}">Отчет по типу доступен только в разрезе территориальных органов</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ocenkaReportType',
  model: {
    event: 'change'
  },
  data: function() {
    return {
      typeReport: 'empty',
    }
  },
  created: function() {
    this.setTypeReport();
  },
  methods: {
    setTypeReport: function() {
      this.$emit('change', this.typeReport)
    },
  }
}
</script>

<style lang="scss" scoped>
.type-report {
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
    align-items: center;
    margin-top: 5px;
    box-sizing: border-box;
    .select-body {
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
      &__select {
        width: auto;
        padding: 3px;
        padding-left: 3px;
        padding-top: 15px;
        padding-bottom: 2px;
        border: 1px solid grey;
        outline: none;
        border-radius: 3px;
        box-sizing: border-box;
        font-family: 'Open sans';
      }
    }
    .select-warning {
      padding-left: 20px;
      font-family: 'Open sans';
      font-size: 12px;
      color: darkred;
      visibility: hidden;
      &_show {
        visibility: visible;
      }
    }
  }
}
</style>