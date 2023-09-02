<script setup>
import InputError from '@/Components/InputError.vue';
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
    ddlfile: null,
});

const submit = () => {
    form.post(route('post.uploadDdl', {'project_id': project.id}));
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">DDlアップロード</h2>
        </header>
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="ddlfile" value="DDLアップロード" />
                <TextInput
                    id="ddlfile"
                    type="file"
                    class="mt-1 block w-full"
                    @input="form.ddlfile = $event.target.files[0]"
                    required
                    autofocus
                />
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                アップロード
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
