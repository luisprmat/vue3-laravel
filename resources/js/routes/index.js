import { createRouter, createWebHistory } from 'vue-router';

import PostsIndex from '@/components/Posts/Index.vue'
import PostsCreate from '@/components/Posts/Create.vue'

const routes = [
    {
        path: '/',
        name: 'posts.index',
        component: PostsIndex,
        meta: { title: 'Publicaciones' }
    },
    {
        path: '/posts/create',
        name: 'posts.create',
        component: PostsCreate,
        meta: { title: 'Agregar nueva publicación' }
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
