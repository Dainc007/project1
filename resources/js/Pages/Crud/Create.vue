<template>
    <Head title="Competition"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ objectName }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:p-8 space-y-6 bg-white rounded-lg">
                <FormKit type="form" @submit="submit">
                    <FormKitSchema :schema="schema" />
                </FormKit>
<!--                <FormKit type="form" @submit="submit">-->
<!--                    <FormKitSchema :schema="newForm" />-->
<!--                </FormKit>-->
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, router, usePage} from '@inertiajs/vue3';
import {FormKitSchema} from "@formkit/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const schema = [
    {
        $formkit: 'text',
        name: 'name',
        label: 'Name',
        placeholder: 'Enter competition name',
        validation: 'required|length:6,255'
    }
];

const objectName = usePage().props.objectName;
const newForm    = usePage().props.assignTeamForm;
const submit = (data) => {
    router.post(route(`${objectName}.store`), data)
}

</script>

<style scoped>

</style>
