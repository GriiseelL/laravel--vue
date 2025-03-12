<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";

// Data untuk form
const data = ref({
    name: "",
    email: "",
    password: "",
});

// State untuk menampung error
const errors = ref({});

const storePost = async () => {
    try {
        let response = await axiosClient.post(
            "http://127.0.0.1:8000/api/register",
            {
                name: data.value.name,
                email: data.value.email,
                password: data.value.password,
            }
        );

        // Redirect ke halaman login setelah sukses
        router.push({ path: "/login" });
    } catch (error) {
        // Menyimpan error response jika terjadi kesalahan
        errors.value = error.response?.data || {
            message: "Terjadi kesalahan.",
        };
        alert('email sudah terdaftar')
    }
};
</script>

<template>
    <div
        class="relative mx-auto w-full max-w-md bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10"
        style="margin-top: 90px"
    >
        <div class="w-full">
            <div class="text-center">
                <h1 class="text-3xl font-semibold text-gray-900">Sign in</h1>
                <p class="mt-2 text-gray-500">
                    Sign in below to access your account
                </p>
            </div>
            <div class="mt-5">
                <form @submit.prevent="storePost">
                    <div class="relative mt-6">
                        <input
                            type="name"
                            name="name"
                            id="name"
                            placeholder="Nama"
                            class="peer peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none"
                            required
                            v-model="data.name"
                        />
                        <label
                            for="name    "
                            class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800"
                            >Name</label
                        >
                    </div>
                    <div class="relative mt-6">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Email Address"
                            class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none"
                            autocomplete="NA"
                            required
                            v-model="data.email"
                        />
                        <label
                            for="email"
                            class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800"
                            >Email Address</label
                        >
                    </div>
                    <div class="relative mt-6">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Password"
                            class="peer peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none"
                            required
                            v-model="data.password"
                        />
                        <label
                            for="password"
                            class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800"
                            >Password</label
                        >
                    </div>
                    <div class="my-6">
                        <button
                            type="submit"
                            class="w-full rounded-md bg-black px-3 py-4 text-white focus:bg-gray-600 focus:outline-none"
                        >
                            Sign in
                        </button>
                    </div>
                    <p class="text-center text-sm text-gray-500">
                        Don&#x27;t have an account yet?
                        <router-link to="/login">Sign up</router-link>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
