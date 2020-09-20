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

    <div class="substrate-main__side-footer">
      <side-footer></side-footer>
    </div>
  </div>
</template>

<script>
import sideTop from "@/components/units/side__top"
import sideNavigation from "@/components/units/side__navigation"
import sideFooter from "@/components/units/side__footer"

export default {
  name: 'substrateMain',
  components: {
    sideTop, sideNavigation, sideFooter,
  }
}
</script>

<style lang="scss" scoped>
@import '@/variables.scss';

.substrate-main {
  display: grid;
  grid-template-areas: "side-top side-top"
                       "side-navigation side-content"
                       "side-footer side-footer";
  grid-template-rows: 80px auto 40px;
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
    box-sizing: border-box;
    overflow: hidden;
  }
  &__side-content {
    grid-area: side-content;
    min-height: calc(100vh - 120px);
    padding-top: 5px;
    box-sizing: border-box;
  }
  &__side-footer {
    grid-area: side-footer;
    padding-top: 5px;
    box-sizing: border-box;
  }
}
@media print {
  .substrate-main {
    grid-template-areas: "side-top"
                         "side-content";
    grid-template-columns: 1fr;
    &__side-navigation {
      display: none;
    }
  }

}
</style>