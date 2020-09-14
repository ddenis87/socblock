<template>
    <div class="substrate-main">
    <div class="substrate-main__side-top">
      <sideTop />
    </div>

    <div class="substrate-main__side-navigation">
      <sideNavigation />
    </div>

    <div class="substrate-main__side-content">
      <router-view />
    </div>

  </div>
</template>

<script>
import sideTop from "@/components/units/side__top"
import sideNavigation from "@/components/units/side__navigation"

export default {
  name: 'substrateMain',
  components: {
    sideTop, sideNavigation
  }
}
</script>

<style lang="scss" scoped>
@import '@/variables.scss';

.substrate-main {
  display: grid;
  grid-template-areas: "side-top side-top"
                       "side-navigation side-content";
  grid-template-rows: 80px auto;
  grid-template-columns: auto 1fr;
  width: 100%;
  box-sizing: border-box;

  &__side-top {
    grid-area: side-top;
    box-sizing: border-box;
  }
  &__side-navigation {
    grid-area: side-navigation;
    max-width: $navigationWidthDefault;
    // border: 1px solid grey;
    box-sizing: border-box;
    overflow: hidden;
  }
  &__side-content {
    grid-area: side-content;
    box-sizing: border-box;
  }
}
</style>

<style>
 @media print {
   .gridFull {
   display: grid;
   grid-template-areas: "sideTop"
                        "content";
   grid-template-rows: 60px auto;
   grid-template-columns: 1fr;
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
 .sideTop {background-color: white;}
 .sideNav {display: none;}
 .content {border: 0px;}
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