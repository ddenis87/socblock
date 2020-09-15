<template>
  <div class="ocenka-report-filter">
    <div class="filter-header">
      <div class="filter-header__title">
        Фильтр по умолчанию: Территории - {{ textFilterDistrict }} | Решения - {{ textFilterReshenie }}
      </div>
      <button class="filter-header__button" @click="dropFilter">Расширенный фильтр</button>
    </div>
    <div class="filter-body">
      <ocenka-report-filter-mru></ocenka-report-filter-mru>
    </div>
  </div>
</template>

<script>
import ocenkaReportFilterMru from '@/components/units/ocenka/__filter/ocenka-report__filter-mru';

export default {
  name: 'OcenkaReportFilter',
  components: {
    ocenkaReportFilterMru
  }
}
</script>

<style lang="scss" scoped>
.ocenka-report-filter{
  width: 100%;
  height: auto; //30px;
  margin: 10px 0px;
  border: 1px solid grey;
  // overflow: hidden;

  .filter-header {
    display: flex;
    height: 30px;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    &__title {
      padding-left: 10px;
      color: grey;
    }
    &__button {
      height: 100%;
      border: 1px solid grey;
      color: white;
      text-transform: uppercase;
      background-color: rgb(54, 96, 146);
      outline: none;
      cursor: pointer;
      &:hover {
        background-color: rgb(54, 96, 146, 0.9);
      }
    }
  }
}
</style>