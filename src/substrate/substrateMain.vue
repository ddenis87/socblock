<template>
    <div class="gridFull">
    <fieldset class="sideTop">
      <sideTop />
    </fieldset>

    <fieldset class="sideNav">
      <sideNav />
    </fieldset>

    <fieldset class="content">
      <router-view />
    </fieldset>

  </div>
</template>

<script>
import sideTop from "@/components/sideTop"
import sideNav from "@/components/sideNav"

export default {
  components: {
    sideTop, sideNav
  }
}
</script>

<style>
.gridFull {
  display: grid;
  grid-template-areas: "sideTop sideTop"
                       "sideNav content";
  grid-template-rows: auto auto;
  grid-template-columns: 200px 1fr;
  margin-left: 10px;
}

.sideTop {
  grid-area: sideTop;
  padding: 5px 0px 5px 10px;
  border-bottom: 2px solid grey;
  background-image: linear-gradient(to right, white 40%, blue);
}

.sideNav {
  grid-area: sideNav;
}

.content {
  grid-area: content;
  border-left: 2px solid grey;
  margin: 5px;
  padding: 5px;
}


.find input[type="text"] {
    width: 300px;
    margin: 5px;
    padding: 5px;
    border: 0px;
    border-bottom: 2px solid grey;
}

.find input[type="button"] {
  width: 100px;
  margin: 5px;
}

</style>