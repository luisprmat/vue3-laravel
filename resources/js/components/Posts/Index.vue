<script setup>
import { onMounted, ref, watch } from "vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import usePosts from "@/composables/posts";
import useCategories from "@/composables/categories";

const selectedCategory = ref('')
const orderColumn = ref('created_at')
const orderDirection = ref('desc')
const { posts, getPosts } = usePosts()
const { categories, getCategories } = useCategories()

const updateOrdering = (column) => {
    orderColumn.value = column
    orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc'
    getPosts(1, selectedCategory.value, orderColumn.value, orderDirection.value)
}

onMounted(() => {
    getPosts(),
    getCategories()
})

watch(selectedCategory, (current, previous) => {
    getPosts(1, current)
})
</script>

<template>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-800">
        <div class="min-w-full align-middle dark:border-gray-500">
            <div class="mb-4">
                <select v-model="selectedCategory" class="block mt-1 w-full sm:w-1/4 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700">
                    <option value="" selected>-- Filtrar por categoría --</option>
                    <option v-for="category in categories" :value="category.id" :key="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <table class="min-w-full divide-y divide-gray-200 border dark:divide-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <div class="flex flex-row items-center justify-between cursor-pointer" @click="updateOrdering('id')">
                                <div class="leading-4 uppercase tracking-wider" :class="{ 'font-bold text-blue-600': orderColumn === 'id', 'font-medium text-gray-500': orderColumn !== 'id' }">
                                    ID
                                </div>
                                <div class="select-none">
                                <span :class="{
                                        'text-blue-600': orderDirection === 'asc' && orderColumn === 'id',
                                        'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'id',
                                    }">&uarr;</span>
                                    <span :class="{
                                        'text-blue-600': orderDirection === 'desc' && orderColumn === 'id',
                                        'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'id',
                                    }">&darr;</span>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <div class="flex flex-row items-center justify-between cursor-pointer" @click="updateOrdering('title')">
                                <div class="leading-4 uppercase tracking-wider" :class="{ 'font-bold text-blue-600': orderColumn === 'title', 'font-medium text-gray-500': orderColumn !== 'title' }">
                                    Título
                                </div>
                                <div class="select-none">
                                    <span :class="{
                                        'text-blue-600': orderDirection === 'asc' && orderColumn === 'title',
                                        'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'title',
                                    }">&uarr;</span>
                                    <span :class="{
                                        'text-blue-600': orderDirection === 'desc' && orderColumn === 'title',
                                        'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'title',
                                    }">&darr;</span>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoría</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contenido</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <div class="flex flex-row items-center justify-between cursor-pointer" @click="updateOrdering('created_at')">
                                <div class="leading-4 uppercase tracking-wider" :class="{ 'font-bold text-blue-600': orderColumn === 'created_at', 'font-medium text-gray-500': orderColumn !== 'created_at' }">
                                    Creado el
                                </div>
                                <div class="select-none">
                                <span :class="{
                                    'text-blue-600': orderDirection === 'asc' && orderColumn === 'created_at',
                                    'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'created_at',
                                }">&uarr;</span>
                                    <span :class="{
                                    'text-blue-600': orderDirection === 'desc' && orderColumn === 'created_at',
                                    'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'created_at',
                                }">&darr;</span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300 divide-solid dark:bg-gray-900 dark:divide-gray-600">
                    <tr v-for="post in posts.data">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.title }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.category }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.content }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>

             <TailwindPagination
                :data="posts"
                @pagination-change-page="page => getPosts(page, selectedCategory)"
                class="mt-4"
                :item-classes="['dark:bg-gray-800', 'dark:border-gray-900']"
                :active-classes="['bg-blue-50', 'dark:bg-gray-600']"
            />
        </div>
    </div>
</template>
