<template>
  <form>
    <meta charset="utf-8">
    <h2>Оценка пенсионных прав застрахованного лица</h2>
    <hr>
    <input type="radio" value="" id="r-snils" checked/><label for="r-snils">Искать по СНИЛС</label>
    <input type="radio" value="" id="r-snils" disabled/><label for="r-snils">Искать по ФИО</label><br>
    <label>Укажите СНИЛС для поиска:</label><input type="text" placeholder="___-___-___ __" pattern="[0-9]{3}[-][0-9]{3}[-][0-9]{3}[\s][0-9]{2}" v-model="snils" />
    <button @click.prevent="findUser">Найти...</button><br>
    <hr>
    <table>
      <tr>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Территория</th>
      </tr>
      <tr v-for="(rowRez, index) in rez" :key="index">
        <td>{{ rowRez[0] }}</td>
        <td>{{ rowRez[1] }}</td>
        <td>{{ rowRez[2] }}</td>
      </tr>
    </table>

    
  </form>
</template>

<script>
export default {
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
      let request = new XMLHttpRequest();
      // let arrResponse = [];
      // this.arrRes = [];
      request.open('POST','./php/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      console.log(this.snils);
      request.send(`function=getUserInfo&snils=${this.snils}`);
      request.onload = () => {
        this.rez = request.response;
        console.log(request.response);
        // console.log(request.responseText);
        //this.rez = request.responseText;
      }
    }
  }
}
</script>

<style scoped>
  form {
    padding-left: 10px;
   
  }

  input {
    display: inline-block;
    margin: 10px;
  }

  input[type="text"] {
    width: 150px;
    padding: 3px;
    border: 2px solid grey;
    border-radius: 3px;
  }

  button {
    width: 120px;
  }
</style>