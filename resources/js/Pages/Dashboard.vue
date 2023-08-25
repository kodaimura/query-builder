<script setup>
import { ref, onBeforeMount } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const projects = ref([])

onBeforeMount(() => {
    fetch("api/projects")
    .then(response => {
        return response.json()
    })
    .then(data => {
        projects.value = data;
    })
    .catch(console.error);
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
