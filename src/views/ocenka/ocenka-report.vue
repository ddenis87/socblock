<template>
  <div class='report'>
    <div class="title">
      <h2>Оценка пенсионных прав - Отчеты</h2>
    </div>
    <form-report />
    <button @click="buildReportAll">Build Report</button>
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
    }
  },
  methods: {
    buildReportAll: function() {
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEnd + 'php/ocenka-report.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(`function=getReportAll`);
      request.onload = () => {
        this.listReport = request.response;
       console.log(this.listReport);
        console.log(request.response);
        // console.log('');
        // console.log('');
        
      }
    },
  },
}
</script>

<style scoped>
.report {
    padding-left: 10px;
    width: 100%;
    max-width: 1000px;
    font-size: 14px;
  }
</style>