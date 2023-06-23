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
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contenido</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left dark:bg-gray-800">
                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Creado el</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300 divide-solid dark:bg-gray-900 dark:divide-gray-600">
                    <tr v-for="post in posts">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-gray-200">
                            {{ post.title }}
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
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            posts: []
        }
    },
    mounted() {
        this.fetchPosts()
    },
    methods: {
        fetchPosts() {
            axios.get('/api/posts')
                .then(response => this.posts = response.data)
                .catch(error => console.log(error))
        }
    }
}
</script>
