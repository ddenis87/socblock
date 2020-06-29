<template>
  <div class='ocenka'>
    <h2>Оценка пенсионных прав застрахованного лица</h2>
    <form-search @findPerson="findPerson"></form-search>
    <list-search :list-person="listPerson" @selectPerson="selectPerson"></list-search>
    <p>{{ selectEmpty }}</p>
    <div class="progress-load" :class="{'is-visible' : (isLoad) ? true : false}">
      <img src="/img/load.gif">
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
    }
  },
  methods: {
    findPerson: function(findValue, findType) {
      this.isLoad = !this.isLoad;
      this.selectEmpty = '';
      let request = new XMLHttpRequest();
      request.open('POST', pathBackEnd + 'php/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      console.log(findType);
      request.send(`function=getPersonInfo${findType}&${findType}=${findValue}`)
      request.onload = () => {
        console.log(findValue);
        console.log(request.response);
        this.listPerson = request.response;
        if (this.listPerson.length == 0) this.selectEmpty = 'Записи отсутствуют';
        this.isLoad = !this.isLoad;
        
      }
    },
    selectPerson: function(snils) {
      //console.log(this.listPerson[index]);
      this.$router.push(`/ocenka-card?snils=${snils}`);
    }
  },
  created: function() {
    console.log(accessUser);
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
    max-width: 800px;
    font-size: 14px;
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

  .is-visible {
    visibility: hidden;
  }
</style>