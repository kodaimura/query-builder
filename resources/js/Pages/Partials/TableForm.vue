<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const { project } = defineProps({
    project: {
        type: Object,
    },
});

const form = useForm({
    table_name: '',
});

const submit = () => {
    form.post(route('tables.store', {'project_id': project.id}));
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">新規テーブル追加</h2>
        </header>
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="table_name" value="テーブル名" />
                <TextInput
                    id="table_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.table_name"
                    required
                    autofocus
                />
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                登録
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
