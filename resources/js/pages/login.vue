<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";

const data = ref({
    name: "",
    email: "",
    password: "",
});

const errors = ref({});

const loading = ref(false);
// const email = localStorage.getItem("email");

const login = async () => {
    errors.value = {}; // Reset error
    loading.value = true;

    //  if (!email) {
    //     alert("Email tidak terdaftar.");
    //     router.push({ path: "/" });
    //     return;
    // }

    try {
        const response = await axiosClient.post("/login", {
            email: email.value,
            password: password.value,
        });

        // Simpan token ke localStorage
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("name", response.data.user.name);

        localStorage.getItem("email", response.data.email);
        if (!email) {
            alert("Email tidak terdafaftar.");
            router.push({ path: "/" });
            return;
        }

        // Redirect ke dashboard
        router.push({ path: "/dashboard" });
    } catch (error) {
        if (error.response) {
            if (error.response.status === 401) {
                errors.value.general = "Email atau password salah";
                alert(errors.value.general);
            } else if (error.response.status === 403) {
                errors.value = "Email belum terverifikasi";

                // Tampilkan konfirmasi
                if (
                    confirm(
                        "Email belum terverifikasi. Kirim ulang OTP sekarang?"
                    )
                ) {
                    // Kirim ulang OTP
                    axiosClient
                        .post("/resend-otp", { email: email.value })
                        .then(() => {
                            // Redirect ke halaman OTP setelah sukses kirim ulang
                            window.location.href = "/otp";
                        })
                        .catch((otpError) => {
                            alert("Gagal mengirim OTP. Silakan coba lagi.");
                        });
                }
            } else {
                errors.value.general = "Terjadi kesalahan. Coba lagi.";
                alert(errors.value.general);
            }
        } else {
            errors.value.general = "Tidak dapat menghubungi server.";
            alert(errors.value.general);
        }
    } finally {
        loading.value = false; // Matikan loading
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
                    Sign up below to access your account
                </p>
            </div>
            <div class="mt-5">
                <form @submit.prevent="login">
                    <div class="relative mt-6">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Email Address"
                            class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none"
                            autocomplete="NA"
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
                        sign in with otp?
                        <router-link to="/loginotp">here</router-link>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>
