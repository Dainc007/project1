<template>
    <Head :title="$t('Preview')"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Preview') }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:p-8 space-y-6 bg-white rounded-lg">
                <FormKit type="form" disabled v-model="model">
                    <FormKitSchema :schema="schema"/>
                </FormKit>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head,usePage} from '@inertiajs/vue3';
import {reactive} from "vue";
import {FormKitSchema} from "@formkit/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const model = reactive(usePage().props.model);

const schema = usePage().props.form;

</script>

<style scoped>

</style>
