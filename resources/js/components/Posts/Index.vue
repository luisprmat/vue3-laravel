<script setup>
import { onMounted, ref, watch } from "vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import usePosts from "@/composables/posts";
import useCategories from "@/composables/categories";
import { useAbility } from "@casl/vue";

const search_category = ref('')
const search_id = ref('')
const search_title = ref('')
const search_content = ref('')
const search_global = ref('')
const orderColumn = ref('created_at')
const orderDirection = ref('desc')
const { posts, getPosts, deletePost } = usePosts()
const { categories, getCategories } = useCategories()
const { can } = useAbility()

const updateOrdering = (column) => {
    orderColumn.value = column
    orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc'
    getPosts(
        1,
        search_category.value,
        search_id.value,
        search_title.value,
        search_content.value,
        orderColumn.value,
        orderDirection.value
    )
}

onMounted(() => {
    getPosts(),
    getCategories()
})

watch(search_category, (current, previous) => {
    getPosts(
        1,
        current,
        search_id.value,
        search_title.value,
        search_content.value,
        search_global.value
    )
})
watch(search_id, (current, previous) => {
    getPosts(
        1,
        search_category.value,
        current,
        search_title.value,
        search_content.value,
        search_global.value
    )
})
watch(search_title, (current, previous) => {
    getPosts(
        1,
        search_category.value,
        search_id.value,
        current,
        search_content.value,
        search_global.value
    )
})
watch(search_content, (current, previous) => {
    getPosts(
        1,
        search_category.value,
        search_id.value,
        search_title.value,
        current,
        search_global.value
    )
})
watch(search_global, (current, previous) => {
    getPosts(
        1,
        search_category.value,
        search_id.value,
        search_title.value,
        search_content.value,
        current
    )
})
</script>

<template>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-800">
        <div class="min-w-full align-middle dark:border-gray-500">
            <div class="mb-4">
                <div class="mb-4 grid lg:grid-cols-4">
                    <input v-model="search_global" type="text" placeholder="Buscar..." class="inline-block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200 border dark:divide-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <input v-model="search_id" type="text" class="inline-block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Filtrar por ID">
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <input v-model="search_title" type="text" class="inline-block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Filtrar por Título">
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <select v-model="search_category" class="inline-block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" selected>-- todas las categorías --</option>
                                <option v-for="category in categories" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <input v-model="search_content" type="text" class="inline-block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Filtrar por Contenido">
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left"></th>
                        <th class="px-6 py-3 bg-gray-50 text-left"></th>
                    </tr>
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
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Acciones</span>
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
                            {{ post.excerpt }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            <router-link v-if="can('posts.update')" :to="{ name: 'posts.edit', params: { id: post.id } }">Editar</router-link>
                            <a href="#" v-if="can('posts.delete')" @click.prevent="deletePost(post.id)" class="ml-2 text-red-500">Borrar</a>
                        </td>
                    </tr>
                </tbody>
            </table>

             <TailwindPagination
                :data="posts"
                @pagination-change-page="page => getPosts(page, search_category, search_id, search_title, search_content, search_global, orderColumn, orderDirection)"
                class="mt-4"
                :item-classes="['dark:bg-gray-800', 'dark:border-gray-900']"
                :active-classes="['bg-blue-50', 'dark:bg-gray-600']"
            />
        </div>
    </div>
</template>
