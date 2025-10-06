<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import UserLayout from '@/layouts/UserLayout.vue';
import { Paginated, type BreadcrumbItem } from '@/types';
import { Todo } from '@/types/models';
import { Head, Link, router } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';
import { ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Todos',
        href: '#',
    },
];

const props = defineProps<{
    todos: Paginated<Todo>;
    searchTerm: string | null;
}>();

console.log(props.todos);

function deleteTodo(id: number) {
    const confirm = window.confirm(
        'Are you sure you want to delete this todo?',
    );

    if (confirm) {
        router.delete(`/user/todos/${id}`);
    }
}

const searchTerm = ref(props.searchTerm || '');

function submitSeachTerm() {
    router.reload({
        data: {
            search: searchTerm.value,
        },
    });
}

function clearSeachTerm() {
    searchTerm.value = '';
    router.reload({
        data: {
            search: '',
        },
    });
}
</script>

<template>
    <Head title="Todos" />
    <UserLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <form @submit.prevent="submitSeachTerm">
                        <Input
                            placeholder="Search"
                            v-model="searchTerm"
                            class="sm:w-80"
                            type="search"
                        />
                    </form>
                    <Button
                        v-if="props.searchTerm"
                        @click="clearSeachTerm"
                        variant="outline"
                    >
                        Clear Search
                    </Button>
                </div>
                <div>
                    <Button as-child>
                        <Link href="/user/todos/create">
                            <PlusIcon />
                            New Todo
                        </Link>
                    </Button>
                </div>
            </div>
            <div>
                <Link
                    v-for="link in props.todos.links"
                    :key="link.label"
                    :href="link.url || '#'"
                >
                    <Button
                        v-html="link.label"
                        :variant="link.active ? 'default' : 'outline'"
                    >
                    </Button>
                </Link>
            </div>
            <div class="overflow-hidden rounded-lg border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead> Description </TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right"> Action </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="todo in props.todos.data"
                            :key="todo.id"
                        >
                            <TableCell class="font-medium">
                                {{ todo.description }}
                            </TableCell>
                            <TableCell>
                                <span
                                    v-if="todo.status === 'pending'"
                                    class="rounded-full bg-yellow-500 px-2 py-1 text-white"
                                >
                                    Pending
                                </span>
                                <span
                                    v-else-if="todo.status === 'in_progress'"
                                    class="rounded-full bg-blue-500 px-2 py-1 text-white"
                                >
                                    In Progress
                                </span>
                                <span
                                    v-else-if="todo.status === 'completed'"
                                    class="rounded-full bg-green-500 px-2 py-1 text-white"
                                >
                                    Completed
                                </span>
                            </TableCell>
                            <TableCell class="text-right">
                                <div
                                    class="flex w-full items-center justify-end space-x-1"
                                >
                                    <Button variant="outline" as-child>
                                        <Link
                                            :href="
                                                '/user/todos/' +
                                                todo.id +
                                                '/edit'
                                            "
                                        >
                                            Edit
                                        </Link>
                                    </Button>
                                    <Button
                                        @click="deleteTodo(todo.id)"
                                        variant="destructive"
                                    >
                                        Delete
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </UserLayout>
</template>
