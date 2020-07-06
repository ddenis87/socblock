<template>
  <div class='ocenka'>
    <div class="title">
      <h2>Оценка пенсионных прав застрахованного лица</h2>
      <button @click="goReport">Перейти к отчетам</button>
    </div>
    <form-search @findPerson="findPerson"></form-search>
    <list-search :list-person="listPerson" @selectPerson="selectPerson"></list-search>
    <p>{{ selectEmpty }}</p>
    <div class="progress-load" :class="{'is-visible' : (isLoad) ? true : false}">
      <img src="img/load.gif">
    </div>
    
    <div class="warning-insert" :class="{'is-visible' : (isWarning) ? true : false}">
      Не указано условие поиска!
    </div>
  </div>
</template>

<script>
import formSearch from '@/components/ocenka/form-search';
import listSearch from '@/components/ocenka/list-search';

export default {
  components: {
    formSearch, listSearch,
  },
  data: function() {
    return {
      listPerson: [],
      isLoad: true,
      selectEmpty: '',
      isWarning: true,
    }
  },
  methods: {
    goReport: function() {
      this.$router.push(`/ocenka-report`);
    },
    findPerson: function(findValue, findType) {
      if (findValue == '') {
        this.isWarning = false;
        setTimeout(() => {this.isWarning = true}, 1200);
        return;
      }
      this.isLoad = !this.isLoad;
      this.selectEmpty = '';
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEndrep + 'php/ocenka/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      request.send(`function=getPersonInfo${findType}&${findType}=${findValue}`)
      request.onload = () => {
        this.listPerson = request.response;
        //console.log(typeof(this.listPerson));
        //console.log(request.response);
        if ("length" in this.listPerson && this.listPerson == 0) this.selectEmpty = 'Записи отсутствуют';
        this.isLoad = !this.isLoad;
      }
    },
    selectPerson: function(id) {
      this.$router.push(`/ocenka-card?id=${id}`);
    }
  },
  created: function() {
    //console.log(accessUser);
  }
}
</script>

<style scoped>
  p {
    margin: 5px;
    font-size: 16px;
  }
  .ocenka {
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

  button {
    width: 150px;
    padding: 3px;
  }

  .progress-load {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    text-align: center;
  }

  .progress-load img {
    margin-top: 300px;
    width: 50px;
    height: 50px;
  }

  /* ------warning------- */
  .warning-insert {
    display: flex;
    position: fixed;
    left: 45%;
    top: 40%;
    margin: auto;
    width: 250px;
    height: 30px;
    background-color: black;
    color: white;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    border-radius: 3px;
    box-shadow: 2px 2px 2px grey;
  }
  /* -------------------- */

  .is-visible {
    visibility: hidden;
  }
</style>