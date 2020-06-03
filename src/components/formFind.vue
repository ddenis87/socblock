<template>
  <form>
    <hr>
      <div class="find">
        <input type="text" placeholder="Укажите фамилию для поиска" v-model="fio"/>
        <input type="button" value="Найти..." />
      </div>
    <hr>
  </form>
</template>

<script>
export default {
  data: () => ({
    fio: ''
  })
}
</script>