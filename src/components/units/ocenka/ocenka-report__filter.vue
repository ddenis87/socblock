<template>
  <div class="ocenka-report-filter" id="ocenkaReportFilter">
    <div class="filter-header">
      <div class="filter-header__title">
        Фильтр по умолчанию: Территории - {{ textFilterDistrict }} | Решения - {{ textFilterReshenie }}
      </div>
      <button class="filter-header__button" @click="openFilter">Расширенный фильтр</button>
    </div>
    <div class="filter-body">
      <div class="filter-body__mru">
        <ocenka-report-filter-mru ref="ocenkaReportFilterMru" v-model="arrFilterMru" @change="getTerritories('mru')"></ocenka-report-filter-mru>
      </div>
      <div class="filter-body__district">
        <ocenka-report-filter-district ref="ocenkaReportFilterDistrict" v-model="arrFilterDistrict" @change="getTerritories('district')"></ocenka-report-filter-district>
      </div>
    </div>
  </div>
</template>

<script>
import ocenkaReportFilterMru from '@/components/units/ocenka/__filter/ocenka-report__filter-mru';
import ocenkaReportFilterDistrict from '@/components/units/ocenka/__filter/ocenka-report__filter-district';

export default {
  name: 'OcenkaReportFilter',
  components: {
    ocenkaReportFilterMru,
    ocenkaReportFilterDistrict
  },
  data: function() {
    return {
      arrFilterMru: [],
      arrFilterDistrict: [],
      arrFilterTerritory: [],
      textFilterDistrict: 'Все',
      textFilterReshenie: 'Все',
    }
  },
  methods: {
    getTerritories: function(type) {
      switch(type) {
        case 'mru': {
          this.$refs.ocenkaReportFilterDistrict.clearFilter();
          // this.arrFilterDistrict = [];
          this.arrFilterTerritory = this.arrFilterMru.slice();
          console.log(this.arrFilterTerritory);
          break;
          }
        case 'district': {
          this.$refs.ocenkaReportFilterMru.clearFilter();
          // this.arrFilterMru.length = 0;
          this.arrFilterTerritory = this.arrFilterDistrict.slice();
          console.log(this.arrFilterTerritory);
          break;
        }
      }
     
    },
    openFilter: function() {
      document.getElementById('ocenkaReportFilter').classList.toggle('ocenka-report-filter_drop');
    }
  }
}
</script>

<style lang="scss" scoped>
.ocenka-report-filter{
  width: 100%;
  height: 30px;
  margin: 10px 0px;
  border: 1px solid grey;
  overflow: hidden;
  box-sizing: border-box;
  transition: .5s height ;
  &_drop {
    height: 350px;
  }
  .filter-header {
    display: flex;
    height: 28px;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid grey;

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
  .filter-body {
    display: flex;
    
    padding: 8px 8px;
    padding-bottom: 8px;
    // border: 1px solid darkcyan;
    box-sizing: border-box;
    &__mru {
      min-width: 200px;
      margin-right: 10px;
      box-sizing: border-box;
    }
    &__district {
      min-width: 550px;
      max-width: 700px;
      margin-right: 10px;
      box-sizing: border-box;
    }
  }
}
</style>