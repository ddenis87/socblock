<template>
  <div class="register">
    <h3 class="register__title">Регистрация документа</h3>

    <div class="register__body">
      <div class="doc-type" >
        <h5 class="doc-type__title">Укажите тип документа</h5>
        <div class="doc-type__body">
          <div class="doc-type__input-body">
            <label for="registerOrder"><input type="radio" id="registerOrder" value="Order" v-model="registerType" @change="() => {docName = ''; docNomen = ''}" />ПРИКАЗ</label>
          </div>
          <div class="input-body">
            <label for="registerLetter"><input type="radio"  id="registerLetter" value="Letter" v-model="registerType" @change="() => {docName = ''; docNomen = ''}" />ПИСЬМО</label>
          </div>
        </div>
      </div>
      <div class="doc-name">
        <h5 class="doc-name__title">Укажите реквизиты документа</h5>
        <div class="doc-name__body">
          <div class="input-body">
            <label class="input-body__title">Наименование документа</label>
            <input class="input-body__input" 
                  type="text" />
          </div>
          <div class="input-body">
            <label class="input-body__title">Номенклатура дела</label>
            <input class="input-body__input" 
                  type="text" />
          </div>
        </div>
      </div>
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
      registerType: '',
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

<style lang="scss" scoped>
.register {
  font-family: 'Open sans';
  &__title {
    margin: 0px;
    margin-bottom: 5px;
    color:black
  }
  &__body {
    .doc-type {
      display: inline-flex;
      flex-direction: column;
      width: 200px;
      margin-bottom: 10px;
      box-sizing: border-box;
      // border: 1px solid darkgoldenrod;
      &__title {
        margin: 0px;
        // font-family: 'Open sans';
        font-weight: bold;
        text-transform: uppercase;
      }
      &__body {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
        box-sizing: border-box;
      }
      &__input-body {
        position: relative;
        box-sizing: border-box;
      }
    }
    .doc-name {
      // display: inline-flex;
      // flex-direction: column;
      width: 500px;
      margin-bottom: 10px;
      box-sizing: border-box;
      &__title {
        margin: 0px;
        font-weight: bold;
        text-transform: uppercase;
      }
      &__body {
        display: inline-flex;
        .input-body {
          position: relative;
          box-sizing: border-box;

          &__title {
            position: absolute;
            display: inline-block;
            left: 6px;
            top: 3px;

            font-size: 10px;
            color: grey;
            text-transform: uppercase;
          }
          &__input {
            // width: 140px;
            padding: 3px;
            padding-left: 6px;
            padding-top: 16px;
            border: 1px solid grey;
            outline: none;
            border-radius: 3px;
            box-sizing: border-box;
            font-family: 'Open sans';
          }
        }
      }
    }
  }
}
</style>

<style scoped>
/* .register {

}

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
  } */
</style>