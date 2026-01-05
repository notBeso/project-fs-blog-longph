
import { createRouter, createWebHistory } from 'vue-router';
import DefaultLayout from '../layouts/DefaultLayout.vue';
import ListPage from '../app/pages/index.vue';
import SearchPage from '../pages/search.vue';
import NewPage from '../pages/new.vue';
import EditPage from '../pages/edit.vue';
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
    path: '/',
    component: DefaultLayout,
    children: [
        {
        path: '',
        name: 'List',
        component: ListPage,
        },
        {
        path: '/search',
        name: 'Search',
        component: SearchPage,
        },
        {
        path: '/new',
        name: 'New',
        component: NewPage,
        },
        {
        path: '/edit/:id',
        name: 'EP',
        component: EditPage,
        props: true
        },
    ],
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;


