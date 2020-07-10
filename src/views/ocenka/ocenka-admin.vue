<template>
  <div class="ocenka-admin">
    <div class="title">
      <h2>Панель администратора</h2>
    </div>
    <div class="table-flex">
      <table class="table-user">
        <caption class="text-right">Пользователи</caption>
        <tr>
          <th width="50px">№ п/п</th>
          <th width="300px">Пользователь</th>
          <th>IP - адрес</th>
          <th width="70px">Действие</th>
        </tr>
        <template v-for="(row, index) in arrUser">
          <tr :key="index">
            <td align="center">{{ index + 1 }}</td>
            <td>{{ row.CNAME }}</td>
            <td>{{ row.CIP }}</td>
            <td align="center"><img src="img/button-row-delete.png" 
                                    class="button-row-control" 
                                    title="Удалить запись" 
                                    @click="deleteUser(row.ID)"></td>
          </tr>
        </template>
      </table>
      <hr>
      <table class="table-user-add">
        <caption class="text-left">Добавление пользователя</caption>
        <tr>
          <td><div class="input-field"><label>Пользователь</label><input type="text" class="text-fio" v-model="userFio"></div></td>
          <td><div class="input-field"><label>IP - адрес</label><input type="text" class="text-ip" v-model="userIp"></div></td>
        </tr>
        <tr>
          <td colspan="2" class="text-right"><button @click="insertUser">Добавить</button></td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OcenkaAdmin',
  data: function() {
    return {
      arrUser: Array,
      userFio: '',
      userIp: '',
    }
  },
  methods: {
    insertUser: function() {
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.send(`function=insertUser&userFio=${this.userFio}&userIp=${this.userIp}`);
      request.onload = () => {
        if (request.response == '1') {
          alert("Пользователь добавлен");
          this.userFio = '';
          this.userIp = '';
          this.loadUser();
        }
        else {alert("БД: Ошибка добавления");}
      }
    },
    deleteUser: function(userId) {
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.send(`function=deleteUser&userId=${userId}`);
      request.onload = () => {
        if (request.response == '1') {
          alert("Пользователь удален");
          this.loadUser();
        }
        else {alert("БД: Ошибка удаления");}
      }
    },
    loadUser: function() {
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(`function=getListUser`)
      request.onload = () => {
        this.arrUser = request.response;
      }
    },
    // ajaxQuery: function() {
    //   let request = new XMLHttpRequest();
    //     request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
    //     request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //     request.responseType = 'json';
    //     request.send(`function=getListUser`)
    //     request.onload = () => {
    //       this.arrUser = request.response;
    //     }
    // },
  },
  created: function() {
    this.loadUser();

    
  },

}
</script>

<style scoped>
  .ocenka-admin {
    padding-left: 10px;
    width: 100%;
    max-width: 1000px;
    font-size: 14px;
  }

  .title {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
  .table-flex {
    display: flex;
    flex-direction: row;
  }
  .table-user {
    width: 560px;
    /* padding-right: 5px; */
    /* border-right: 2px solid grey; */
    border-collapse: collapse;
    font-size: 16px;
  }
  caption {
    padding-bottom: 5px;
    font-size: 18px;
    color: rgb(54, 95, 147);
  }
  
  .table-user th {
    padding: 3px;
    text-align: left;
    border-bottom: 2px solid black;
  }

  .table-user td {
    border-bottom: 2px solid rgb(54, 95, 147);
    padding: 3px;
    padding-left: 5px;
  }

  .button-row-control {
    width: 18px;
    height: 18px;
    margin: 3px 3px 0px 3px;
    padding: 0px;
    border: 0px solid black;
    background-color: white;
    outline: none;
    cursor: pointer;
  }

  hr {
    margin: 0px 10px;
  }

  .input-field {
    position: relative;
    margin: 0px 0px;
  }

  .input-field label {
    position: absolute;
    display: inline-block;
    left: 5px;
    top: 3px;

    font-size: 12px;
    color: grey;
  }

  .input-field input {
    padding: 5px;
    padding-left: 6px;
    padding-top: 20px;
    border: 1px solid grey;
    outline: none;
    border-radius: 3px;
  }

  .text-fio { width: 240px; }
  .text-ip { width: 140px; }

  button {
    width: 150px;
    margin: 3px 0px;
    padding: 3px;
  }

  .text-left {text-align: left;}
  .text-right {text-align: right;}
</style>