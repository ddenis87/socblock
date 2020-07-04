<template>
  <div class="form-report-filter" :style="{height: heightFilter + 'px'}">
    <div class="header">
      <div class="header-element">
        Фильтр не задан
      </div>
      <div class="header-element" @click="dropFilter">
        Расширенный фильтр
      </div>
    </div>
    <div class="bodyf">
      <fieldset class="check-group">
        <legend>МРУ</legend>
        <input type="checkbox" id="ch1">Благовещенск<br>
        <input type="checkbox" id="ch2">Белогорск<br>
        <input type="checkbox" id="ch3">Райчихинск<br>
      </fieldset>

    </div>
  </div>  
</template>

<script>
export default {
  name: 'FormReportFiltr',
  data: function() {
    return {
      heightFilter: 30,
    }
  },
  methods: {
    dropFilter: function() {
      if (this.heightFilter <= 30) {
        //drop down
        let intervalHeight = setInterval(() => {
          if (this.heightFilter > 300) {clearInterval(intervalHeight); return;};
          this.heightFilter = +this.heightFilter + +5;
        }, 3);
      } else if (this.heightFilter >= 300) {
      //drop up
        let intervalHeight = setInterval(() => {
          if (this.heightFilter <= 30) {clearInterval(intervalHeight); return;};
          this.heightFilter = +this.heightFilter - +5;
        }, 3);
      }

    },
  },
}
</script>

<style scoped>
  .form-report-filter {
    width: 100%;
    height: 30px;
    margin: 10px 0px;
    border: 1px solid grey;
    overflow: hidden;
  }

  .header {
    display: flex;
    height: 30px;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    border: 0px solid grey;
  }

  .header-element:first-child {
    color: grey;
    padding-left: 10px;
  }
  .header-element:last-child {
    display: flex;
    width: 200px;
    height: 30px;
    justify-content: center;
    align-items: center;
    color: white;
    text-transform: uppercase;
    border-left: 1px solid grey;
    background-color: rgb(54, 95, 147);
    cursor: pointer;
  }
  .check-group {
    margin: 5px;
    padding: 5px;
    width: 150px;
    border: 1px solid grey;
  }
  
</style>