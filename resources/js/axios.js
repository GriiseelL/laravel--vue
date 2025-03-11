import axios from "axios";
import router from "./router";

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

// axiosClient.interceptors.request.use(config =>{
//     config.headers.Authorization = Bearer ${localStorage.getItem('token')}
// })

axiosClient.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response && error.response.status === 401) {
            router.push({ name: "login" });
        }

        throw error;
    }
);

export default axiosClient;
