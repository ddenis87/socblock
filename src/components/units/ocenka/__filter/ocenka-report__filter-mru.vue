<template>
  <fieldset class="block-checkbox">
    <legend class="block-checkbox__title">МРУ (сводно)</legend>
    <div class="block-checkbox__body">
      <label class="body__item body__item-title"><input type="checkbox" 
                                                        class="body__item-input body__item-input-title"
                                                        v-model="isCheckAllMru"
                                                        @change="selectMruAll" >Все</label>
    
      <hr>
      <template v-for="(row, index) in arrListInitial">
        <div v-if="(+row.ISMRU == 1)" :key="index">
          <label class="body__item"><input type="checkbox" 
                                           class="body__item-input"
                                          :value="row.MRUID"
                                          :disabled="isDisabledMru"
                                          v-model="arrListFilter"
                                          @change="$emit('change', arrListFilter)">{{ row.MRUNAME }}</label>
        </div>
      </template>
    </div>
  </fieldset>
</template>

<script>
// import axios from 'axios';
export default {
  name: 'OcenkaReportFilterMru',
  model: {
    event: 'change'
  },
  props: [
    'arrListInitialInput'
  ],
  computed: {
    arrListInitial: function() { return this.arrListInitialInput; }
  },
  data: function() {
    return {
      arrListFilter: [],
      isCheckAllMru: false,
      isDisabledMru: false,
    }
  },
  created: function() {
  },
  methods: {
    selectMruAll: function() {
      let arrMruId = [];
      if (this.isCheckAllMru == true) {
        this.isDisabledMru = true;
        for (let i = 0; i < this.arrListInitial.length; i++) if (this.arrListInitial[i].ISMRU == 1) arrMruId.push(this.arrListInitial[i].MRUID);
        this.arrListFilter = arrMruId.slice();
      } else {
        this.isDisabledMru = false;
        this.arrListFilter = arrMruId.slice();
      }
      this.$emit('change', this.arrListFilter)
    },
    clearFilter: function() {
      this.isCheckAllMru = false;
      this.isDisabledMru = false;
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
}
</style>