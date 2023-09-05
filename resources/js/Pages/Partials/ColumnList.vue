<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    table: {
        type: Object,
    },
});

const columns = ref([]);

watch(
    () => props.table,
    (newTable, oldTable) => {
        fetch(`/api/tables/${newTable.id}/columns`)
        .then(response => {
            return response.json()
        })
        .then(data => {
            columns.value = data;
        })
        .catch(console.error);
    }
);
</script>

<template>
    <section class="space-y-6">
        <div>
            <table v-for="column in columns">
                <tr>
                    <td>{{column.column_name}}</td>
                </tr>
            </table>
        </div>
    </section>
</template>
