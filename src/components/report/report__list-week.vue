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
        <template v-for="(item, index) in filterListItem">
          <template v-if="('WEEK' in item)">
            <tr class="report-list__table-body_row report-list__table-body_row-week" :key="index" >
              <td class="report-list__table-body_column" colspan="6">{{  }}</td>
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
                          @click="deleteItem(item)"></button>
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
  computed: {
    tListItem() { return this.listItem; }
  },
  data: function() {
    return {
      arrMonth: ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'],
      weekStart: 0,
      filterListItem: [],
    }
  },
  created: function() {
    this.filterListItem = this.tFiltr(this.listItem);
  },
  methods: {
    tFiltr(listItem) {
      // this.filterListItem.push(this.listItem);
      let arrItem = [];
      for (let i = 0; i < listItem.length; i++) {
        if (this.getWeekEnd(listItem[i].VTASKDATE)) { arrItem.push({WEEK: 'true', VTASKDATE: listItem[i].VTASKDATE});}
        arrItem.push(listItem[i]);
      //   // this.filterListItem.push(this.tListItem[i]);
      //   // this.getWeekEnd(this.tListItem[i].VTASKDATE); 
      //   // console.log(this.getWeekEnd(this.tListItem[i].VTASKDATE));
        if (i == this.listItem.length - 1) {console.log(arrItem); return arrItem;}
      }
      
    },
    getWeekEnd: function(inDate) {
      let fDate = this.modDate(inDate, 1);
      let cDate = new Date(fDate);
      let weekStart = cDate.getDate() - cDate.getDay() + 7;
      // console.log(weekStart);
      // console.log(this.weekStart);
      if (this.weekStart != weekStart) { this.weekStart = weekStart; return true; }
      return false;
    },
    getWeekRange: function(inDate) {
      let curr = new Date(inDate);
      let rMonth = curr.getMonth();
      let rYear = curr.getFullYear();
      let weekStart = curr.getDate() - curr.getDay() + 1;
      let weekEnd = weekStart + 6;
      console.log( new Date(rYear, rMonth, weekEnd) );
      return this.formatedDateRange(new Date(rYear, rMonth, weekStart)) + ' - ' + this.formatedDateRange(new Date(rYear, rMonth, weekEnd));
    },
    modDate: function(val, type) {
      let nVal = String(val);
      let nDay = nVal.slice(0,2);
      let nMonth = ((this.arrMonth.indexOf(nVal.slice(3,6)) + 1) < 10) ? '0' + String(this.arrMonth.indexOf(nVal.slice(3,6)) + 1) : String(this.arrMonth.indexOf(nVal.slice(3,6)) + 1);
      let nYear = '20' + String(nVal.slice(7,9));
      nVal = nDay + '.' + nMonth + '.' + nYear;
      if (type == 1) {
        nVal = nYear + '-' + nMonth + '-' + nDay;
      }
      return nVal;
    },
    formatedDateRange(noFormat) {
      let formatDate = '';
      let option = {
        day: '2-digit',
        month: 'short'
      };
      formatDate = Intl.DateTimeFormat('ru-RU',option).format(new Date(noFormat)).slice(0, -1);
      return formatDate;
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
      &_column:nth-child(4) { width: 80px; }
      &_column:nth-child(5) { width: 80px; }
      &_column:nth-child(6) { width: 65px; }
    }
    &-body {
      &_row { border-bottom: 1px solid grey; }
      &_row-week { background-color: rgba(173, 216, 230, .3); }
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