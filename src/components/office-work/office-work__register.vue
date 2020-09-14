<template>
  <div class="register">
    <hr>
    <!-- <span class='register__title'>Регистрация документа</span> -->
    <h3 class="register__title">Регистрация документа</h3>

    <div class="register__radio">
        <label for="registerOrder"><input type="radio" id="registerOrder" value="Order" v-model="registerType" @change="() => {docName = ''; docNomen = ''}" />ПРИКАЗ</label>
        <label for="registerLetter"><input type="radio"  id="registerLetter" value="Letter" v-model="registerType" @change="() => {docName = ''; docNomen = ''}" />ПИСЬМО</label>
    </div>

    <div class="register__body">
      <div class="doc__name">
        <label class="register__doc-name-title">Укажите наименование документа:</label><br>
        <input type="text" class="register__doc-name" v-model="docName" /><br>
      </div>
      <div class="doc__nome">
        <template v-if="registerType == 'Letter'">
          <label class="register__doc-nomen-title">Номенклатура:</label><br>
          <input 
            type="text"
            placeholder="18-24"
            maxlength="5" 
            class="register__doc-nomen" 
            v-model="docNomen"/>
        </template>
      </div>
      <template v-if="isRegisterNumber">
      <div class="doc__number">
        <label class="register__doc-number-title">Номер документа</label>
        <div class="register__doc-number">25</div>
      </div>
      </template>
    </div>
    <button @click="goRegister" :disabled="isDisabledReg">Зарегистрировать</button>
  </div>
</template>

<script>
export default {
  name: 'register',
  data: function() {
    return {
      registerType: 'Order',
      docName: '',
      docNomen: '',
      isRegisterNumber: false,
      isDisabledReg: false,
    }
  },
  methods: {
    goRegister: function() {
      this.isRegisterNumber = true;
      this.isDisabledReg = true;
    }
  }
}
</script>

<style scoped>
  hr {margin: 5px 0px;}
  .register {
    font-size: 16px;
  }

  .register__title {
    display: block;
    padding: 10px 0px;    
  }

  .register__radio {
    display: inline-flex;
    justify-content: space-between;
    max-width: 200px;
    width: 100%;
    padding: 5px 0px;
  }

  .register__body {
    display: flex;

    padding: 5px;
  }

  input[type="radio"] {
    display: inline-block;
    margin: 0px;
    margin-right: 5px;
  }

  input[type="text"] {
    margin-right: 5px;
    margin-top: 5px;
    margin-bottom: 5px;
    
    padding: 5px;
    border: 1px solid grey;
    border-radius: 3px;
    outline: none;
  }

  input[type="text"]:focus {
    box-shadow: 1px 1px 1px lightblue, -1px -1px 1px lightblue;
  }

  .register__doc-name {
    width: 500px;
  }

  .register__doc-nomen {
    width: 100px;
  }

  button {
    width: 150px;
    padding: 3px;
  }
  .doc__number {
    text-align: center;
  }
  .register__doc-number-title, .register__doc-number {
    font-weight: bold;
    text-transform: uppercase;
  }
  .register__doc-number {
    padding: 4px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 22px;
    color: red;
  }
</style>