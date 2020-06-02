<template>
  <div>
    <h2>Отдел опеки и попечительства</h2>
    <form>
      <hr>
      <div class="find">
        <input type="text" placeholder="Укажите фамилию для поиска" />
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
    arrRes: []
  }),
  methods: {
    findRes() {
      console.log("I'm find")
    }
  }
}

function ajax_query(strPost,asunc){
	let request = new XMLHttpRequest();
	request.open('POST','prog.php', asunc);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(strPost);
	return request.responseText;
}

</script>