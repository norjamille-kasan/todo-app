<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
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
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="text-3xl font-bold">Admin Dashboard</div>
    </AdminLayout>
</template>
