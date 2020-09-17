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
        <template v-for="(row, index) in arrListInitial">
          <div :key="index" 
               v-if="(+row.ISMRU == 1)">
            <label  class="body__item body__item-title"><input type="checkbox" 
                                              class="body__item-input body__item-input-title"
                                              :value="row.DISTRICTID"
                                              :disabled="isDisabledDistrict"
                                              v-model="arrListFilter"
                                              @change="$emit('change', arrListFilter)" >{{ row.DISTRICTNAME }}</label>
          </div>
          <div :key="index" 
                  v-else>
          <label  class="body__item"><input type="checkbox" 
                                              class="body__item-input"
                                              :value="row.DISTRICTID"
                                              :disabled="isDisabledDistrict"
                                              v-model="arrListFilter"
                                              @change="$emit('change', arrListFilter)">{{ row.DISTRICTNAME }}</label>
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
  model: {
    event: 'change'
  },
  data: function() {
    return {
      arrListInitial: [], // начальный список тер.органов из базы,
      arrListFilter: [], //отфильтрованный список
      isCheckAllDistrict: false,
      isDisabledDistrict: false,
    }
  },
  created: function() {
    axios
      .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDistrict'}})
      .then(response => {
        this.arrListInitial = response.data;
      })
  },
  methods: {
    selectDistrictAll: function() {
      let arrDistrictId = [];
      if (this.isCheckAllDistrict == true) {
        this.isDisabledDistrict = true;
        for (let i = 0; i < this.arrListInitial.length; i++) arrDistrictId.push(this.arrListInitial[i].DISTRICTID);
        this.arrListFilter = arrDistrictId.slice();
      } else {
        this.isDisabledDistrict = false;
        this.arrListFilter = arrDistrictId.slice();
      }
      this.$emit('change', this.arrListFilter)
    },
    clearFilter: function() {
      this.isCheckAllDistrict = false;
      this.isDisabledDistrict = false;
      this.arrListFilter = [];
    }
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
      height: 240px;
    }
  }
}
</style>