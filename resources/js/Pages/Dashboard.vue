<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
                <Link 
                    class="bg-gray-500 hover:bg-gray-400 text-white rounded px-4 py-2"
                    :href="route('projects.create')">
                    プロジェクト作成
                </Link>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="project in projects">
                            <td>{{project.id}}</td>
                            <td>
                                <Link 
                                    class="hover:text-blue-500 text-blue-700"
                                    :href="route('projectDashboard', {'project_id': project.id})">
                                    {{project.project_name}}
                                </Link>
                            </td>
                            <td>
                                {{project.created_at}}
                            </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>      
        </div>
    </AuthenticatedLayout>
</template>
