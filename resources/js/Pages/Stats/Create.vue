<script setup>
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FileInput from '@/Components/FileInput.vue';


const props = defineProps({
    status: {
        type: String,
    },
    model: {
        type: Object
    }
});
const form = useForm({

});

const submit = () => {
    form.post(route('stats.store'), {
        onFinish: () => form.reset('file_input'),
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <FileInput />
        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Upload
        </PrimaryButton>
    </form>

    <img :src="props.imgPath">
    <ul v-for='(value, key) in props.model'>{{key}} {{value}}</ul>
</template>
