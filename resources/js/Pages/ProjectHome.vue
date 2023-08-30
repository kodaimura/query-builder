<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    project: {
        type: Object,
    },
    tables: {
        type: Array,
    },
});
</script>

<template>
    <Head title="ProjectHome" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{project.project_name}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table v-for="table in tables">
                        <tr>
                        <td>
                            <Link :href="route('get.projectHome', {'project_id': project.id})">
                            {{table.table_name}}
                            </Link>
                        </td>
                        </tr>
                    </table>
                    </div>
                </div>

            </div>      
        </div>
    </AuthenticatedLayout>
</template>
