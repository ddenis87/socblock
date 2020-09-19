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
                     @change="changeDocumentType" />приказ</label>
          </div>
          <div class="doc-type__input-body">
            <label for="registerLetter">
              <input type="radio"  
                     id="registerLetter" 
                     value="letter" 
                     v-model="documentType" 
                     @change="changeDocumentType" />письмо</label>
          </div>
        </div>
      </div>
      <div class="doc-name">
        <h5 class="doc-name__title">Реквизиты документа</h5>
        <div class="doc-name__body">
          <div class="input-body">
            <label class="input-body__title">Наименование документа</label>
            <input class="input-body__input input-body__input-name"
                   :class="{'input-body__input_validation': !isValidationName}" 
                   type="text"
                   v-model="documentName" 
                   @input="() => {isValidationName = true}"/>
            <div class="input-body__validation"
                 :class="{'input-body__validation_visibility': isValidationName}">* Не указано наименование документа</div>
          </div>
          <div class="input-body"
               :class="{'input-body_display': (documentType == 'order') ? true : false}">
            <label class="input-body__title">Номенклатура дела</label>
            <input class="input-body__input input-body__input-nomenclature"
                   :class="{'input-body__input_validation': !isValidationNomenclature}"
                   type="text"
                   v-model="documentNomenclature"
                   placeholder="18-24" 
                   @input="() => {isValidationNomenclature = true}"/>
            <div class="input-body__validation"
                 :class="{'input-body__validation_visibility': isValidationNomenclature}">* Не указана номенклатура</div>
          </div>
          <div class="input-body"
               :class="{'input-body_display': (this.documentNumber != null) ? true : false}">
            <span class="input-body__doc-number">{{ documentNumber }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="register-control">
      <button class="register-control__button"
              @click="getDocumentNumber"
              :disabled = btnDisabled>Зарегистрировать <span :class="{'register-control__button_disabled': !btnDisabled}">({{ btnStopTime }})</span></button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'officeWorkRegister',
  props: {
    inDocumentNumber: Number,
  },
  computed: {
    documentNumber: function() { return (this.inDocumentNumber) ? this.inDocumentNumber : null},
  },
  data: function() {
    return {
      documentType: 'order',
      documentName: '',
      documentNomenclature: '',
      btnStopTime: Number,
      btnDisabled: false,
      isValidationName: true,
      isValidationNomenclature: true,
    }
  },
  methods: {
    getDocumentNumber: function() {
      if (!this.documentName) {this.isValidationName = false;}
      if (!this.documentNomenclature && this.documentType == 'letter') {this.isValidationNomenclature = false;}
      if (!this.isValidationName || !this.isValidationNomenclature) return;
      let documentOptions = {
        documentType: this.documentType,
        documentName: this.documentName,
        documentNomenclature: this.documentNomenclature
      }
      this.btnDisabled = true;
      this.btnStopTime = 10;
      let intervalStopTime = setInterval(() => {
        this.btnStopTime--;
        if (this.btnStopTime == 0) {
          this.btnDisabled = false;
          clearInterval(intervalStopTime);
        }
      }, 1000);
      this.$emit('getDocumentNumber', documentOptions);
    },
    changeDocumentType: function() {
      this.documentName = '';
      this.documentNomenclature = '';
      this.isValidationName = true;
      this.isValidationNomenclature = true;
      this.$emit('change', this.documentType)
    }
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
      // margin-bottom: 10px;
      box-sizing: border-box;
      &__title {
        margin: 0px;
        font-weight: bold;
        text-transform: uppercase;
      }
      &__body {
        display: inline-flex;
        align-items: flex-start;
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
            margin-right: 20px;
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
            
            }
            &-nomenclature {
              width: 120px;
            }
            &_validation {
              border: 1px solid red;
            }
          }
          &__validation {
            margin-bottom: 10px;
            font-size: 10px;
            font-weight: bold;
            color: red;
            text-transform: uppercase;
            transition: margin .5s;
            &_visibility {
              margin-bottom: 0px;
              visibility: hidden;
            }
          }
          &__doc-number {
            font-family: "Montserrat";
            font-size: 30px;
            font-weight: bold;
            color: darkred;
          }
          &_display {
            display: none;
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
      &:hover {
        background-color: rgb(54, 96, 146, 0.9);
      }
      &:disabled {
        background-color: grey;
        cursor: default;
      }
      &_disabled {
        display: none;
      }
    }
  }
}
</style>