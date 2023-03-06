<template>
  <div>
    <slot v-for="item in items" :item="item" :key="getKey(item)">
      {{ item }}
    </slot>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
    keyProp: {
      type: String,
      default: "id",
    },
    itemClass: {
      type: String,
      default: "",
    },
  },
  methods: {
    getKey(item) {
      return item[this.keyProp];
    },
  },
};
</script>
