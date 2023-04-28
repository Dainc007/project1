<template>
    <Head title="Competition"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Competition</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:p-8 space-y-6 bg-white rounded-lg">
                <button-component
                    :href="route('competition.create')"
                    label="Add"
                    :as="Link"
                    color="success"
                    icon="fas fa-plus"
                >
                </button-component>
                <data-table
                    :actions="tableConfig.actions"
                    :data-source="tableConfig.dataUrl"
                    :fetch-data-headers="fetchDataHeaders"
                    :heading="tableConfig.columns"
                    :per-page="tableConfig.perPage"
                    :search-input-placeholder="'Search...'"
                    v-on:action:click="actionClick"
                ></data-table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head,usePage,router} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from './../../Components/Table/Table.vue'
import ButtonComponent from "@/Components/ButtonComponent.vue";
import {computed} from "vue";
import {Link} from "@inertiajs/vue3";

const tableConfig = computed(() => usePage().props.table)

const fetchDataHeaders = {'X-CSRF-Token': usePage().props.csrf_token}

const actionClick = (event) => {
    let data = {};
    for (let key in event.action.params) {
        data[key] = event.row.hasOwnProperty(event.action.params[key]) ? event.row[event.action.params[key]] : event.action.params[key]
    }
    console.log(event.row,tableConfig.value.objectKey);

    router.visit(event.action.href.replace('#id#', event.row[`${tableConfig.value.objectKey}`]), {
        method: event.action.method,
        data
    })
};


</script>

<style scoped>

</style>
