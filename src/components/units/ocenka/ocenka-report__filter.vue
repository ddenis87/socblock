<template>
  <div class="ocenka-report-filter">
    <div class="filter-header">
      <div class="filter-header__title">
        Фильтр по умолчанию: Территории - {{ textFilterDistrict }} | Решения - {{ textFilterReshenie }}
      </div>
      <button class="filter-header__button" @click="openFilter">Расширенный фильтр</button>
    </div>
    <div class="filter-body">
      <div class="filter-body__mru">
        <ocenka-report-filter-mru></ocenka-report-filter-mru>
      </div>
    </div>
  </div>
</template>

<script>
import ocenkaReportFilterMru from '@/components/units/ocenka/__filter/ocenka-report__filter-mru';

export default {
  name: 'OcenkaReportFilter',
  components: {
    ocenkaReportFilterMru
  },
  data: function() {
    return {
      textFilterDistrict: 'Все',
      textFilterReshenie: 'Все',
    }
  },
  methods: {
    openFilter: function() {}
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
  box-sizing: border-box;
  .filter-header {
    display: flex;
    height: 30px;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid grey;
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
  .filter-body {
    padding: 8px 8px;
    padding-bottom: 8px;
    border: 1px solid darkcyan;
    box-sizing: border-box;
    &__mru {
      box-sizing: border-box;
      min-width: 200px;
      max-width: 300px;
    }
  }
}
</style>