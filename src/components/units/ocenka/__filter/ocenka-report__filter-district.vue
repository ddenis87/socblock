<template>
  <fieldset class="block-checkbox">
    <legend class="block-checkbox__title">Территориальные органы (отдельно по каждому)</legend>
    <div class="block-checkbox__body">
      <label class="body__item body__item-title"><input type="checkbox"
                                                        class="body__item-input body__item-input-title"
                                                        v-model="isCheckAllDistrict"
                                                        @change="selectDistrictAll">Все</label>
      <hr>
      <div class="block-checkbox__body-flex">
        <template v-for="(row, index) in arrListDistrict">
          <div :key="index" 
               v-if="(+row.ISMRU == 1)">
            <label  class="body__item body__item-title"><input type="checkbox" 
                                              class="body__item-input body__item-input-title"
                                              :value="row.DISTRICTID"
                                              :disabled="isDisabledDistrict"
                                              v-model="arrFilterDistrict"
                                              @change="selectDistrict" >{{ row.DISTRICTNAME }}</label>
          </div>
          <div :key="index" 
                  v-else>
          <label  class="body__item"><input type="checkbox" 
                                              class="body__item-input"
                                              :value="row.DISTRICTID"
                                              :disabled="isDisabledDistrict"
                                              v-model="arrFilterDistrict"
                                              @change="selectDistrict">{{ row.DISTRICTNAME }}</label>
          </div>
        </template>
      </div>
    </div>
  </fieldset>
</template>

<script>
import axios from 'axios';
export default {
  name: 'OcenkaReportFilterDistrict',
  data: function() {
    return {
      arrListDistrict: [], // список тер.органов,
      isCheckAllDistrict: false,
      arrFilterDistrict: [],
      isDisabledDistrict: false,
    }
  },
  created: function() {
    axios
      .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDistrict'}})
      .then(response => {
        this.arrListDistrict = response.data;
      })
  },
  methods: {
    selectDistrictAll: function () {},
    selectDistrict: function() {}
  }
}
</script>

<style lang="scss" scoped>
.block-checkbox {
  width: 100%;
  font-family: 'Montserrat';
  font-size: 12.5px;
  box-sizing: border-box;

  &__body {
    &-flex {
      display: flex;
      flex-direction: column;
      flex-wrap: wrap;
      height: 230px;
    }
  }
}
</style>