<template>
  <div class='ocenka'>
    <h2>Оценка пенсионных прав застрахованного лица</h2>
    <form-search @findPerson="findPerson"></form-search>
    <list-search :list-person="listPerson" @selectPerson="selectPerson"></list-search>
    

    
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
      listPerson: [
         [ "ИВАНОВА КАТЕРИНА СФОРЦИЯ", "25.09.1956", "Шимановск" ],
         [ "АБАБКОВА ИРИНА БОРИСОВНА", "15.04.1979", "Ромны" ],
          ],
    }
  },
  methods: {
    findPerson: function(findValue) {
      let request = new XMLHttpRequest();
      request.open('POST','./php/ocenka.php', true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.responseType = 'json';
      console.log(findValue);
      request.send(`function=getUserInfo&snils=${findValue}`);
      request.onload = () => {
        this.listUser = request.response;
        console.log(request.response);
      }
    },
    selectPerson: function(index) {
      console.log(this.listPerson[index]);
      this.$router.push("/ocenka-card?arrPerson=" + this.listPerson[index]);
    }
  }
}
</script>

<style scoped>
  .ocenka {
    padding-left: 10px;
    width: 100%;
    max-width: 800px;
    font-size: 14px;
  }
</style>