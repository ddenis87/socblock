<template>
  <div class="office-work">
    <div class="office-work-title">
      <h2 class="office-work-title__title">Отдел делопроизводства</h2>
    </div>
    <hr class="separator" />
    <div class="office-work__control">
      <office-work-control :inDocumentNumber="documentNumber"
                           @getDocumentNumber="getDocumentNumber"
                           @change="changeDocumentType"></office-work-control>
    </div>
    <hr class="separator" />
    <div class="office-work__list" 
         :class="{'office-work__list_opacity': isListOpacity}">
      <office-wokr-list :inListDocument="listDocument" :inDocumentType="documentType"></office-wokr-list>
    </div>
  </div>
</template>

<script>
import officeWorkControl from '@/components/units/office-work/office-work__control.vue';
import officeWokrList from '@/components/units/office-work/office-work__list.vue';

export default {
  name: 'officeWork',
  components: {
    officeWorkControl, officeWokrList,
  },
  data: function() {
    return {
      documentType: 'order',
      documentNumber: '',
      listDocument: Array,
      listDocumentOrder: [
        {ID: '4', CNAME: 'О ношении масок', CDATETIME: '01.09.2020', CDOCNUMBER: '15', CSPECIP: '10.38.99.60'},
        {ID: '3', CNAME: 'О распределении обязанностей О распределении обязанностей О распределении обязанностей О распределении обязанностей', CDATETIME: '24.08.2020', CDOCNUMBER: '14', CSPECIP: '10.38.0.34'},
        {ID: '2', CNAME: 'О коммандировке', CDATETIME: '12.07.2020', CDOCNUMBER: '13', CSPECIP: '10.38.99.42'},
        {ID: '1', CNAME: 'О назначении ответственных', CDATETIME: '12.07.2020', CDOCNUMBER: '12', CSPECIP: '10.38.100.12'},
      ],
      listDocumentLetter: [
        {ID: '4', CNAME: 'О расшифровке писем', CNOMENCLATURE: '18-24', CDATETIME: '01.09.2020', CDOCNUMBER: '8888', CSPECIP: '10.38.99.60'},
        {ID: '3', CNAME: 'О смене мастер-ключа', CNOMENCLATURE: '18-24', CDATETIME: '24.08.2020', CDOCNUMBER: '8887', CSPECIP: '10.38.0.34'},
        {ID: '2', CNAME: 'О смене паролей', CNOMENCLATURE: '08-10', CDATETIME: '12.07.2020', CDOCNUMBER: '8886', CSPECIP: '10.38.99.42'},
        {ID: '1', CNAME: 'О проведении конкурса', CNOMENCLATURE: '07-01', CDATETIME: '12.07.2020', CDOCNUMBER: '8885', CSPECIP: '10.38.100.12'},
      ],
      isListOpacity: false,

      countOrder: 15,
      countLetter: 8888,
    }
  },
  created: function() {
    this.listDocument = this.listDocumentOrder;
  },
  methods: {
    getDocumentNumber: function(documentOptions) {
      switch(documentOptions.documentType) {
        case 'letter': {
          this.countLetter++;
          this.listDocumentLetter.unshift({
            ID: this.countLetter,
            CDOCNUMBER: this.countLetter,
            CNAME: documentOptions.documentName,
            CNOMENCLATURE: documentOptions.documentNomenclature,
            CDATETIME: this.formatedDate(new Date()),
            CSPECIP: '10.10.10.0'
          })
          this.documentNumber = this.countLetter;
          break;
        }
        case 'order': {
          this.countOrder++;
          this.listDocumentOrder.unshift({
            ID: this.countOrder,
            CDOCNUMBER: this.countOrder,
            CNAME: documentOptions.documentName,
            CDATETIME: this.formatedDate(new Date()),
            CSPECIP: '10.10.10.0'
          })
          this.documentNumber = this.countOrder;
          break;
        }
      }
      console.log(documentOptions);

    },
    changeDocumentType: function(documentType) {
      this.documentNumber = '';
      switch(documentType) {
        case 'order': {
          this.isListOpacity = true;
          setTimeout(() => {
            this.documentType = documentType;
            this.listDocument = this.listDocumentOrder; 
            this.isListOpacity = false;
          }, 500)
          break;
        }
        case 'letter': {
          this.isListOpacity = true;
          setTimeout(() => {
            this.documentType = documentType;
            this.listDocument = this.listDocumentLetter;
            this.isListOpacity = false;
          }, 500)
          break;}
      }
    },
    formatedDate(noFormat) {
      let formatDate = '';
      let dateNow = new Date(noFormat);
      let dd = (+dateNow.getDate() < 10) ? '0' + dateNow.getDate() : dateNow.getDate();
      let mm = (+dateNow.getMonth() < 10) ? '0' + (+dateNow.getMonth() + 1) : +dateNow.getMonth() + 1;
      let yyyy = dateNow.getFullYear();
      formatDate = dd + '.' + mm + '.' + yyyy;
      return formatDate;
    }
  }
}
</script>

<style lang="scss" scoped>
.office-work {
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
  &__list {
    opacity: 1;
    transition: opacity .5s;
    &_opacity {
      opacity: 0;
    }
  }
}

.separator {
  margin: 0px;
  margin-bottom: 5px;
}
</style>