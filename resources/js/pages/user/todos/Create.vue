<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import UserLayout from '@/layouts/UserLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Todos',
        href: '/user/todos',
    },
    {
        title: 'Create',
        href: '#',
    },
];

const form = useForm({
    description: '',
    status: 'pending',
});

function submit() {
    form.post('/user/todos');
}
</script>

<template>
    <Head title="Create Todo" />
    <UserLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-4">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- description iput -->
                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <Textarea
                        id="description"
                        name="description"
                        v-model="form.description"
                    />
                </div>

                <div class="space-y-2">
                    <Label for="status">Status</Label>
                    <Select v-model="form.status">
                        <SelectTrigger>
                            <SelectValue placeholder="Select Status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="pending"> Pending </SelectItem>
                            <SelectItem value="in_progress">
                                In Progress
                            </SelectItem>
                            <SelectItem value="completed">
                                Completed
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <div>
                    <Button type="submit" :disabled="form.processing">
                        Save Todo
                    </Button>
                </div>
                <!-- status input -->
            </form>
        </div>
    </UserLayout>
</template>
