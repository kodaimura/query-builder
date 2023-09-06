<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import ColumnList from './ColumnList.vue';

const {project} = defineProps({
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

const form = useForm({
    table_name: '',
});

const submit = () => {
    form.post(route('tables.store', {'project_id': project.id}));
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="height: 700px;">
        <div class="p-5 text-gray-900 flex h-full w-full">
            <div class="h-full overflow-scroll w-1/2 mr-3">
                <form class="mt-6">
                    <InputLabel for="table_name" value="新規テーブル名" />
                    <TextInput
                        id="table_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.table_name"
                        required
                        autofocus
                        @keypress.enter="submit"
                    />
                </form>

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
                <div class="flex justify-between">
                    <span v-if="table" class="font-bold text-2xl pl-4 py-1">
                    {{table.table_name}}
                    </span>
                    <Link class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        編集
                    </Link>
                </div>
                <div class="pl-10">
                    <ColumnList :table=table />
                </div>
            </div>
        </div>
    </div>
</template>
