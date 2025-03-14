<script setup>
import { ref } from "vue";
import axiosClient from "../axios";
import router from "../router";

// Ambil email dari localStorage (disimpan saat registrasi)
const otp = ref("");
const errors = ref("");
const email = localStorage.getItem("email");

const verifyOtp = async () => {
    if (!email) {
        alert("Email tidak ditemukan. Silakan registrasi ulang.");
        router.push({ path: "/register" });
        return;
    }

    try {
        // Kirim OTP dan email untuk verifikasi
        const response = await axiosClient.post("/verify-otp", {
            email: email,
            otp: otp.value,
        });

        // Cek apakah verifikasi berhasil
        if (response.status === 200) {
            alert("OTP berhasil diverifikasi!");

            // Bersihkan email dari localStorage
            localStorage.removeItem("email");

            // Redirect ke halaman login
            router.push({ path: "/login" });
        }
    } catch (error) {
        console.log(error.response?.data);
        errors.value =
            error.response?.data?.error || "OTP salah atau terjadi kesalahan.";

        // Kalo error-nya objek, tampilkan JSON string
        if (typeof errors.value === "object") {
            alert(JSON.stringify(errors.value));
        } else {
            alert(errors.value);
        }
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
                <h1 class="text-3xl font-semibold text-gray-900">
                    Verifikasi OTP
                </h1>
                <p class="mt-2 text-gray-500">
                    Sign up below to access your account
                </p>
            </div>
            <div class="mt-5">
                <form @submit.prevent="verifyOtp">
                    <div class="relative mt-6">
                        <input
                            type="password"
                            name="password"
                            v-model="otp"
                            id="password"
                            placeholder="Password"
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
                            Verifikasi OTP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
