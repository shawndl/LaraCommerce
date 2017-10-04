<template>
    <transition name="slide">
        <slot></slot>
    </transition>
</template>

<script>
    export default {

    }
</script>

<style>
    .slide-leave-active,
    .slide-enter-active {
        transition: 1s;
    }
    .slide-enter {
        transform: translate(100%, 0);
    }
    .slide-leave-to {
        transform: translate(-100%, 0);
    }
</style>