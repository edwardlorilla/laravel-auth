<template>
    <transition mode="out-in" name="no-mode-translate-fade">
        <slot></slot>
    </transition>
</template>
<style>
    .no-mode-translate-fade-enter-active, .no-mode-translate-fade-leave-active {
        transition: all 0.4s;
    }
    .no-mode-translate-fade-enter, .no-mode-translate-fade-leave-active {
        opacity: 0;
    }
    .no-mode-translate-fade-enter {
        transform: translateX(31px);
    }
    .no-mode-translate-fade-leave-active {
        transform: translateX(-31px);
    }
</style>
