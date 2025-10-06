<script setup lang="ts">
import { ListTodo } from 'lucide-vue-next';
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <ListTodo :class="className" v-bind="$attrs" />
</template>
