<template>
<div class="input-date" :style="{ width: widthBlock }">
  <label><slot></slot></label>
  <input type="date" 
         :style="{ width: widthInput }" 
         :class="'position-' + positionLabel"
         v-model="dateReport"
         @input="inputDate" disabled>
</div>
</template>

<script>
export default {
  name: 'InputDate',
  props: {
    widthBlock: { default: 'auto' },
    widthInput: { default: 'auto' },
    positionLabel: { default: 'top' },
  },
  data: function() {
    return {
      dateReport: '',
    }
  },
  created: function() {
    let dateNow = new Date();
    let dd = (+dateNow.getDate() < 10) ? '0' + dateNow.getDate() : dateNow.getDate();
    let mm = (+dateNow.getMonth() < 10) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
    let yyyy = dateNow.getFullYear();
    this.dateReport = yyyy + '-' + mm + '-' + dd
    this.inputDate();
  },
  methods: {
    inputDate: function() {
      this.$emit('input', this.dateReport);
    }
  }
}
</script>

<style scoped>
.input-date {
  display: inline-block;
  margin: 5px 0px;
  border: 0px solid grey;
}
.position-left {
  display: inline-block;
}
.position-top {
  display: block;
  margin-top: 5px;
}
input {
  padding: 5px;
  border: 1px solid grey;
  outline: none;
  border-radius: 3px;
}
label {
  padding: 5px 0px;
  padding-right: 10px;
}
</style>