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
  grid-template-rows: 60px auto;
  grid-template-columns: 200px 1fr;
  margin: 10px auto;
  /* margin-left: 10px; */
  max-width: 1280px;
  width: 100%;
  min-height: 600px;
  /* background-color: rgb(245, 245, 245); */
  border-left: 2px solid grey;
  border-right: 2px solid grey;
  border-bottom: 2px solid grey;
}

.sideTop {
  grid-area: sideTop;
  padding: 5px 0px 5px 10px;
  border-bottom: 2px solid grey;
  background-color: rgb(54, 95, 147);
  /* background-image: linear-gradient(to right, rgb(54, 95, 147) 60%,white); */
}

.sideNav {
  grid-area: sideNav;
}

.content {
  grid-area: content;
  border-left: 2px solid grey;
  margin: 5px 0px;
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

@media only screen and (max-width: 800px), only screen and (max-device-width: 800px)  {
  .gridFull {
  display: grid;
  grid-template-areas: "sideTop sideTop"
                       "sideNav content";
  grid-template-rows: 60px auto;
  grid-template-columns: 50px 1fr;
  margin-left: 10px;
  max-width: 1280px;
  width: 100%;
}
  .sideNav {
    grid-area: sideNav;
    overflow: hidden;
    z-index: 1;
  }
  .content {
    background-color: white;
    z-index: 999;
  }
}


</style>