import axios from 'axios';

export const ApiClient = axios.create({
    baseURL: `${process.env.REACT_APP_API_URL}`,
    timeout: 1000,
    headers: {
        'Accept': 'application/json'
    },
    withCredentials: true
});

