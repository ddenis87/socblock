<template>
  <fieldset>
    <!-- <legend>Отчет</legend> -->
    <table>
      <!-- столбцы - вынесенные решения -->
      <tr>
        <td class="empty-first"></td>
        <td v-for="(row, index) in arrReshenie" 
            :key="index" 
            class="title-collumn"><div class="vertical-text">{{ row.CNAME }}</div>
        </td>
        <td class="title-collumn"><div class="vertical-text">Всего вынесено результатов работы</div></td>
      </tr>
      <!-- ---------------------------- -->

      <!-- ----------------строки - тер.органы---------------- -->
      <template v-for="(row, rowIndex) in arrReport">
          <tr :key="rowIndex">
            <td class="title-row" :class="{'title-row-mru': (+row[0]) ? true : false }" >{{ row[1] }}</td>
            
                <td v-for="col in arrReshenie.length" 
                    :key="col + 1000"
                    class="count-content"
                    :class="{'title-row-mru': (+row[0]) ? true : false }">{{ (row[col + 1]) ? row[col + 1] : '0' }}</td> 
            
            <td class="count-content itog"
              :class="{'title-row-mru': (+row[0]) ? true : false }">{{ sumCollumn(row) }}</td>
          </tr>
      </template>
      <!-- ------------------------------------------------ -->
      <tr>
        <td class="table-footer">Всего по территориям</td>
        <template v-for="(row, index) in arrReportAll">
          <td  :key="index"
                class="table-footer">{{ row }}</td>
        </template>
        <td class="table-footer">{{ sumItog(arrReportAll) }}</td>
      </tr>
      <tr>

      </tr>
    </table>
  </fieldset>
</template>

<script>
export default {
  name: 'ocenkaReportList',
}
</script>

<style lang="scss" scoped>

</style>