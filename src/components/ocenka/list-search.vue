<template>
  <div class="list-search">
    <table>
      <tr>
        <th>№ п/п</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Территория</th>
      </tr>
      <tr><td colspan="4"><hr></td></tr>
      <template v-for="(rowPerson, index) in listPerson">
      <tr class="tr-active" :key="index" @click="$emit('selectPerson', index)">
        <td width="45px">{{ index + 1 }}</td>
        <td>{{ rowPerson[0] }}</td>
        <td width="100px">{{ rowPerson[1] }}</td>
        <td width="250px">{{ rowPerson[2] }}</td>
      </tr>
      <tr :key="index + 1000"><td colspan="4"><hr></td></tr>
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