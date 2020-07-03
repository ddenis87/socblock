<template>
  <div class='report'>
    <div class="title">
      <h2>Оценка пенсионных прав - Отчеты</h2>
    </div>
    <form-report />
    <!-- <button @click="buildReportAll">Build Report</button> -->
    <fieldset>
      <legend>Вариант 1</legend>
    <table>
      <tr>
        <td></td>
        <td v-for="(row, index) in listCol" :key="index" class="td-col"><div class="td-flex">{{ row.CNAME }}</div></td>
      </tr>
      <tr v-for="(row, index) in listRow" :key="index">
        <td>{{ row.CNAME }}</td>
      </tr>
    </table>
    </fieldset>
  </div>
</template>

<script>
import FormReport from '@/components/ocenka/form-report';
export default {
  name: 'OcenkaReport',
  components: {
    FormReport,
  },
  data: function() {
    return {
      listReport: [],
      listCol: [],
      listRow: [],
    }
  },
  methods: {
    buildReportAll: function() {
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka-report.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(`function=getListCol`);
      request.onload = () => {
        this.listCol = request.response;
       console.log(this.listCol);
        console.log(request.response);
        // console.log('');
        // console.log('');
      };
      let requestRow = new XMLHttpRequest();
      requestRow.open('POST', pathBackEndrep + 'php/ocenka-report.php', true);
      requestRow.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      requestRow.responseType = 'json';
      requestRow.send(`function=getListRow`);
      requestRow.onload = () => {
        this.listRow = requestRow.response;
       console.log(this.listRow);
        console.log(requestCol.response);
        // console.log('');
        // console.log('');
      };
    },
  },
  created: function() {
    this.buildReportAll();
  }
}
</script>

<style scoped>
.report {
    padding-left: 10px;
    width: 100%;
    max-width: 1000px;
    font-size: 14px;
  }
  .td-col {
    border-right: 1px solid black;
    height: 220px;
    width: 40px;
    text-align: start;
    vertical-align: bottom;
    padding: 3px;
    /* padding-left: 10px; */
    padding-right: 0px;
    padding-bottom: 0px;
  }
  td {
    padding: 3px;
  }
.td-flex {
  height: 200px;
  
  writing-mode: sideways-lr;
transform-origin: left top 0px;
  border: 0px solid black;
}

fieldset {border: 1px solid black; padding: 3px;}
</style>