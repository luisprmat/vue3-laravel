<script setup>
import { onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';
import useCategories from '@/composables/categories';
import usePosts from '@/composables/posts';

const { categories, getCategories } = useCategories()
const { post, getPost, storePost, validationErrors, isLoading } = usePosts()
const route = useRoute()

onMounted(() => {
    getPost(route.params.id)
    getCategories()
})
</script>

<template>
    <form @submit.prevent="updatePost(post)">
        <!-- Title -->
        <div>
            <label for="post-title" class="block text-sm font-medium text-gray-700">
                Título
            </label>
            <input v-model="post.title" id="post-title" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.title">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="mt-4">
            <label for="post-content" class="block text-sm font-medium text-gray-700">
                Contenido
            </label>
            <textarea v-model="post.content" id="post-content" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.content">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Category -->
        <div class="mt-4">
            <label for="post-category" class="block text-sm font-medium text-gray-700">
                Categoría
            </label>
            <select v-model="post.category_id" id="post-category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="" selected>-- Elegir categoría --</option>
                <option v-for="category in categories" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.category_id">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Thumbnail -->
        <div class="my-4">
            <label for="thumbnail" class="block font-medium text-sm text-gray-700">
                Miniatura
            </label>
            <input @change="post.thumbnail = $event.target.files[0]" type="file" id="thumbnail" />
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.thumbnail">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <button :disabled="isLoading" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm uppercase text-white disabled:opacity-75 disabled:cursor-not-allowed">
            <span v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
            <span v-if="isLoading">Procesando...</span>
            <span v-else>Guardar</span>
        </button>
    </form>
</template>
