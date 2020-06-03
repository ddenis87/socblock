<template>
  <div>
    <h2>Отдел опеки и попечительства</h2>
    <form>
      <hr>
      <div class="find">
        <input type="text" placeholder="Укажите фамилию для поиска" v-model="fio"/>
        <input type="button" value="Найти..." @click="findRes"/>
      </div>
      <hr>
      <span>{{ lineRes }}</span>
    </form>
  </div>
</template>

<script>

export default {
  data: () => ({
    lineRes: "Нет записей удовлетворяющих поиск",
    arrRes: [
      {fio: "Смирнова Елена Сергеевна, 1979",1:"",2:"Благовещенск, ул. Калинина 142 кв. 125",3:"05.08.2016, Благовещенский городской суд, 2-8105/2016",4:"",5:"Смирнов Александр Сергеевич, 13.02.2006",6:"",7:"Благовещенск;лишение родительских прав"}
    ],
    fio: ''
  }),
  methods: {
    findRes() {
      let request = new XMLHttpRequest();
	    request.open('POST','php/opeka.php', true);
	    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.send(`fio=${this.fio}`);
      request.onload = () => {
        // let arrRes = request.responseText.split("#");
        console.log(request.responseText);
        console.log(request.responseText.split("#"));
        // console.log(JSON.parse(request.responseText));
      }
	    
      console.log(this.fio)
    }
  }
}
</script>