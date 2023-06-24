<script setup>
import { onMounted } from "vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import usePosts from "@/composables/posts";

const { posts, getPosts } = usePosts()
onMounted(() => {
    getPosts()
})
</script>

<template>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-800">
        <div class="min-w-full align-middle dark:border-gray-500">
            <table class="min-w-full divide-y divide-gray-200 border dark:divide-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Título</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoría</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contenido</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Creado el</span>
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
                @pagination-change-page="getPosts"
                class="mt-4"
                :item-classes="['dark:bg-gray-800', 'dark:border-gray-900']"
                :active-classes="['bg-blue-50', 'dark:bg-gray-600']"
            />
        </div>
    </div>
</template>
