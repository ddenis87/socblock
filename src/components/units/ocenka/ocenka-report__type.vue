<template>
  <div class="type-report">
    <h5 class="type-report__title">Тип отчета</h5>
    <div class="type-report__body">
      <div class="select-body">
        <label class="select-body__title">Укажите тип отчета</label>
        <select class="select-body__select">
          <option>Все</option>
          <option>СЗВ-К</option>
          <option>СлПриз</option>
          <option>Уход</option>
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
        padding-bottom: 4px;
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