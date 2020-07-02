<template>
  <div class="form-search">
    <hr>
     <control-select :width="300" :defaultTitle="defaultTitle[0]" />
    <form-report-filter />
    <hr>
  </div>
</template>

<script>
import ControlSelect from '@/components/form-element/control-select';
import FormReportFilter from '@/components/ocenka/form-report-filter';

export default {
  name: "FormReport",
  components: {
    ControlSelect,
    FormReportFilter,
  },
  data: function() {
    return {
      defaultTitle: ['Укажите МРУ',],
    }
  },
}
</script>

<style scoped>
  .form-search {
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  hr {margin: 5px 0px;}
</style>