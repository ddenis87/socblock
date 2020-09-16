<template>
  <fieldset class="block-checkbox">
    <legend class="block-checkbox__title">МРУ (сводно)</legend>
    <div class="block-checkbox__body">
      <label class="body__item body__item-title"><input type="checkbox" 
                                                        class="body__item-input body__item-input-title"
                                                        v-model="isCheckAllMRU"
                                                        @change="selectMRUAll" >Все</label>
    
      <hr>
      <template v-for="(row, index) in arrListDistrict">
        <div v-if="(+row.ISMRU == 1)" :key="index">
          <label class="body__item"><input type="checkbox" 
                                           class="body__item-input"
                                          :value="row.MRUID"
                                          :disabled="isDisabledMRU"
                                          v-model="arrFilterMRU"
                                          @change="selectMRU">{{ row.MRUNAME }}</label>
        </div>
      </template>
    </div>
  </fieldset>
</template>

<script>
import axios from 'axios';
export default {
  name: 'OcenkaReportFiltrMru',
  data: function() {
    return {
      arrListDistrict: [], // список тер.органов,
      isCheckAllMRU: false,
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
    selectMRUAll: function() {},
    selectMRU: function() {}
  }
}
</script>

<style lang="scss" scoped>
.block-checkbox {
  width: 100%;
  font-family: 'Montserrat';
  font-size: 12.5px;
  box-sizing: border-box;
}
</style>