<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UploadDdlForm from './Partials/UploadDdlForm.vue';
import TableForm from './Partials/TableForm.vue';
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

const table = ref(null);

const selectTable = (tableObj) => {
    table.value = tableObj;
}
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
                    <TableForm class="max-w-xl" :project=project />
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="height: 700px;">
                    <div class="p-5 text-gray-900 flex h-full w-full">
                        <div class="h-full overflow-scroll w-1/2">
                            <table class="divide-y divide-gray-200 w-full">
                            <tbody v-for="table in tables">
                                <tr>
                                    <td class="pl-2 py-1">
                                        <button @click="selectTable(table)" class="hover:text-blue-500 text-blue-700">
                                            {{table.table_name}}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <div class="h-full w-full overflow-scroll bg-slate-50">
                            <span v-if="table" class="font-bold text-2xl pl-5">
                                {{table.table_name}}
                            </span>
                            <div class="pl-10">
                                <ColumnList :table=table />
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </AuthenticatedLayout>
</template>
