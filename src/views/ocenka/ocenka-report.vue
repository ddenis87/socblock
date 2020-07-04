<template>
  <div class='report'>
    <div class="title">
      <h2>Оценка пенсионных прав - Отчеты</h2>
    </div>
    <report-control :arrDistrict="arrDistrict" :arrReshenie="arrReshenie"></report-control>

    <fieldset>
      <legend>Вариант 1</legend>
      <table>
        <!-- столбцы - вынесенные решения -->
        <tr>
          <td></td>
          <td v-for="(row, index) in arrReshenie" 
              :key="index" 
              class="title-collumn"><div class="vertical-text">{{ row.CNAME }}</div>
          </td>
          <td class="title-collumn"><div class="vertical-text">Итого по тер. органам</div></td>
        </tr>
        <!-- ---------------------------- -->

        <!-- строки - тер.органы -->
        <template v-for="(row, index) in arrDistrict">
          <tr  :key="index" :class="{'title-row-mru' : (+row.MRU) ? true : false}">
            <td class="title-row" >{{ row.CNAME }}</td>
            <td class="count-content">{{ row.R1 }}</td>
            <td class="count-content">{{ row.R2 }}</td>
            <td class="count-content">{{ row.R3 }}</td>
            <td class="count-content">{{ +row.R1 + +row.R2 + +row.R3 }}</td>
          <!-- ------------------- -->
 
        </tr>
        <tr :key="index + 1000"><td :colspan="arrDistrict.length"><hr></td></tr>
      </template>
      <tr>
        <td>Итого по решениям:</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      </table>
    </fieldset>
  </div>
</template>

<script>
import ReportControl from '@/components/ocenka/report-control';
export default {
  name: 'OcenkaReport',
  components: {
    ReportControl,
  },
  data: function() {
    return {
      listReport: [],
      arrDistrict: [
        {ID: '1', CNAME: 'Благовещенск', MRU: '1', R1: '2', R2: '10', R3: '88'},
        {ID: '2', CNAME: 'Ивановка', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '3', CNAME: 'Тамбовка', MRU: '0', R1: '0', R2: '0', R3: '0'},
        {ID: '4', CNAME: 'Константиновка', MRU: '0', R1: '5', R2: '3', R3: '2'},
        {ID: '5', CNAME: 'Белогорск', MRU: '1', R1: '44', R2: '33', R3: '105'},
        {ID: '6', CNAME: 'Зея', MRU: '0', R1: '54', R2: '3', R3: '9'},
        {ID: '7', CNAME: 'Тында', MRU: '0', R1: '3', R2: '4', R3: '6'},
        {ID: '8', CNAME: 'Октябрьский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '9', CNAME: 'Ромненский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '10', CNAME: 'Серышевский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '11', CNAME: 'Райчихинск', MRU: '1', R1: '44', R2: '33', R3: '105'},
        {ID: '12', CNAME: 'Архаринский район', MRU: '0', R1: '54', R2: '3', R3: '9'},
        {ID: '13', CNAME: 'Бурейский', MRU: '0', R1: '3', R2: '4', R3: '6'},
        {ID: '14', CNAME: 'Завитинский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '15', CNAME: 'Михайловский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '16', CNAME: 'Свободный', MRU: '1', R1: '44', R2: '33', R3: '105'},
        {ID: '17', CNAME: 'Шимановский район', MRU: '0', R1: '54', R2: '3', R3: '9'},
        {ID: '18', CNAME: 'Магдагачинский район', MRU: '0', R1: '3', R2: '4', R3: '6'},
        {ID: '19', CNAME: 'Мазановский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '20', CNAME: 'Селемджинский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        {ID: '21', CNAME: 'Сковородинский район', MRU: '0', R1: '0', R2: '3', R3: '45'},
        
      ],
      arrReshenie: [
        {ID: '1', CNAME: 'Корректировка СНИЛС'},
        {ID: '2', CNAME: 'Не служил'},
        {ID: '3', CNAME: 'Отправлено уведомление страхователю на прием'},
        {ID: '4', CNAME: 'Направлен межведомственный запрос'},
        {ID: '5', CNAME: 'Отправлено уведомление страхователю'},
        {ID: '6', CNAME: 'Направлено приглашение гражданину'},
      ],
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
  table {
    border-spacing: 0px;
    border-collapse: collapse;
  }
  .title-collumn {
    border-left: 1px solid grey;
    height: 180px;
    width: 40px;
    vertical-align: bottom;
    overflow: hidden;
  }
  .title-collumn:last-child {
    border-right: 1px solid grey;
  }

  .title-row {
    width: 150px;
    border-bottom: 0px solid grey;
  }

  td {
    margin: 0px;
    padding: 3px 0px;
    border: 0px solid black;
    border-left: 0px solid cadetblue;
    border-right: 0px solid cadetblue;
  }

  .vertical-text {
    display: flex;
    height: 100%;
    width: 40px;
    writing-mode: sideways-lr;
    border: 0px solid black;
    align-items: center;
  }

  .count-content {
    text-align: center;
    border-bottom: 0px solid grey;
  }

  .title-row-mru {
    background-color:cadetblue;
  }

  fieldset {border: 1px solid black; padding: 10px;}
  hr {margin: 2px 0px;}
</style>