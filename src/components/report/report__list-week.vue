<template>
  <div class="report-list">
    <table class="report-list__table">
      <thead class="report-list__table-head">
        <tr class="report-list__table-head_row">
          <th class="report-list__table-head_column">№ п/п</th>
          <th class="report-list__table-head_column">Дата</th>
          <th class="report-list__table-head_column">Наименование задачи</th>
          <th class="report-list__table-head_column">Автор</th>
          <th class="report-list__table-head_column">Статус</th>
          <th class="report-list__table-head_column">Действия</th>
        </tr>
      </thead>
      <tbody class="report-list__table-body">
        <template v-for="(item, index) in listItem">
          <template v-if="('WEEK' in item)">
            <tr class="report-list__table-body_row report-list__table-body_row-week" :key="index" >
              <td class="report-list__table-body_column" colspan="6">{{ item.WEEKNAME }}</td>
            </tr>
          </template>
          <template v-else>
            <tr class="report-list__table-body_row"
                :key="index">
              <td class="report-list__table-body_column">{{ index + 1 }}</td>
              <td class="report-list__table-body_column">{{ modDate(item.VTASKDATE) }}</td>
              <td class="report-list__table-body_column">{{ item.VTASKNAME }}</td>
              <td class="report-list__table-body_column">{{ item.VAUTOR }}</td>
              <td class="report-list__table-body_column">{{ item.VTASKSTATUS }}</td>
              <td class="report-list__table-body_column">
                <div class="control">
                  <button class="control__button control__button_delete" 
                          title="Удалить запись"
                          @click="deleteTask(item)"></button>
                </div>
              </td>
            </tr>
          </template>
          
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'reportListWeek',
  props: {
    listItem: Array,
  },
  data: function() {
    return {
      // arrMonth: ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'],
      // weekStart: 0,
      // filterListItem: [],
    }
  },
  methods: {
    modDate: function(val, type) {
      // console.log(val);
      let nVal = String(val);
      let nDay = nVal.slice(8,10);
      let nMonth = nVal.slice(5,7);
      let nYear = nVal.slice(0,4);
      nVal = nDay + '.' + nMonth + '.' + nYear;
      if (type == 1) {
        nVal = nYear + '-' + nMonth + '-' + nDay;
      }
      return nVal;
    },
    deleteTask: function(item) {
      this.$emit('delete-task', item);
    }
  }
}
</script>

<style lang="scss" scoped>
.report-list {
  margin-bottom: 10px;
  padding-left: 20px;
  padding-right: 20px;
  font-family: 'Open sans';
  font-size: 13px;
  &__table {
    width: 100%;
    border-collapse: collapse;
    &-head {
      &_row { border-bottom: 1px solid grey; }
      &_column { padding: 5px; }
      &_column:nth-child(1) { width: 40px; }
      &_column:nth-child(2) { width: 70px; }
      // &_column:nth-child(3) { width: 53px; }
      &_column:nth-child(4) { width: 100px; }
      &_column:nth-child(5) { width: 80px; }
      &_column:nth-child(6) { width: 65px; }
    }
    &-body {
      &_row { border-bottom: 1px solid grey; }
      &_row-week { 
        font-weight: bold;
        font-style: italic;
        background-color: rgba(173, 216, 230, .3);
      }
      &_row-disabled {
        background-color: darkgray;
      }
      &_column { padding: 5px; }
      // &_column:nth-child(3) {  }
      &_column:nth-child(6) {
        padding: 0px 10px;
        .control {
          display: flex;
          justify-content: center;
          align-items: center;
          &__button {
            width: 24px;
            height: 24px;
            border: 0px;
            background-color: rgba(0, 0, 0, 0);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            cursor: pointer;
            &_disabled-on { background-image: url('~@/assets/images/control/button_disabled-on.png'); }
            &_disabled-off { background-image: url('~@/assets/images/control/button_disabled-off.png'); }
            &_delete { 
              background-image: url('~@/assets/images/control/button_delete.png');
            }
          }
        }
      }
    }
  }
}
</style>