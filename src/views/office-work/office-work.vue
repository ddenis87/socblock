<template>
  <div class="office-work">
    <div class="office-work-title">
      <h2 class="office-work-title__title">Отдел делопроизводства</h2>
    </div>
    <register></register>
  </div>
</template>

<script>
import register from '@/components/units/office-work/office-work__register.vue';

export default {
  name: 'office-work',
  components: {
    register,
  }
}
</script>

<style lang="scss" scoped>


.office-work {
  padding-left: 10px;
  width: 100%;
  max-width: 1000px;
  font-size: 14px;
}
.office-work-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  &__title {
    margin: 5px 0px;
    padding: 0px;
  }
}
</style>