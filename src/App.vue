<template>
  <div id="app">
    <component :is="content">
      <router-view />
    </component>
  </div>
</template>

<script>
import substrateMain from "@/substrate/substrate__main"
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

<style lang="scss">
@import 'variables.scss';
@import 'fonts.scss';

html {
  overflow-y: scroll;
}
body {
  margin: 0;
}

#app {
  width: 100%;
  max-width: $pageWidthDefault;
  margin-left: auto;
  margin-right: auto;
}

h1, h2, h3 {
  font-family: 'Open sans';
  color: grey;
}

a {text-decoration: none;}

</style>