<template>
    <span :class="'icon ' + this.classes"></span>
</template>

<script>
let cache = new Map();

export default {
  props: {
    src: { 
      type: String,
      required: true 
    },
    classes: {
      type: String,
      default: function() {
        return ''
      }
    },
  },
  async mounted() {
    if (!cache.has(this.src)) {
      try {
        cache.set(this.src, fetch(this.src).then(r => r.text()));
      } catch (e) {
        cache.delete(this.src);
      }
    }
    if (cache.has(this.src)) {
      this.$el.innerHTML = await cache.get(this.src);
    }
  }
};
</script>