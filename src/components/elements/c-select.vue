<template>
  <div class="c-select">
    <label class="c-select__title"><slot></slot></label>
    <select class="c-select__select"
            v-model="selectValue"
            @change="changeSelectValue">
      <option value="0" selected></option>
      <option v-for="(item, index) in listItem" 
              :key="index" 
              :value="item.ID">{{ item.CNAME }}</option>
    </select>
  </div>  
</template>

<script>
export default {
  name: 'cSelect',
  model: {
    event: 'change'
  },
  props: [
    'inListItem',
    'inValue'
  ],
  computed: {
    listItem() { return this.inListItem }
  },
  data: function() {
    return {
      selectValue: '0',
    }
  },
  created: function() {
    this.selectValue = this.inValue;
    console.log(this.inValue)
    this.changeSelectValue();
  },
  methods: {
    changeSelectValue: function() {
      this.$emit('change', this.selectValue);
    }
  }
}
</script>

<style lang="scss" scoped>
.c-select {
  position: relative;
  &__title {
    position: absolute;
    left: 5px;
    top: 5px;
    font-size: 8px;
    text-transform: uppercase;
  }
  &__select {
    left: 0px;
    top: 0px;
    width: 100%;
    padding: 3px;
    padding-left: 5px;
    padding-top: 16px;
    font-size: 14px;
    border: 1px solid grey;
    border-radius: 3px;
    box-sizing: border-box;
    outline: none;
    &:focus {
      box-shadow: 1px 1px 1px lightblue, -1px -1px 1px lightblue;
    }
    &_validation {
      box-shadow: 1px 1px 1px red, -1px -1px 1px red;
    }
  }
}
</style>