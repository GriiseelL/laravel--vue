<script setup>
import { ref } from "vue";
import axiosClient from "../axios"; // Pastikan import axios benar
import router from "../router";

const email = ref("");
// const name = ref("");
const otp = ref("");
const message = ref("");
const error = ref("");
const isSent = ref(false);

const sendOtp = async () => {
    console.log("Tombol diklik, proses kirim OTP...");

    message.value = "berhasil";
    error.value = "";

    if (!email.value) {
        error.value = "Email tidak boleh kosong";
        return;
    }

    try {
        console.log("Mengirim email:", email.value);
        const response = await axiosClient.post("/send-otp", {
            email: email.value,
        });
        // message.value = response.data.message;
        console.log("Berhasil:", response.data);
        isSent.value = true;
    } catch (err) {
        if (err.response) {
            if (err.response.status === 404) {
                alert("email tidak terdaftar");
            }
            // error.value = err.response.data.message || "Terjadi kesalahan";
            else if (err.response.status === 403) {
                console.log("Masuk ke blok 403: Email belum terverifikasi");
                error.value = "Email belum terverifikasi";

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
            }
        } else {
            error.value = "Tidak bisa terhubung ke server";
        }
    }
};

const verifyOtp = async () => {
    if (!otp.value) {
        error.value = "OTP tidak boleh kosong";
        return;
    }
    try {
        const response = await axiosClient.post("/verif-login", {
            otp: otp.value,
            email: email.value,
        });
        if (response.status === 200) {
            localStorage.setItem("name", response.data.user.name);
            localStorage.setItem("token", response.data.token);
            router.push({ path: "/dashboard" });
        }
        message.value = response.data.message;
        error.value = "";
    } catch (err) {
        error.value =
            err.response?.data?.message ||
            "Terjadi kesalahan saat verifikasi OTP";
            alert("Invalid kode")
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
                <form @submit.prevent="sendOtp">
                    <div class="relative mt-6">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            v-model="email"
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
                    <div class="my-6">
                        <button
                            v-if="!isSent"
                            type="submit"
                            class="w-full rounded-md bg-black px-3 py-4 text-white focus:bg-gray-600 focus:outline-none"
                        >
                            Send Otp
                        </button>
                    </div>
                </form>
                <form @submit.prevent="verifyOtp">
                    <div class="relative mt-6">
                        <input
                            type="text"
                            name="password"
                            id="password"
                            v-model="otp"
                            placeholder="OTP"
                            class="peer peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none"
                        />
                        <label
                            for="password"
                            class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800"
                            >OTP</label
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
                        dont have account?
                        <router-link to="/">Sign up</router-link>
                    </p>
                    <p class="text-center text-sm text-gray-500">
                        sign in with password?
                        <router-link to="/login">here</router-link>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>
