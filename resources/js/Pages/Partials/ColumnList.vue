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
const column = ref(null);
const column_name = ref(null);
const column_name_put = ref(null);

watch(
    () => props.table,
    (newTable, oldTable) => {
        if (newTable == null) {
            columns.value = null
        } else {
            axios.get(`/api/tables/${newTable.id}/columns`)
            .then((response) => {
                columns.value = response.data;
            })
            .catch(console.error);
        }
    }
);

const selectColumn = (columnObj) => {
    if (column.value != null && columnObj.id == column.value.id) {
        column.value = null;
        column_name_put.value = null;
    } else {
        column.value = columnObj;
        column_name_put.value = columnObj.column_name
    }
}

const isSelected = (columnObj) => {
    return column.value != null && 
    columnObj != null && 
    column.value.id == columnObj.id;
}

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

const putColumn = () => {
    axios.put(`/api/tables/${props.table.id}/columns/${column.value.id}`, {
        column_name: column_name_put.value,
    })
    .then(response => {
        columns.value = response.data;
        column_name_put.value = null;
        column.value = null;
    })
    .catch(console.error);
};
</script>

<template>
    <section class="space-y-6">
        <div>
            <div v-if="props.table">
                <InputLabel for="column_name" value="新規カラム名" />
                <TextInput
                
                    id="column_name"
                    type="text"
                    class="my-2 block"
                    v-model="column_name"
                    required
                    autofocus
                    @keypress.enter="postColumn"
                />
            </div>
            <table class="w-full">
                <tbody class="divide-y divide-gray-200 w-full">
                    <tr v-for="column in columns">
                        <td v-if="isSelected(column)">
                            <TextInput
                                id="column_name_put"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="column_name_put"
                                required
                                autofocus
                                @keypress.enter="putColumn"
                            />
                        </td>
                        <td v-else>{{column.column_name}}</td>
                        <td>
                            <button @click="selectColumn(column)">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                        </td>
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
