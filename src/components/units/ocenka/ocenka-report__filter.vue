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
        <ocenka-report-filter-mru ref="ocenkaReportFilterMru" 
                                  :arrListInitialInput="arrTerritory"
                                  v-model="arrFilterMru" 
                                  @change="getTerritories('mru')"></ocenka-report-filter-mru>
      </div>
      <div class="filter-body__district">
        <ocenka-report-filter-district ref="ocenkaReportFilterDistrict" 
                                       :arrListInitialInput="arrTerritory"
                                       v-model="arrFilterDistrict" 
                                       @change="getTerritories('district')"></ocenka-report-filter-district>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import ocenkaReportFilterMru from '@/components/units/ocenka/__filter/ocenka-report__filter-mru';
import ocenkaReportFilterDistrict from '@/components/units/ocenka/__filter/ocenka-report__filter-district';

export default {
  name: 'OcenkaReportFilter',
  model: {
    event: 'change'
  },
  components: {
    ocenkaReportFilterMru,
    ocenkaReportFilterDistrict
  },
  data: function() {
    return {
      arrTerritory: [], // - список тер. органов из базы, входной параметр для компонентов фильтра
      arrFilterMru: [],
      arrFilterDistrict: [],
      arrFilterTerritory: [], // - отфильтрованный список тер.органов для построения отчета
      textFilterDistrict: 'Все',
      textFilterReshenie: 'Все',
    }
  },
  created: function() {
    axios
      .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDistrict'}})
      .then(response => {
        this.arrTerritory = response.data;
      })
      .catch(() => {
        this.arrTerritory = [
          {MRUID: '2', MRUNAME: 'Белогорск', DISTRICTID: '2', DISTRICTNAME: 'Белогорск', ISMRU: 1}
        ]
      })
  },
  methods: {
    getTerritories: function(type) {
      switch(type) {
        case 'mru': {
          this.$refs.ocenkaReportFilterDistrict.clearFilter();
          this.arrFilterTerritory = this.arrFilterMru.slice();
          this.$emit('change', this.arrFilterTerritory, true); // - 3 arg - тип отчета true -> МРУ
          break;
          }
        case 'district': {
          this.$refs.ocenkaReportFilterMru.clearFilter();
          this.arrFilterTerritory = this.arrFilterDistrict.slice();
          this.$emit('change', this.arrFilterTerritory, false);
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