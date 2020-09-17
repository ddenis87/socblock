<template>
  <div class="office-work">
    <div class="office-work-title">
      <h2 class="office-work-title__title">Отдел делопроизводства</h2>
    </div>
    <hr class="separator" />
    <office-work-register></office-work-register>
    <hr class="separator" />
  </div>
</template>

<script>
import officeWorkRegister from '@/components/units/office-work/office-work__register.vue';

export default {
  name: 'officeWork',
  components: {
    officeWorkRegister,
  }
}
</script>

<style lang="scss" scoped>
.office-work {
  padding-left: 10px;
  width: 98%;
  font-size: 14px;
  &-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    &__title {
      margin: 5px 0px;
      padding: 0px;
    }
    &__button {
      width: 150px;
      padding: 3px;
    }
  }
}

.separator {
  margin: 0px;
  margin-bottom: 5px;
}
</style>