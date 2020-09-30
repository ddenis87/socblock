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
        <report-list :listItem="listItem"></report-list>
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
  data: function() {
    return {
      listItem: [
        {ID: '1', CNAMEAUTOR: 'Донцов Д.А.', VTASKNAME: 'Корректировка уровней доступа - Интернет', CSTATUS: 'Без статуса'},
        {ID: '2', CNAMEAUTOR: 'Корчмит А.А.', VTASKNAME: 'Создание связей ViPNet', CSTATUS: 'Без статуса'},
        {ID: '3', CNAMEAUTOR: 'Корчмит А.А.', VTASKNAME: 'Смена мастер-ключа', CSTATUS: 'В работе'},
        {ID: '4', CNAMEAUTOR: 'Давыдов А.Ю.', VTASKNAME: 'Смена парольной документации ПК КС', CSTATUS: 'Завершено'},
      ]
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
          // console.log(response.data);
          this.listItem = response.data;
        })
    },
    addTask: function(taskOption) {
      console.log(taskOption);
      let option = {
        function: 'taskAdd',
        specId: taskOption.userId,
        taskText: taskOption.text,
        taskStatus: taskOption.status,
      }
      axios
        .post(pathBackEnd + 'php/report.php', null, {params: option})
        .then(response => {
          console.log(response.data);
          this.getTask();
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