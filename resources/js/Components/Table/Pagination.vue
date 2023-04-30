<template>
    <div
        class="flex justify-between text-xs font-semibold tracking-wide py-2 text-gray-500 uppercase border-t sm:grid-cols-9"
    >
        <div class="flex items-center col-span-3">
            {{$t('Showing')}}
            {{ paginator.from || 0 }}
            {{$t('to')}}
            {{ paginator.to || 0}}
            {{$t('of')}}
            {{ paginator.total  || 0}}
            {{$t('results')}}
        </div>
        <div class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <ul class="inline-flex items-center">
                <pagination-link
                    v-for="(link,key) in paginator.links"
                    :key="key"
                    v-on:changePage="changePage"
                    :data="link">
                </pagination-link>
            </ul>
        </div>
    </div>
</template>

<script setup>
import PaginationLink from "./PaginationLink.vue";

const props = defineProps({
    paginator: {
        type: Object,
        default: () => {
            return {}
        }
    },
});

const emit = defineEmits(['changePage']);

const changePage = (url) => {
    emit('changePage', url);
}

</script>

<style scoped>

</style>
