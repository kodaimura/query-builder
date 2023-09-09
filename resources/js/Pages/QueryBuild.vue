<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

const { project } = defineProps({
    project: {
        type: Object,
    },
});

const tables = ref([]);
const main_table = ref(null);
const main_columns = ref([]);

onMounted(() => {
    axios.get(`/api/projects/${project.id}/tables`)
    .then((response) => {
        tables.value = response.data;
    })
    .catch(console.error);
});

const selectMainTable = (tableObj) => {
    main_table.value = tableObj;
} 

watch(
    main_table,
    (newTable, oldTable) => {
        if (main_table.value == null) {
            console.log(main_table);
            main_columns.value = null
        } else {
            console.log(main_table);
            axios.get(`/api/tables/${newTable.id}/columns`)
            .then((response) => {
                main_columns.value = response.data;
            })
            .catch(console.error);
        }
    }
);
</script>

<template>
    <Head title="QueryBuild" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{project.project_name}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div v-if="main_table">
                    {{main_table.table_name}}
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-200 w-full">
                            <tr v-for="column in main_columns">
                                <td>{{column.column_name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table v-else class="w-full">
                    <tbody class="divide-y divide-gray-200 w-full">
                        <tr v-for="table in tables">
                            <td class="pl-2 py-1">
                                <button @click="selectMainTable(table)" class="hover:text-blue-500 text-blue-700">
                                    {{table.table_name}}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>      
        </div>
    </AuthenticatedLayout>
</template>