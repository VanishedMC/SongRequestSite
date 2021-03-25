<template>
  <div class="spoiler-hidden" @click="reveal($event)">
      <slot />
  </div>
</template>

<script>
export default {
    props: [
        "message"
    ],

    methods: {
        reveal(event) {
            event.target.classList.remove('spoiler-hidden');
        }
    }
}
</script>

<style>
    .spoiler-hidden {
        position: relative;
    }

    .spoiler-hidden::after {
        position: absolute;
        content: 'Click to reveal';
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background-color: black;
        border-radius: 5px;
    }
</style>