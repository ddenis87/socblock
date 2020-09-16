<template>
  <div class="control">
    <div class="control-header">
      <div class="control-header__title">
        <!-- Отчет будет сформирован на дату: {{ dateReportText }} -->
      </div>
      <button class="control-header__button" @click="buildingReport">Построить отчет</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ocenkaReportControl',
}
</script>

<style lang="scss" scoped>
.control {
  width: 100%;
  height: 30px;
  margin: 10px 0px;
  border: 1px solid grey;
  overflow: hidden;
  box-sizing: border-box;
  &-header {
    display: flex;
    height: 28px;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;

    font-family: 'Open sans';
    &__title {
      padding-left: 10px;
      color: grey;
    }
    &__button {
      width: 180px;
      height: 100%;
      border: 1px solid grey;
      color: white;
      text-transform: uppercase;
      background-color: rgb(54, 96, 146);
      outline: none;
      cursor: pointer;
      font-family: 'Open sans';
      transition: background-color .5s;
      &:hover {
        background-color: rgb(54, 96, 146, 0.9);
      }
    }
  }
}
</style>