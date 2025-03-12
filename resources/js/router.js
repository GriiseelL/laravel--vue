import "./bootstrap";
import { createRouter, createWebHistory } from "vue-router";
import Regis from "./pages/regis.vue";
import Login from "./pages/login.vue";
import Dashboard from "./pages/dashboard.vue";

const isAuthenticated = () => {
    return localStorage.getItem("token") !== null;
};


const routes = [
    {
        path: "/",
        name: "regis",
        component: Regis,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: {requiresAuth: true}
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});


router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated()) {
        console.log("User belum login, redirect ke login");
        next("/login");
    } else {
        next();
    }
});

export default router;