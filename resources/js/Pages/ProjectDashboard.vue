<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UploadDdlForm from './Partials/UploadDdlForm.vue';
import TableColumnRegister from './Partials/TableColumnRegister.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import ColumnList from './Partials/ColumnList.vue';

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
    <Head title="ProjectDashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{project.project_name}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UploadDdlForm class="max-w-xl" :project=project />
                </div>

                <TableColumnRegister :project=project :tables=tables />
            </div>      
        </div>
    </AuthenticatedLayout>
</template>
