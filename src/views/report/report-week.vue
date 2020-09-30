<template>
  <div class="report">
    <h3 class="report__title">Отчеты - Еженедельные отчеты</h3>

    <div class="report__body">
      <div class="report__body-control">
        <report-control @click="addTask">
          <template v-slot:titleInput>Наименование задачи</template>
          <template v-slot:titleSelect>Статус</template>
        </report-control>
      </div>
      <hr class="report__separator"/>
      <div class="report__body-list">
        <report-list :listItem="listItem"
                     @delete-task="deleteTask"></report-list>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

import reportControl from '@/components/report/report__control-week';
import reportList from '@/components/report/report__list-week';

export default {
  name: 'reportWeek',
  components: {
    reportControl,
    reportList,
  },
  computed: {
    userId() { return this.$store.state.userProfile.userId; }
  },
  data: function() {
    return {
      listItem: [
        {ID: '1', CNAMEAUTOR: 'Донцов Д.А.', VTASKNAME: 'Корректировка уровней доступа - Интернет', CSTATUS: 'Без статуса'},
        {ID: '2', CNAMEAUTOR: 'Корчмит А.А.', VTASKNAME: 'Создание связей ViPNet', CSTATUS: 'Без статуса'},
        {ID: '3', CNAMEAUTOR: 'Корчмит А.А.', VTASKNAME: 'Смена мастер-ключа', CSTATUS: 'В работе'},
        {ID: '4', CNAMEAUTOR: 'Давыдов А.Ю.', VTASKNAME: 'Смена парольной документации ПК КС', CSTATUS: 'Завершено'},
      ],
      weekStart: '0',
    }
  },
  created: function() {
    this.getTask();
  },
  methods: {
    getTask: function() {
      axios
        .post(pathBackEnd + 'php/report.php', null, {params: {function: 'taskGet'}})
        .then(response => {
          let arrItem = [];
          for (let i = 0; i < response.data.length; i++) {
            if (this.getWeekEnd(response.data[i].VTASKDATE)) { arrItem.push({WEEK: 'true', VTASKDATE: response.data[i].VTASKDATE, WEEKNAME: this.getWeekRange(response.data[i].VTASKDATE)});}
            arrItem.push(response.data[i]);
            if (i == response.data.length - 1) { this.listItem = arrItem; }
          }
        })
        .catch(() => { console.log('I`m tormoz') })
    },
    getWeekEnd: function(inDate) {
      let fDate = inDate; // this.modDate(inDate, 1);
      let cDate = new Date(fDate);
      let weekStart = cDate.getDate() - cDate.getDay() + 7;
      if (this.weekStart != weekStart) { this.weekStart = weekStart; return true; }
      return false;
    },
    getWeekRange: function(inDate) {
      let curr = new Date(inDate);
      let rMonth = curr.getMonth();
      let rYear = curr.getFullYear();
      let weekStart = curr.getDate() - curr.getDay() + 1;
      let weekEnd = weekStart + 6;
      // console.log( new Date(rYear, rMonth, weekEnd) );
      return this.formatedDateRange([new Date(rYear, rMonth, weekStart), new Date(rYear, rMonth, weekEnd)]);
    },
    formatedDateRange(noFormat) {
      let formatDate = '';
      let option = {
        day: '2-digit',
        month: 'short'
      };
      formatDate = Intl.DateTimeFormat('ru-RU',option).format(new Date(noFormat[0])).slice(0, -1) + ' - ' +
                   Intl.DateTimeFormat('ru-RU',option).format(new Date(noFormat[1])).slice(0, -1)
      return formatDate;
    },
    addTask: function(taskOption) {
      // console.log(taskOption);
      let option = {
        function: 'taskAdd',
        specId: taskOption.userId,
        taskText: taskOption.text,
        taskStatus: taskOption.status,
      }
      axios
        .post(pathBackEnd + 'php/report.php', null, {params: option})
        .then(response => {
          // console.log(response.data);
          this.getTask();
        })
    },
    deleteTask: function(taskOption) {
      console.log(this.userId);
      if (this.userId != taskOption.VAUTORID) {
        alert('This task is not your!!!');
        return;
      }
      let option = {
        function: 'taskDelete',
        taskId: taskOption.VID
      }
      axios
        .post(pathBackEnd + 'php/report.php', null, {params: option})
        .then(response => {
          // console.log(response.data);
          if (response.data == '1') this.getTask();
          else alert('Error for delete')
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.report {
  font-family: 'Montserrat';
  &__title {
    margin-bottom: 10px;
    color: darkslategrey;
  }
  &__separator {
    margin: 10px 20px;
  }
}
</style>