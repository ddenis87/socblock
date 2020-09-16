<template>
  <div class="control">
    <div class="filter-header">
      <div class="filter-header-element">
        <!-- Отчет будет сформирован на дату: {{ dateReportText }} -->
      </div>
      <div class="filter-header-element button-build" @click="buildingReport">
        Построить отчет <img src="/img/report-build.png" >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ocenkaReportControl',
}
</script>

<style lang="scss" scoped>

</style>