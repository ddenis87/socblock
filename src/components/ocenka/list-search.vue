<template>
  <div class="list-search">
    <table>
      <tr>
        <th width="45px">№ п/п</th>
        <th width="110px">СНИЛС</th>
        <th>ФИО</th>
        <th width="100px">Дата рождения</th>
        <th width="200px">Территория проживания</th>
        <th width="200px">МРУ обслуживания</th>
      </tr>
      <tr><td colspan="6"><hr></td></tr>
      <template v-for="(rowPerson, index) in listPerson">
      <tr class="tr-active" :key="index" @click="$emit('selectPerson', rowPerson[3])">
        <td>{{ index + 1 }}</td>
        <td>{{ rowPerson[3] }}</td>
        <td>{{ rowPerson[0] }}</td>
        <td>{{ rowPerson[1] }}</td>
        <td>{{ rowPerson[2] }}</td>
        <td>{{ rowPerson[4] }}</td>
      </tr>
      <tr :key="index + 1000"><td colspan="6"><hr></td></tr>
      </template>
    </table>
  </div>
</template>

<script>
export default {
  name: 'listSearch',
  props: {
    listPerson: Array,
  },
}
</script>

<style scoped>
  table {
    width: 100%;
    margin: 0px;
    margin-top: 10px;
    padding: 0px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    font-size: 12px;
  }
  
  td, th {
    padding: 3px;
    padding-left: 5px;
    border-left: 2px solid grey;
  }

  td:first-child, th:first-child {border-left: 0px;}

  .tr-active {
    cursor: pointer;
  }
</style>