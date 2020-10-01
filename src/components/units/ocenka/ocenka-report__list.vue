<template>
  <div class="list">
    <table class="report-table">
      <thead class="table-head">
        <tr class="table-head__row">
          <td class="table-head__collumn table-head__collumn_empty"></td>
          <td class="table-head__collumn"
              v-for="(rowItem, index) in arrListDecision"
              :key="index">
            <span class="table-head__collumn table-head__collumn_vertical">{{ rowItem.CNAME }}</span>
          </td>
          <td class="table-head__collumn">
            <span class="table-head__collumn table-head__collumn_vertical">Всего вынесено результатов</span>
          </td>
        </tr>
      </thead>
      <tbody class="table-body">
        <template v-for="(row, rowIndex) in arrReport">
          <tr class="table-body__row" :key="rowIndex">
            <td class="table-body__collumn" :class="{'table-body__collumn_title': (+row[0]) ? true : false }" >{{ row[1] }}</td>
            
                <td v-for="col in arrListDecision.length" 
                    :key="col + 1000"
                    class="table-body__collumn"
                    :class="{'table-body__collumn_title': (+row[0]) ? true : false }">{{ (row[col + 1]) ? row[col + 1] : '0' }}</td> 
            
            <td class="table-body__collumn"
              :class="{'table-body__collumn_title': (+row[0]) ? true : false }">{{ sumCollumn(row) }}</td>
          </tr>
        </template>
      </tbody>
      <tfoot class="table-foot">
        <tr class="table-foot__row">
          <td class="table-foot__collumn table-foot__collumn_title">Всего по территориям</td>
          <template v-for="(row, index) in arrReportAll">
            <td :key="index"
                class="table-foot__collumn">{{ row }}</td>
          </template>
          <td class="table-foot__collumn">{{ sumItog(arrReportAll) }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'ocenkaReportList',
  props: [
    'arrInReport',
    'arrInReportAll',
  ],
  computed: {
    arrReport: function() { return this.arrInReport },
    arrReportAll: function() { return this.arrInReportAll },
  },
  data: function() {
    return {
      arrListDecision: [],
    }
  },
  created: function() {
    axios
      .post(pathBackEnd + 'php/ocenka/ocenka.php', null, {params: {function: 'getListDecision'}})
      .then(response => {
        this.arrListDecision = response.data;
      })
  },
  methods: {
    sumItog: function(rowValue) {
      let sum = 0;
      for (let i = 0; i < rowValue.length; i++) {
        if (rowValue[i]) {
          sum += +rowValue[i];
        }
      }
      return sum;
    },
    sumCollumn: function(rowValue) {
      let sum = 0;
      for (let i = 2; i < rowValue.length; i++) {
        if (rowValue[i]) {
          sum += +rowValue[i];
        }
      }
      return sum;
    },
  }
}
</script>

<style lang="scss" scoped>
$heightTableHeadRow: 180px;

.list {
  width: 100%;
  margin: 10px 0px;
  // border: 1px solid grey;
  box-sizing: border-box;
  .report-table {
    border-spacing: 0px;
    width: 100%;
    border-collapse: collapse;
    border: 1px solid darkgreen;
    box-sizing: border-box;
    .table-head {
      // &__row {
      // }
      &__collumn {
        position: relative;
        border-left: 1px solid grey;
        // border-top: 1px solid grey;
        height: $heightTableHeadRow;
        min-width: 25px;
        vertical-align: bottom;
        &_empty {
          min-width: 150px;
        }
        &_vertical {
          position: absolute;
          width: $heightTableHeadRow;
          height: auto;
          padding-top: 3px;
          border: 0px;
          transform: rotate(-90deg);
          transform-origin: left top 0px;
        }
      }
    }
    .table-body {
      &__row {
        border: 1px solid grey;
      }
      &__collumn {
        border-left: 1px solid grey;
        padding: 3px;
        &_title {
          font-weight: bold;
          font-style: italic;
          background-color:rgb(54, 95, 147);
          color: white;
        }
      }
    }
    .table-foot {
      &__row {
        border: 1px solid grey;
      }
      &__collumn {
        border-left: 1px solid grey;
        padding: 3px;
        font-weight: bold;
        font-style: italic;
        color: white;
        background-color:rgb(54, 95, 147);
      }
    }
  }
}
</style>