<template>
  <div class="form-search">
    <div class="control-radio">
      <input type="radio" id="find-snils" value="Snils" v-model="findType" @change="() => {findValue = '';}" /><label for="find-snils">Искать по СНИЛС</label>
      <input type="radio"  id="find-fio" value="Fio" v-model="findType" @change="() => {findValue = '';}" /><label for="find-fio">Искать по Фамилии</label>
    </div>
    <div class="control-find">
      <template v-if="findType == 'Snils'" >
        <label class="title-input">Укажите СНИЛС для поиска:</label>
        <input type="text" 
              placeholder="___-___-___ __" 
              pattern="[0-9]{3}[-][0-9]{3}[-][0-9]{3}[\s][0-9]{2}" 
              maxlength="14"
              v-model="findValue"
              key="Snils"
              @input.prevent="validateInput"
              @keyup="findPerson" />
      </template>
      <template v-if="findType == 'Fio'" >
        <label class="title-input">Укажите фамилию для поиска:</label>
        <input type="text" 
               key="Fio"
               v-model="findValue" 
               @keydown="findPerson" />
      </template>
      <button @click.prevent="$emit('find-person', findValue, findType)">Найти...</button><br>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormSearch',
  data: function() {
    return {
      findType: 'Snils',
      findValue: '',
    }
  },
  methods: {
    validateInput: function(param) {
      console.log(param);
      if(param.inputType == 'insertText') {
        this.findValue = this.findValue.replace(/[^0-9\.\-\' ']/g, '');
        if(this.findValue.length == 3) {this.findValue = this.findValue + '-'}
        if(this.findValue.length == 7) {this.findValue = this.findValue + '-'}
        if(this.findValue.length == 11) {this.findValue = this.findValue + ' '}
      }
    },
    findPerson: function(param) {
      //console.log(param);
      if (param.key == "Enter") {
        this.$emit('findPerson', this.findValue, this.findType);
      }
    }
  },
}
</script>

<style scoped>
  .form-search {
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  hr {margin: 5px 0px; margin-top: 0px;}

  .control-radio {
    margin: 10px 0px;
    font-family: inherit ;
  }

  input[type="radio"] {
    display: inline-block;
    margin: 0px;
    margin-right: 5px;
  }

  .control-find {
    margin: 20px 0px;
    font-family: inherit;
  }

  input[type="text"] {
    width: 150px;
    margin-right: 5px;
    padding: 3px;
    border: 1px solid grey;
    border-radius: 3px;
    outline: none;
  }

  input[type="text"]:focus {
    box-shadow: 1px 1px 1px lightblue, -1px -1px 1px lightblue;
  }

  label {
    margin-right: 15px;
  }

  .title-input {
    display: inline-block;
    width: 220px;
  }

  button {
    width: 150px;
    margin: 0px 10px;
    padding: 3px;
  }
</style>