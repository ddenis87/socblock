<template>
  <div class="report-control">
    <div class="report-control__title">Добавить задачу</div>
    <c-input class="report-control__input"
             ref="fieldTask"
             v-model="taskText"><slot name="titleInput"></slot></c-input>
    <div class="report-control__box">
      <c-select class="report-control__select-item"
                :inListItem="listItem"
                v-model="taskStatus"
                inValue="Без статуса"><slot name="titleSelect"></slot></c-select>
      <c-button class="report-control__button-item"
                @click="addTask">Добавить</c-button>
    </div>
  </div>
</template>

<script>
import cInput from '@/components/elements/c-input';
import cSelect from '@/components/elements/c-select';
import cButton from '@/components/elements/c-button';

export default {
  name: 'reportControlWeek',
  components: {
    cInput,
    cSelect,
    cButton,
  },
  computed: {
    userId() { return this.$store.state.userProfile.userId; }
  },
  data: function() {
    return {
      taskText: '',
      taskTextDefault: '',
      taskStatus: '',
      listItem: [
        {ID: 'Без статуса', CNAME: 'Без статуса'},
        {ID: 'В работе', CNAME: 'В работе'},
        {ID: 'Завершено', CNAME: 'Завершено'},
      ],
    }
  },
  methods: {
    addTask: function() {
      this.taskTextDefault = this.taskText;
      let taskProps = {
        text: this.taskText,
        status: this.taskStatus,
        userId: this.userId,
      };
    
      this.$emit('click', taskProps);
      this.$refs.fieldTask.clear();
    },
  }
}
</script>

<style lang="scss" scoped>
.report-control {
  width: 100%;
  margin-bottom: 10px;
  padding: 0px 20px;
  box-sizing: border-box;
  &__title {
    margin-bottom: 5px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
  }
  &__input {
    margin-bottom: 10px;
  }
  &__box {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  &__select-item {
    width: 150px;
  }
  &__button-item {
    width: 150px;
  }
}
</style>