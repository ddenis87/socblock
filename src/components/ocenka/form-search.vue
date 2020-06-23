<template>
  <div class="">
    <hr>
    <div class="control-radio">
      <input type="radio" id="find-snils" value="snils" v-model="findType" @change="() => {findValue = '';}" /><label for="find-snils">Искать по СНИЛС</label>
      <input type="radio"  id="find-fio" value="first-name" v-model="findType" @change="() => {findValue = '';}" /><label for="find-fio">Искать по Фамилии</label>
    </div>
    <div class="control-find">
      <template v-if="findType == 'snils'" >
        <label class="title-input">Укажите СНИЛС для поиска:</label>
        <input type="text" 
              placeholder="___-___-___ __" 
              pattern="[0-9]{3}[-][0-9]{3}[-][0-9]{3}[\s][0-9]{2}" 
              maxlength="14"
              v-model="findValue"
              key="snils"
              @input.prevent="validateInput($event)" />
      </template>
      <template v-if="findType == 'first-name'" >
        <label class="title-input">Укажите Фамилию для поиска:</label>
        <input type="text" 
               key="first-name"
               v-model="findValue" />
      </template>
      <button @click.prevent="$emit('findUser')">Найти...</button><br>
    </div>
    <hr>

  </div>
</template>

<script>
export default {
  name: 'formSearch',
  data: function() {
    return {
      findType: 'snils',
      findValue: '',
    }
  },
  methods: {
    validateInput: function(param) {
      if(param.inputType == 'insertText') {
        if(this.findValue.length == 3) {this.findValue = this.findValue + '-'}
        if(this.findValue.length == 7) {this.findValue = this.findValue + '-'}
        if(this.findValue.length == 11) {this.findValue = this.findValue + ' '}
      }
    },
  },
}
</script>

<style scoped>
  hr {margin: 5px 0px;}

  .control-radio {
    margin: 10px 0px;
  }

  input[type="radio"] {
    display: inline-block;
    margin: 0px;
    margin-right: 5px;
  }

  .control-find {
    margin: 10px 0px;
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
    width: 190px;
  }

  button {
    width: 120px;
    margin: 0px 10px;
    padding: 3px;
  }
</style>