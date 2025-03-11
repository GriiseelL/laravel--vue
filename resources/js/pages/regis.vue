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
    let response = await axiosClient.post("http://127.0.0.1:8000/api/register", {
      name: data.value.name,
      email: data.value.email,
      password: data.value.password,
    });

    // Redirect ke halaman login setelah sukses
    router.push({ path: "/login" });
  } catch (error) {
    // Menyimpan error response jika terjadi kesalahan
    errors.value = error.response?.data || { message: "Terjadi kesalahan." };
  }
};
</script>


<template>
    <!-- <GuestLayout>
        <h2
            class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900"
        >
            Sign in to your account
        </h2>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="storePost" class="space-y-6">
                <div>
                    <label
                        for="email"
                        class="block text-sm/6 font-medium text-gray-900"
                        >Email address</label
                    >
                    <div class="mt-2">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="email"
                            required=""
                            v-model="data.email"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>

                <div>
                    <label
                        for="name"
                        class="block text-sm/6 font-medium text-gray-900"
                        >Name</label
                    >
                    <div class="mt-2">
                        <input
                            type="text"
                            name="name"
                            id="name"
                            required=""
                            v-model="data.name"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Password</label
                        >
                        <div class="text-sm">
                            <a
                                href="#"
                                class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >Forgot password?</a
                            >
                        </div>
                    </div>
                    <div class="mt-2">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="current-password"
                            required=""
                            v-model="data.password"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Have account?
                {{ " " }}
                <a
                    href="/register"
                    class="font-semibold text-indigo-600 hover:text-indigo-500"
                    >Create here</a
                >
            </p>
        </div>
    </GuestLayout> -->
    <div
    class="relative mx-auto w-full max-w-md bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10" style="margin-top: 90px;">
    <div class="w-full">
        <div class="text-center">
            <h1 class="text-3xl font-semibold text-gray-900">Sign in</h1>
            <p class="mt-2 text-gray-500">Sign in below to access your account</p>
        </div>
        <div class="mt-5">
            <form  @submit.prevent="storePost">
                 <div class="relative mt-6">
                    <input type="name" name="name" id="name" placeholder="Name" class="peer peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" required v-model="data.name"
/>
                    <label for="password" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Password</label>
                </div>
                <div class="relative mt-6">
                    <input type="email" name="email" id="email" placeholder="Email Address" class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" autocomplete="NA" required v-model="data.email"
/>
                    <label for="email" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Email Address</label>
                </div>
                <div class="relative mt-6">
                    <input type="password" name="password" id="password" placeholder="Password" class="peer peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" required v-model="data.password"
/>
                    <label for="password" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Password</label>
                </div>
                <div class="my-6">
                    <button type="submit" class="w-full rounded-md bg-black px-3 py-4 text-white focus:bg-gray-600 focus:outline-none">Sign in</button>
                </div>
                <p class="text-center text-sm text-gray-500">Don&#x27;t have an account yet?
                    <a href="#!"
                        class="font-semibold text-gray-600 hover:underline focus:text-gray-800 focus:outline-none">Sign
                        up
                    </a>.
                </p>
            </form>
        </div>
    </div>
</div>
</template>

<!-- <script>
import { ref } from "vue";
import GuestLayout from "../components/guestLayout.vue";
import router from "../router";
import axiosClient from "../axios";

export default {
    setup() {
        const email = ref("");
        const name = ref("");
        const hidePassword = ref(true);
        const password = ref("");
        const password_confirmation = ref("");
        const errors = ref({});
        const loading = ref(false);

        const passwordFieldIcon = computed(() =>
            hidePassword.value ? "fa-eye" : "fa-eye-slash"
        );
        const passwordFieldType = computed(() =>
            hidePassword.value ? "password" : "text"
        );

        const login = async () => {
            errors.value = {}; // Reset error
            loading.value = true;

            try {
                const response = await axiosClient.post("/login", {
                    email: email.value,
                    password: password.value,
                });

                // Simpan token ke localStorage
                localStorage.setItem("token", response.data.token);
                localStorage.setItem("name", response.data.user.name);

                // Redirect ke dashboard
                router.push({ path: "/dashboard" });
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 401) {
                        errors.value.general = "Email atau password salah";
                    } else if (error.response.data.errors) {
                        errors.value = error.response.data.errors;
                    } else {
                        errors.value.general = "Terjadi kesalahan. Coba lagi.";
                    }
                } else {
                    errors.value.general = "Tidak dapat menghubungi server.";
                }
            } finally {
                loading.value = false; // Matikan loading
            }
        };

        return {
            email,
            name,
            hidePassword,
            password,
            password_confirmation,
            errors,
            loading,
            passwordFieldIcon,
            passwordFieldType,
            login,
        };
    },
};
</script> -->

<style scoped></style>
