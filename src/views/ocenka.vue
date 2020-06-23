<template>
  <form>
    <h2>Оценка пенсионных прав застрахованного лица</h2>
    <form-search @findUser="findUser"></form-search>
    <table>
      <tr>
        <th>№ п/п</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Территория</th>
      </tr>
      <tr><td colspan="4"><hr></td></tr>
      <template v-for="(rowRez, index) in rez">
      <tr class="tr-active" :key="index">
        <td width="40px">{{ index + 1 }}</td>
        <td>{{ rowRez[0] }}</td>
        <td width="100px">{{ rowRez[1] }}</td>
        <td width="250px">{{ rowRez[2] }}</td>
      </tr>
      <tr :key="index + 1000"><td colspan="4"><hr></td></tr>
      </template>
    </table>

    
  </form>
</template>

<script>
import formSearch from '@/components/ocenka/form-search';

export default {
  components: {
    formSearch,
  },
  data: function() {
    return {
      rez: [
         [ "АБАБКОВА ИРИНА БОРИСОВНА", "15.04.1979", "Шимановск" ],
         [ "АБАБКОВА ИРИНА БОРИСОВНА", "15.04.1979", "Ромны" ],
          ],
      snils: '',
    }
  },
  methods: {
    findUser: function() {
      console.log("HI i`m find");
      let request = new XMLHttpRequest();
      request.open('POST','./php/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      console.log(this.snils);
      request.send(`function=getUserInfo&snils=${this.snils}`);
      request.onload = () => {
        this.rez = request.response;
        console.log(request.response);
      }
    },

  }
}
</script>

<style scoped>
  form {
    padding-left: 10px;
    width: 100%;
    max-width: 800px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
  }

  hr {margin: 0px; padding: 0px;}
  table {
    width: 100%;
    margin: 0px;
    margin-top: 10px;
    padding: 0px;

  }
  
  td, th {
    padding: 3px;
    padding-left: 5px;
    border-left: 2px solid grey;
    font-size: 12px;
  }

  td:first-child, th:first-child {border-left: 0px;}

  .tr-active {
    cursor: pointer;
  }
</style>