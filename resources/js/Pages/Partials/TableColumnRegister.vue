<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref, onMounted } from 'vue';
import ColumnList from './ColumnList.vue';

const { project } = defineProps({
    project: {
        type: Object,
    },
});

const upload_file = ref(null); 
const tables = ref([]);
const table = ref(null);
const table_name = ref(null);
const isEdit = ref(false);
const table_name_put = ref(null);
const isShowModal = ref(false);

const closeModal = () => {
    isShowModal.value = false;
};

const showModal = () => {
    isShowModal.value = true;
};

onMounted(() => {
    axios.get(`/api/projects/${project.id}/tables`)
    .then((response) => {
        tables.value = response.data;
    })
    .catch(console.error);
});

const selectTable = (tableObj) => {
    table.value = tableObj;
}

const switchEditMode = () => {
    isEdit.value = !isEdit.value;
    if (isEdit.value) {
        table_name_put.value = table.value.table_name;
    }
}

const isEditMode = () => {
    return isEdit.value;
}

const postTable = () => {
    axios.post(`/api/projects/${project.id}/tables`, {
        table_name: table_name.value,
    })
    .then(response => {
        tables.value = response.data;
        table_name.value = null;
    })
    .catch(console.error);
};

const deleteTable = (tableObj) => {
    axios.delete(`/api/projects/${project.id}/tables/${tableObj.id}`)
    .then(response => {
        tables.value = response.data;
        table_name.value = null;
        switchEditMode();
    })
    .catch(console.error);
};

const putTable = () => {
    axios.put(`/api/projects/${project.id}/tables/${table.value.id}`, {
        table_name: table_name_put.value,
    })
    .then(response => {
        tables.value = response.data;
        table.value.table_name = table_name_put.value;
        table_name_put.value = null;
        switchEditMode();
    })
    .catch(console.error);
};

const postDdl = () => {
    const file = upload_file.value;
    const formData = new FormData();
    formData.append('file', file);
    
    axios.post(`/api/projects/${project.id}/ddl`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => {
        tables.value = response.data;
        upload_file.value = null;
        closeModal();
    })
    .catch(console.error);
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="height: 700px;">
        <button @click="showModal">DDlアップロード</button>
        <Modal :show="isShowModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    DDLアップロード
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    テーブル・カラムをまとめて登録します
                </p>

                <div class="mt-6">
                    <TextInput
                        id="ddlfile" 
                        type="file" 
                        @input="upload_file = $event.target.files[0]"
                        required />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

                    <PrimaryButton v-if="upload_file" @click="postDdl"> アップロード </PrimaryButton>
                    <PrimaryButton v-else @click="postDdl" disabled> アップロード </PrimaryButton>
                </div>
            </div>
        </Modal>

        <div class="p-5 text-gray-900 flex h-full w-full">
            <div class="h-full overflow-scroll w-1/2 mr-3">
                <InputLabel for="table_name" value="新規テーブル名" />
                <TextInput
                    id="table_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="table_name"
                    required
                    autofocus
                    @keypress.enter="postTable"
                />

                <table class="divide-y divide-gray-200 w-full">
                <tbody>
                    <tr v-for="table in tables">
                        <td class="pl-2 py-1">
                            <button @click="selectTable(table)" class="hover:text-blue-500 text-blue-700">
                                {{table.table_name}}
                            </button>
                        </td>
                        <td class="pl-2 py-1">
                            <button @click="deleteTable(table)">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>

            <div class="h-full w-full overflow-scroll bg-slate-50">
                <div v-if="table" class="flex justify-between">
                    <span v-if="isEditMode()" class="font-bold text-2xl pl-4 py-1">
                        <TextInput
                            id="table_name_put"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="table_name_put"
                            required
                            autofocus
                            @keypress.enter="putTable"
                        />
                    </span>
                    
                    <span v-else class="font-bold text-2xl pl-4 py-1">
                    {{table.table_name}}
                    </span>
                    <button @click="switchEditMode">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                </div>
                <div class="px-8">
                    <ColumnList :table=table />
                </div>
            </div>
        </div>
    </div>
</template>
