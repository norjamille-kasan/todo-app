<script setup lang="ts">
import UserLayout from '@/layouts/UserLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />
    <UserLayout :breadcrumbs="breadcrumbs">
        <p>Welcome to users dashboard</p>
    </UserLayout>
</template>
