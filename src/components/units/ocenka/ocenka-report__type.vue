<template>
  <div class="type-report">
    <h5 class="type-report__title">Тип отчета</h5>
    <div class="type-report__body">
      <div class="select-body">
        <label class="select-body__title">Укажите тип отчета</label>
        <select class="select-body__select">
          <option>Без типа</option>
          <option>Нет "СЗВ-К" - письмо ПФР от 23.04.2020 № СЧ-25-24/8528</option>
          <option>Нет кода "СЛПРИЗ" - письмо ПФР от 12.03.2020 № СЧ-25-24/5350</option>
          <option>Нет периодов "УХОД"  - письмо ПФР от 16.07.2020 № МТ-25-24/14079</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ocenkaReportType',
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
    margin-top: 5px;
    box-sizing: border-box;
    .select-body {
      position: relative;
      width: 100%;
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
        width: 100%;
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
  }
}
</style>