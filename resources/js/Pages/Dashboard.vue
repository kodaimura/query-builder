<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectForm from './Partials/ProjectForm.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ProjectForm class="max-w-xl"/>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                    <table v-for="project in projects">
                        <tr>
                        <td>{{project.id}}</td>
                        <td>
                            <Link href="href">
                            {{project.project_name}}
                            </Link>
                        </td>
                        </tr>
                    </table>
                    </div>
                </div>

            </div>      
        </div>
    </AuthenticatedLayout>
</template>
