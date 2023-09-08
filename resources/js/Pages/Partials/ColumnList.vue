<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    table: {
        type: Object,
    },
});

const columns = ref([]);
const column_name = ref(null);

watch(
    () => props.table,
    (newTable, oldTable) => {
        axios.get(`/api/tables/${newTable.id}/columns`)
        .then((response) => {
            columns.value = response.data;
         })
        .catch(console.error);
    }
);

const postColumn = () => {
    axios.post(`/api/tables/${props.table.id}/columns`, {
        column_name: column_name.value,
    })
    .then(response => {
        columns.value = response.data;
        column_name.value = null;
    })
    .catch(console.error);
};

const deleteColumn = (columnObj) => {
    axios.delete(`/api/tables/${props.table.id}/columns/${columnObj.id}`)
    .then(response => {
        columns.value = response.data;
        column_name.value = null;
    })
    .catch(console.error);
};
</script>

<template>
    <section class="space-y-6">
        <div>
            <InputLabel for="column_name" value="新規カラム名" />
            <TextInput
                id="column_name"
                type="text"
                class="mt-1 block w-full"
                v-model="column_name"
                required
                autofocus
                @keypress.enter="postColumn"
            />
            <table class="divide-y divide-gray-200 w-full">
                <tbody v-for="column in columns">
                    <tr>
                        <td>{{column.column_name}}</td>
                        <td>
                            <button @click="deleteColumn(column)">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
