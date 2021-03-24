<template>
    <div id="mainApp">
        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>

<style>
    * {
        margin: 0px;
        padding: 0px;
        color: white
    }

    pre {
        color: white;
    }

    body {
        background-color: gray;
    }

    pre {
        white-space: pre-wrap;     /* Since CSS 2.1 */
        white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
        white-space: -pre-wrap;   /* Opera 4-6 */
        white-space: -o-pre-wrap;   /* Opera 7 */
        word-wrap: break-word;     /* Internet Explorer 5.5+ */
    }

    #mainApp {
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translate(-50%, 0%);

        width: 60vw;
        height: 70vh;
        min-height: 650px;

        background-color: darkgray;
        border-radius: 20px;
    }

    .container {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translate(-50%, 0%);
    }
</style>