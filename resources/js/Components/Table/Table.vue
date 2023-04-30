<template>
    <div class="container mx-auto">
        <div class="mb-4 flex justify-between items-center">
            <div class="flex-1 pr-4">
                <div class="relative md:w-1/3">
                    <label>
                        <input
                            type="text"
                            v-on:keyup.enter="getDataFromSource()"
                            v-model="search"
                            class="w-full pl-10 pr-4 py-2 rounded-lg shadow border focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                            :placeholder="searchInputPlaceholder"
                        >
                    </label>
                    <div class="absolute top-0 left-0 inline-flex items-center p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                            <circle cx="10" cy="10" r="7"/>
                            <line x1="21" y1="21" x2="15" y2="15"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div v-if="selectedRows.length" class="bg-teal-200 ">
                <div class="container mx-auto px-4 py-4">
                    <div class="flex md:items-center">
                        <div v-html="selectedRows.length + ' rows are selected'" class="text-teal-800 text-lg"></div>
                    </div>
                </div>
            </div>
            <div class="shadow rounded-lg flex">
                <div class="relative">
                    <button @click.prevent="columnsHiderButtonOpen = !columnsHiderButtonOpen"
                            class="rounded-lg inline-flex items-center bg-blue-500 hover:bg-blue-600 focus:outline-none focus:shadow-outline text-white font-semibold py-2 px-2 md:px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                            <path
                                d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5"/>
                        </svg>
                        <span class="hidden md:block">{{$t('Columns')}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <div v-if="columnsHiderButtonOpen" @click.away="columnsHiderButtonOpen = false"
                         class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                        <template v-for="column in headingColumns">
                            <div
                                class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2 text-teal-600">
                                <label
                                    class="mx-2"
                                >
                                    <input type="checkbox"
                                           class="form-checkbox focus:outline-none focus:shadow-outline mr-3"
                                           :checked="column.visible"
                                           @click="toggleColumn(column.name)">
                                    <span class="select-none text-gray-700" v-html="column.title"></span>
                                </label>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                <tr class="text-left">
                    <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100" v-if="selects">
                        <label
                            class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                            <input class="cursor-pointer form-checkbox focus:outline-none focus:shadow-outline"
                                   type="checkbox"
                                   @click="selectAllCheckbox($event);">
                        </label>
                    </th>
                    <template v-for="(column, index) in getVisibleHeading">
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-4 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs"
                            :class="{'cursor-pointer': column.sortable}"
                            @mousemove="onHeaderMouseEvent($event, index,true)"
                            @mouseleave="onHeaderMouseEvent($event, index,false)"
                            @click="addSort(column)"
                        >
                            <div class="flex justify-between">
                                <span class="my-auto">{{ column.title }}</span>
                                <icon
                                    size="xs"
                                    :class="{
                                        'fas': true,
                                        'fa-sort': (column.sortable && column.showIcon),
                                        'fa-sort-up': getSortedDir(column) === 'DESC',
                                        'fa-sort-down': getSortedDir(column) === 'ASC',
                                    }"
                                ></icon>
                            </div>
                        </th>
                    </template>
                    <th
                        class="text-center bg-gray-100 sticky top-0 border-b border-gray-200 py-4 px-4 text-gray-600 font-bold tracking-wider uppercase text-xs"
                        v-if="actions.length > 0"
                    >
                        {{$t('Actions')}}
                    </th>
                </tr>
                </thead>
                <tbody ref="tableDataContainer">
                <template v-for="(row,key) in getRows" :key="key">
                    <tr>
                        <td class="border-dashed border-t border-gray-200" v-if="selects">
                            <div class="py-2 px-3">
                                <label
                                    class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 py-2 px-2 rounded-lg cursor-pointer">
                                    <input type="checkbox"
                                           :checked="checkIfSelected(row[rowUniqueKey])"
                                           class="cursor-pointer form-checkbox rowCheckbox focus:outline-none focus:shadow-outline"
                                           @click="selectedRow(row[rowUniqueKey])"
                                    >
                                </label>
                            </div>
                        </td>
                        <template v-for="column in getVisibleHeading">
                            <td class="border-dashed border-t border-gray-200">
                                <span class="text-gray-700 px-4 py-4 flex items-center" v-html="row[column.name]"></span>
                            </td>
                        </template>
                        <td
                            v-if="actions.length>0"
                            class="border-dashed border-t border-gray-200"
                        >
                            <div class="flex align-middle px-4 py-4 justify-center">
                                <a
                                    href="#"
                                    v-for="(action,key) in actions"
                                    :key="key"
                                    class="flex items-center justify-between px-2"
                                    @click.prevent="$emit('action:click',{action,row})"
                                    v-html="action.text"
                                >
                                </a>
                            </div>
                        </td>
                    </tr>
                </template>
                <template v-if="getRows.length === 0">
                    <tr class="border-dashed border-t border-gray-200 text-gray-700 px-4 py-4 flex items-center">
                        {{$t('No data')}}
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
        <pagination :paginator="data" v-on:changePage="changePage"></pagination>
    </div>
</template>

<script setup>
import Icon from './../Icon.vue'
import Pagination from './Pagination.vue'
import {computed, ref, onMounted} from "vue";

const props = defineProps({
    dataSource: {
        type: [String, Function, Object],
        default: () => {
            return {}
        }
    },
    onFetchDataError: {
        type: Function,
        default: () => {
        }
    },
    dataKey: {
        type: String,
        default: 'data'
    },
    rowUniqueKey: {
        type: String,
        default: 'id'
    },
    heading: {
        type: Array,
        default: () => {
            return []
        }
    },
    searchInputPlaceholder: {
        type: String,
        default: 'Search...'
    },
    selects: {
        type: Boolean,
        default: false
    },
    actions: {
        type: Array,
        default: () => {
            return []
        }
    },
    perPage: {
        type: Number,
        default: 2
    },
    fetchDataHeaders: {
        type: Object,
        default: () => {
            return {}
        }
    }
})

const selectedRows = ref([]);
const columnsHiderButtonOpen = ref(false);
const headingColumns = ref([]);
const order = ref([]);
const data = ref({});
const search = ref("");

const getVisibleHeading = computed(() => {
    return headingColumns.value.filter((e) => e.visible);
})

const getRows = computed(() => {
    console.log(data.value[props.dataKey]);
    return data.value[props.dataKey] ?? []
})

const addSort = (column) => {
    if (column.sortable) {
        if (order.value.length > 0 && order.value[0].column === column.name) {
            let dir = order.value[0].dir === 'ASC' ? 'DESC' : null;
            order.value = dir == null ? [] : [{
                column: column.name,
                dir: dir
            }];
        } else {
            order.value = [{
                column: column.name,
                dir: 'ASC'
            }];
        }
        getDataFromSource();
    }
}

const getSortedDir = (column) => {
    let sorted = order.value.find((e) => {
        if (e.column === column.name) {
            return true;
        }
    });

    return sorted !== undefined ? sorted.dir : undefined;
}
const checkIfSelected = (uniqueKey) => {
    return selectedRows.value.includes(uniqueKey);
}
const getDataFromSource = () => {
    try{
        getDataFromUrl(props.dataSource);
    } catch (e) {
        props.onFetchDataError(e);
    }
}
const getDataFromUrl = (source) => {
    fetch(source, {
        method: 'POST',
        headers: new Headers(props.fetchDataHeaders),
        body: JSON.stringify({
            search: search.value,
            order: order.value,
            perPage: props.perPage
        })
    }).then((response) => response.json()).then((responseData) => {
        data.value = responseData;
    }).catch((error) => {
        throw error;
    });
}
const changePage = (url) => {
    getDataFromUrl(url);
}
const toggleColumn = (key)  => {
    let searchColumn = headingColumns.value.find((e) => e.name === key);
    if (searchColumn !== undefined) {
        searchColumn.visible = !searchColumn.visible
    }
}
const selectAllCheckbox = ($event) => {
    selectedRows.value = [];
    if ($event.target.checked) {
        getRows.forEach((e) => {
            this.selectedRows.push(e[this.rowUniqueKey]);
        });
    }
}
const selectedRow = (uniqueKey) =>{
    if (selectedRows.value.includes(uniqueKey)) {
        selectedRows.value.slice(selectedRows.value.indexOf(uniqueKey), 1);
    } else {
        selectedRows.value.push(uniqueKey);
    }
}

onMounted(() => {
    headingColumns.value = props.heading.map(e => ({...e,showIcon: false}));
    getDataFromSource();
});

const onHeaderMouseEvent = (e, index, action) => {
    headingColumns.value[index].showIcon = action
    // column.hovered = action;
}

</script>

<style scoped>

[type="checkbox"] {
    box-sizing: border-box;
    padding: 0;
}

.form-checkbox {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    display: inline-block;
    vertical-align: middle;
    background-origin: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    flex-shrink: 0;
    color: #1f2937;
    background-color: #fff;
    border-color: #e2e8f0;
    border-width: 1px;
    border-radius: 0.25rem;
    height: 1.2em;
    width: 1.2em;
}

.form-checkbox:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
    border-color: transparent;
    background-color: #1f2937;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
