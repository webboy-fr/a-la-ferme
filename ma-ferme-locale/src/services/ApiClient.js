import axios from 'axios';

export const ApiClient = axios.create({
    baseURL: `${process.env.REACT_APP_API_URL}`,
    timeout: 2000,
    headers: {
        'Accept': 'application/json'
    },
    withCredentials: true
});

