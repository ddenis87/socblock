<template>
  <div class="list-document">
    <h3 class="list-document__title">{{ (documentType == 'order') ? 'Список приказов' : 'Список писем'}}</h3>
    <table class="list-table">
      <thead class="list-table__head">
        <tr class="list-table__head-row">
          <th class="list-table__head-collumn list-table__head-collumn_c1">№ док.</th>
          <th class="list-table__head-collumn list-table__head-collumn_c2">Наименование документа</th>
          <th class="list-table__head-collumn list-table__head-collumn_c2-dop"
              v-if="documentType == 'letter'">Номенклатура</th>
          <th class="list-table__head-collumn list-table__head-collumn_c3">Дата</th>
          <th class="list-table__head-collumn list-table__head-collumn_c4">IP - создателя</th>
          <th class="list-table__head-collumn list-table__head-collumn_c5">Действия</th>
        </tr>
        <tr><td :colspan="(documentType == 'letter') ? 6 : 5"><hr class="list-table__body-separator"></td></tr>
      </thead>
      <tbody class="list-table__body">
        <template v-for="(item, index) in listDocument">            
          <tr class="list-table__body-row"
              :key="index">
            <td class="list-table__body-collumn">{{ item.CDOCNUMBER }}</td>
            <td class="list-table__body-collumn">{{ item.CNAME }}</td>
            <td class="list-table__body-collumn"
                v-if="documentType == 'letter'">{{ item.CNOMENCLATURE }}</td>
            <td class="list-table__body-collumn">{{ item.CDATETIME }}</td>
            <td class="list-table__body-collumn">{{ item.CSPECIP }}</td>
            <td class="list-table__body-collumn">{{  }}</td>
          </tr>
          <tr :key="'sp' + index"><td :colspan="(documentType == 'letter') ? 6 : 5"><hr class="list-table__body-separator"></td></tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'officeWokrListOrder',
  props: {
    inListDocument: Array,
    inDocumentType: String,
  },
  computed: {
    documentType: function() {return this.inDocumentType },
    listDocument: function() { return this.inListDocument },
  },
  data: function() {
    return {
    }
  },
}
</script>

<style lang="scss" scoped>
.list-document {
  &__title {
    margin: 0px;
    margin-bottom: 10px;
    color:darkslateblue;
  }
  .list-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Open sans';
    &__head {
      // &-row {}
      &-collumn {
        padding: 5px;
        border-left: 1px solid grey;
        &_c1 { width: 60px; text-align: left; }
        &_c2 {
          text-align: left;
          &-dop {
            width: 100px;
            text-align: left;
          }
        }
        &_c3 { width: 80px;}
        &_c4 { width: 100px; }
        &_c5 { width: 100px; }
        &:first-child { border-left: 0px; }
      }
      &-separator {
        margin: 5px 0px;
      }
    }
    &__body {
      // &-row {}
      &-collumn {
        padding: 5px;
        border-left: 1px solid grey;
        &_c1 { width: 60px; text-align: left; }
        &_c2 { text-align: left; }
        &_c3 { width: 80px;}
        &_c4 { width: 110px; }
        &_c5 { width: 100px; }
        &:first-child { border-left: 0px; }
      }
      &-separator {
        margin: 5px 0px;
      }
    }
  }
}
</style>