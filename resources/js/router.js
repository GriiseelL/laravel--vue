import "./bootstrap";
import { createRouter, createWebHistory } from "vue-router";
import Regis from "./pages/regis.vue";
import Login from "./pages/login.vue";
import Dashboard from "./pages/dashboard.vue";
import Notfound from "./pages/notfound.vue";
import Otp from "./pages/otp.vue";
import Loginotp from "./pages/loginotp.vue";

const isAuthenticated = () => {
    return localStorage.getItem("token") !== null;
};

const routes = [
    {
        path: "/",
        name: "regis",
        component: Regis,
        meta: { guest: true },
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: { guest: true },
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { requiresAuth: true },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: Notfound,
    },
    {
        path: "/otp",
        name: "otp",
        component: Otp,
    },
    {
        path: "/loginotp",
        name: "loginotp",
        component: Loginotp,
        meta: { guest: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// const isAuthenticated = () => !!localStorage.getItem("auth_token");

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated()) {
        console.log("User belum login, redirect ke login");
        next("/loginotp");
    } else if (to.meta.guest && isAuthenticated()) {
        console.log("User sudah login, redirect ke dashboard");
        next("/dashboard");
    } else {
        next();
    }
});

export default router;
