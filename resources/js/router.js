import "./bootstrap";
import { createRouter, createWebHistory } from "vue-router";
import Regis from "./pages/regis.vue";
import Login from "./pages/login.vue";
import Dashboard from "./pages/dashboard.vue";

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
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
