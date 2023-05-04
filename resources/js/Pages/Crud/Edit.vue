<template>
    <Head title="Competition"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Competition</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:p-8 space-y-6 bg-white rounded-lg">
                <FormKit type="form" @submit="submit" v-model="model">
                    <FormKitSchema :schema="schema"/>
                </FormKit>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head,router,usePage} from '@inertiajs/vue3';
import {reactive} from "vue";
import {FormKitSchema} from "@formkit/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {da} from "@formkit/i18n";

const model = reactive(usePage().props.model);

const schema = usePage().props.form;

const objectName = usePage().props.objectName;

const submit = (data) => {
    let params = {};
    params[objectName] = data.id
    router.put(route(`${objectName}.update`,params), data)
}

</script>

<style scoped>

</style>
