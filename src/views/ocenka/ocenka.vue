<template>
  <div class='ocenka'>
    <div class="ocenka-title">
      <h2 class="ocenka-title__title">Оценка пенсионных прав застрахованного лица</h2>
      <button class="ocenka-title__button" @click="goReport">Перейти к отчетам</button>
    </div>

    <ocenka-control @find-person="findPerson"></ocenka-control>
    <ocenka-list :list-person="listPerson" @select-person="selectPerson"></ocenka-list>

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
import axios from 'axios';
import ocenkaControl from '@/components/units/ocenka/ocenka__control';
import ocenkaList from '@/components/units/ocenka/ocenka__list';

export default {
  components: {
    ocenkaControl, ocenkaList,
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
      this.isLoad = false;
      if (findValue == '') {
        this.isWarning = false;
        setTimeout(() => {this.isWarning = true}, 1200);
        return;
      }
      this.selectEmpty = '';
      let requestOption = {
        function: 'getPersonInfo' + findType,
        [findType]: findValue
      };
      console.log(requestOption);
      axios
        .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: requestOption})
        .then(response => {
          this.listPerson = response.data;
          if ("length" in this.listPerson && this.listPerson == 0) this.selectEmpty = 'Записи отсутствуют';
          this.isLoad = true;
        })
    },
    selectPerson: function(id) {
      this.$router.push(`/ocenka-card?id=${id}`);
    }
  },
}
</script>

<style lang="scss" scoped>
  p {
    margin: 5px;
    font-size: 16px;
  }
.ocenka {
  padding-left: 10px;
  width: 98%;
  font-size: 14px;
  &-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    &__title {
      margin: 5px 0px;
      padding: 0px;
    }
    &__button {
      width: 150px;
      padding: 3px;
    }
  }
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