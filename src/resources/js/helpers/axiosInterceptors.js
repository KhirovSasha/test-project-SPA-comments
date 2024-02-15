import axios from 'axios';
import { useRouter } from 'vue-router';

export function setupAxiosInterceptors() {
    const router = useRouter();

    axios.interceptors.request.use(
        config => {
            const token = localStorage.getItem('access_token');
            if (token) {
                config.headers.authorization = `Bearer ${token}`;
            }
            return config;
        },
        error => {
            return Promise.reject(error);
        }
    );

    axios.interceptors.response.use(
        response => response,
        async error => {
            if (error.response && error.response.status === 401) {
                if (error.response.data.message === 'Token has expired') {
                    try {
                        const response = await axios.post('/api/auth/refresh', {}, {
                            headers: {
                                'authorization': `Bearer ${localStorage.getItem('access_token')}`
                            }
                        });
                        localStorage.setItem('access_token', response.data.access_token);
                        return axios(error.config);
                    } catch (refreshError) {
                        router.push('/auth');
                        return Promise.reject(refreshError);
                    }
                } else {
                    router.push('/auth');
                    return Promise.reject(error);
                }
            }
            return Promise.reject(error);
        }
    );

}
