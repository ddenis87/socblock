<template>
  <div class="office-work">
    <div class="title">
      <h2>Отдел делопроизводства</h2>
    </div>
    <register></register>
  </div>
</template>

<script>
import register from '@/components/office-work/office-work__register.vue';

export default {
  name: 'office-work',
  components: {
    register,
  }
}
</script>

<style scoped>
  .office-work {
    padding-left: 10px;
    width: 100%;
    max-width: 1000px;
    font-size: 14px;
  }

</style>