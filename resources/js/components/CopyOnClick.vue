<template>
  <span class="copy-on-click" @click="copyTextToClipboard(message, $event)">
      <slot />
  </span>
</template>

<script>
export default {
    props: [
        "message"
    ],

    methods: {
        fallbackCopyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
            } catch (err) { }

            document.body.removeChild(textArea);
        },

        copyTextToClipboard(text, event) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text);
            } else {
                this.fallbackCopyTextToClipboard(text);
            }

            let target = event.target.closest('.copy-on-click');

            target.setAttribute('data-after', 'Copied!');
            setTimeout(() => {
                target.setAttribute('data-after', '');
            }, 2000);
        }
    }
}
</script>

<style>
.copy-on-click {
    position: relative;
    user-select: none;
}

.copy-on-click::after {
    position: absolute;
    content: attr(data-after);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgb(68, 68, 68);
    border-radius: 5px;
    padding: 0px 3px;
}
</style>