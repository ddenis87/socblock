<template>
  <form>
    <hr>
      <div class="find">
        <input type="text" placeholder="Укажите фамилию для поиска" v-model="fio" @keydown="findEnter"/>
        <input type="button" value="Найти..." @click="findClick" />
      </div>
  </form>
</template>

<script>
export default {
  data: () => ({
    fio: ''
  }),
  methods: {
    findClick() {
        this.$emit('findClick', this.fio)
    },
    findEnter(data) {
      if (data.code == "Enter" || data.code == "NumpadEnter") {
        event.preventDefault();
        this.findClick();
      }
    }
  }
}
</script>

<style scoped>
input[type="text"] {
  display: inline-block;
  margin: 3px;
  padding: 5px;
  outline: 0 !important ;
}

hr {
  margin-top: 0px;
}
</style>