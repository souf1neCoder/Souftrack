import { createWebHistory, createRouter } from 'vue-router';
import home from '../views/home.vue';
import login from '../views/login.vue';
import register from '../views/register.vue';
import dashboard from '../views/dashboard.vue';
import categories from '../views/categories.vue';
import statistics from '../views/statistics.vue';
import search from '../views/search.vue';
import notFound from '../views/notFound.vue';
import store from '../store'

const routes = [
    {
        path : '/',
        name : 'Home',
        component : home,
    },
    {
        path : '/login',
        name : 'Login',
        component : login,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/register',
        name : 'Register',
        component : register,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/dashboard',
        name : 'Dashboard',
        component : dashboard,
        meta:{
            requiresAuth:true
        }
    },
    
    {
        path : '/categories',
        name : 'Categories',
        component : categories,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/statistics',
        name : 'Statistics',
        component : statistics,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/search',
        name : 'Search',
        component : search,
        meta:{
            requiresAuth:true
        }
    },
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: notFound },

    

];

const router = createRouter({
    history: createWebHistory(),
    routes
});


router.beforeEach((to,from) =>{
      document.title = `Souftrack - ${to.name}`;

    if(to.meta.requiresAuth && store.getters.getToken == 0){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth == false && store.getters.getToken !== 0 ){
        return { name : 'Home'}
    }
})

export default router;
