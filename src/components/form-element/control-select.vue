<template>
  <select :style="{width: width + 'px'}"
          :class="className" >
    <option selected disabled>{{ defaultTitle }}</option>
    <option v-for="row in listOption" 
            :key="row.value" 
            :value="row.value">{{ row.title }}</option>
  </select>
</template>

<script>
export default {
  name: 'ControlSelect',
  props: {
    listOption: {
      type: Array,
      default: function() { return [{title: 'Значения отсутствуют', value: null}] }
    },
    defaultTitle: {
      type: String,
      default: 'Выберите значение',
    },
    width: {
      type: Number,
      default: 200,
    },
    className: {
      default: 'selectDefault',
    },
  },
  created: function() {

  },

}
</script>

<style scoped>
  .selectDefault {
    padding: 3px;
  }
</style>