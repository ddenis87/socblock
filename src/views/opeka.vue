<template>
  <div>
    <h2>Отдел опеки и попечительства</h2>
    <formFind @findClick="findRes" />
    <span class="outSpan">{{ lineRes }}</span>
    <hr>
    <form>
      <table 
        v-for="row in arrRes"
         v-bind:key="row.id">
        <tr class="bgWhite">
          <td>
            <span>ФИО, дата рождения</span>
            <input type="text" v-model="row[0]" disabled />
          </td>
          <td width="160">
            <span>СНИЛС</span>
            <input type="text" v-model="row[1]" disabled />
          </td>
          <td rowspan="6" width="35">
            <img src="img/printNoBg.png" @click="goPrint(row)" />
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <span>Место проживания</span>
            <input type="text" class="noBorder" v-model="row[2]" disabled />
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <span>Дети</span>
            <textarea wrap="soft" v-model="row[5]" disabled />
          </td>
        </tr>
        <tr>
          <td>
            <span>Место проживания</span>
            <textarea v-model="row[7]" disabled />
          </td>
          <td width="160">
            <span>СНИЛС(ы)</span>
            <textarea v-model="row[6]" disabled />
          </td>
        </tr>
        <tr>
          <td>
            <span>Статус</span>
            <input type="text" class="noBorder" v-model="row[8]" disabled />
          </td>
          <td width="160">
            <span>Дата решения</span>
            <input type="text" class="noBorder" v-model="row[4]" disabled />
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <span>Основание</span>
            <input type="text" class="noBorder" v-model="row[3]" disabled />
          </td>
        </tr>
      </table>
    </form>
  </div>
</template>

<script>
import formFind from "@/components/formFind"
export default {
  data: () => ({
    lineRes: '',
    arrRes: [],
    // arrRes: [
    //   {0: "Смирнова Елена Владимировна,",1: "135-156-157 87",2: "Серышевский район, п.Серышево, ул.Пархоменко, 64",3: "Решение Серышевского районного суда от 23.12.2015",4: "",5 : "Коршунова Анастасия Сергеевна, 08.09.2006 г.р., Харитонов Александр Олегович, 01.02.2000 г.р.",6: "",7: "Серышевский райн, п.Серышево",8: "Лишение родительских прав"}],
  }),
  components: {
    formFind
  },
  methods: {
    findRes(data) {
      if (data.trim()) {
        this.lineRes = "Поиск по: " + data + "...";
        let request = new XMLHttpRequest();
        let arrResponse = [];
        this.arrRes = [];
        request.open('POST','php/opeka.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(`fio=${data}`);
        request.onload = () => {
          arrResponse = request.responseText.split("#");
          if (arrResponse.length - 1 == 0) {
            this.lineRes = "Нет записей удовлетворяющих условие поиска..."; 
            return; 
          }
          for (let i = 0; i < arrResponse.length - 1; i++) {
            this.arrRes.push(arrResponse[i].split(";"))
          }
          this.lineRes = `Результаты поиска по "${data}..."`; 
        }
      } else {
        this.arrRes = [];
        this.lineRes = "Не указана строка поиска...";
        }
    },
    goPrint(data) {
      localStorage.setItem('param', Object.values(data).join(";") );
	    window.open('print.html');
      console.log( Object.values(data));
    }
  }
}
</script>

<style scoped>
span, input, textarea {
  display: block;
  padding: 2px;
  padding-bottom: 0px;
  color: black;
}

span {
  font-size: 12px;
  color: grey;
  padding: 0px;
}

input {
  width: 100%;
  border: 0px solid grey;
  border-bottom: 2px solid grey;
  background-color: inherit;
  box-sizing: border-box;
}

textarea {
  width: 100%;
  resize: none;
  border: 0;
  box-sizing: border-box;
  background-color: inherit;
}

table, tr, td {
  border: 0px solid black;
}

table {
  width: 700px;
  border-top: 3px solid green;
  border-bottom: 3px solid green;
  margin-bottom: 3px;
}

table:nth-child(2n) {
  background-color: blanchedalmond;
}

hr {
  margin-top: 0px;
}

img {
  width: 30px;
  height: 30px;
  margin-left: 10px;
  margin-right: 5px;
  cursor: pointer;
}

.noBorder {
  border: 0;
}

.outSpan {
  margin: 3px;
  padding: 5px;
  width: 410px;
  border-top: 2px solid grey;
  color: green;
  font-family: 'Times New Roman', Times, serif;
  font-size: 14px;
}
</style>