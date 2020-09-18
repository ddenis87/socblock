<template>
  <div class="register">
    <h3 class="register__title">Регистрация документа</h3>

    <div class="register-body">
      <div class="doc-type" >
        <h5 class="doc-type__title">Тип документа</h5>
        <div class="doc-type__body">
          <div class="doc-type__input-body">
            <label for="registerOrder">
              <input type="radio" 
                     id="registerOrder" 
                     value="order" 
                     v-model="documentType" 
                     @change="() => {}" />приказ</label>
          </div>
          <div class="doc-type__input-body">
            <label for="registerLetter">
              <input type="radio"  
                     id="registerLetter" 
                     value="letter" 
                     v-model="documentType" 
                     @change="() => {}" />письмо</label>
          </div>
        </div>
      </div>
      <div class="doc-name">
        <h5 class="doc-name__title">Реквизиты документа</h5>
        <div class="doc-name__body">
          <div class="input-body">
            <label class="input-body__title">Наименование документа</label>
            <input class="input-body__input input-body__input-name" 
                   type="text"
                   v-model="documentName" />
          </div>
          <div class="input-body"
               :class="{'input-body_visibility': (documentType == 'order') ? true : false}">
            <label class="input-body__title">Номенклатура дела</label>
            <input class="input-body__input input-body__input-nomenclature"
                    
                   type="text"
                   v-model="documentNomenclature"
                   placeholder="18-24" />
          </div>
        </div>
      </div>
    </div>
    <div class="register-control">
      <button class="register-control__button">Зарегистрировать</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'officeWorkRegister',
  data: function() {
    return {
      documentType: 'order',
      documentName: '',
      documentNomenclature: ''
    }
  },
  methods: {

  }
}
</script>

<style lang="scss" scoped>
.register {
  font-family: 'Open sans';
  &__title {
    margin: 0px;
    margin-bottom: 10px;
    color:darkslateblue;
  }
  &-body {
    .doc-type {
      display: inline-flex;
      flex-direction: column;
      width: 200px;
      margin-bottom: 10px;
      box-sizing: border-box;
      &__title {
        margin: 0px;
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
        color: darkslateblue;
        text-transform: uppercase;
      }
    }
    .doc-name {
      // display: inline-flex;
      // flex-direction: column;
      // width: 500px;
      margin-bottom: 10px;
      box-sizing: border-box;
      &__title {
        margin: 0px;
        font-weight: bold;
        text-transform: uppercase;
      }
      &__body {
        display: inline-flex;
        margin-top: 5px;
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
            padding: 3px;
            padding-left: 6px;
            padding-top: 16px;
            border: 1px solid grey;
            outline: none;
            border-radius: 3px;
            box-sizing: border-box;
            font-family: 'Open sans';
            &-name {
              width: 500px;
              margin-right: 20px;
            }
            &-nomenclature {
              width: 120px;
            }
          }
          &_visibility {
            visibility: hidden;
          }
        }
      }
    }
  }
  &-control {
    margin-bottom: 10px;
    &__button {
      width: 180px;
      height: 100%;
      border: 1px solid grey;
      color: white;
      text-transform: uppercase;
      background-color: #366092;
      outline: none;
      cursor: pointer;
      font-family: "Open sans";
      transition: background-color 0.5s;
    }
  }
}
</style>