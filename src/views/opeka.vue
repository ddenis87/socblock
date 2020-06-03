<template>
  <div>
    <h2>Отдел опеки и попечительства</h2>
    <formFind />
    <form>
      <span>{{ lineRes }}</span>
      <table 
        v-for="row in arrRes"
         v-bind:key="row.id">
        <tr>
          <td colspan="2">
            <span>ФИО, дата рождения</span>
            <input type="text" v-model="row.fio" disabled/>
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
    lineRes: "Нет записей удовлетворяющих поиск",
    arrRes: [
      {id: "1", fio: "Смирнова Елена Сергеевна, 1979",1:"",2:"Благовещенск, ул. Калинина 142 кв. 125",3:"05.08.2016, Благовещенский городской суд, 2-8105/2016",4:"",5:"Смирнов Александр Сергеевич, 13.02.2006",6:"",7:"Благовещенск", 8:"лишение родительских прав"},
      {id: "2", fio: "Смирнова Галина Вячеславовна, 1979",1:"",2:"Благовещенск, ул. Калинина 142 кв. 125",3:"05.08.2016, Благовещенский городской суд, 2-8105/2016",4:"",5:"Смирнов Александр Сергеевич, 13.02.2006",6:"",7:"Благовещенск", 8:"лишение родительских прав"}
    ],
  }),
  components: {
    formFind
  },
  methods: {
    findRes(data) {
      // let request = new XMLHttpRequest();
	    // request.open('POST','php/opeka.php', true);
	    // request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      // request.send(`fio=${this.fio}`);
      // request.onload = () => {
      //   // let arrRes = request.responseText.split("#");
      //   console.log(request.responseText);
      //   console.log(request.responseText.split("#"));
      //   // console.log(JSON.parse(request.responseText));
      // }
	    this.lineRes = "Поиск по: " + data + "...";
      console.log(data);
    }
  }
}
</script>

<style scoped>
span, input {
  display: block;
}

span {
  font-size: 12px;
  color: grey;
}

input {
  width: 300px;
  border: 0px solid grey;
  border-bottom: 2px solid grey;
  padding: 5px;
  color: black;
  background-color: white;
}

</style>