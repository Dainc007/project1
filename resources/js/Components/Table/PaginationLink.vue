<template>
    <li
        class="flex h-8 font-medium"
    >
        <span
            @click="changePage"
            :class="getClass"
            v-if="typeof data.label === 'string'"
            v-html="data.label"
        >
        </span>
        <span
            @click="changePage"
            :class="getClass"
            v-else
        >
            {{ data.label }}
        </span>
    </li>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => {
            return {}
        }
    }
})

const emit = defineEmits(['changePage'])

const getClass = computed(() => {
    let activeClass = props.data.active ? `bg-gray-800 text-white hover:bg-gray-900` : 'hover:bg-gray-100';
    return `${activeClass} rounded-md w-8 md:flex justify-center items-center hidden cursor-pointer leading-5 transition duration-150 ease-in border-t-2 border-transparent`
})

const changePage = () => {
    emit('changePage', props.data.url);
    emit('changePage', props.data.url);
}
</script>

<style scoped>

</style>
