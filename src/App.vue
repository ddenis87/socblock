<template>
  <div id="app">
    <component :is="content">
      <router-view />
    </component>
  </div>
</template>

<script>
import substrateMain from "@/substrate/substrateMain"
export default {
  computed: {
    content() {return substrateMain;}
  },
  components: {
    substrateMain
  }
}
console.log(substrateMain);
</script>

<style>
body, div, fieldset, ul, li, img, h1, h2, h3 {
  margin: 0;
  padding: 0;
  border: 0px;
  font-family: Georgia, 'Times New Roman', Times, serif;
}


a {
  text-decoration:none;
}

h2 {
  color: forestgreen;
}
</style>
