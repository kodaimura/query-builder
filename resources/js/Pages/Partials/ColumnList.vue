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

const submit = () => {
    axios.post(`/api/tables/${props.table.id}/columns`, {
        column_name: column_name.value,
    })
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
            <InputLabel for="column_name" value="新規テーブル名" />
            <TextInput
                id="column_name"
                type="text"
                class="mt-1 block w-full"
                v-model="column_name"
                required
                autofocus
                @keypress.enter="submit"
            />
            <table v-for="column in columns">
                <tr>
                    <td>{{column.column_name}}</td>
                </tr>
            </table>
        </div>
    </section>
</template>
