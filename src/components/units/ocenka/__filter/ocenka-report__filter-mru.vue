<template>
  <fieldset class="block-checkbox block-checkbox-mru">
    <legend>МРУ (сводно)</legend>
    <div class="blue">
      <label class="rn-title"><input type="checkbox" 
                                          v-model="isCheckAllMRU"
                                          @change="selectMRUAll" >Все</label>
    </div>
    <hr>
    <template v-for="(row, index) in arrListDistrict">
      <div v-if="(+row.ISMRU == 1)" :key="index">
        <label class="rn-row"><input type="checkbox" 
                                      :value="row.MRUID"
                                      :disabled="isDisabledMRU"
                                      v-model="arrFilterMRU"
                                      @change="selectMRU">{{ row.MRUNAME }}</label>
      </div>
    </template>
  </fieldset>
</template>