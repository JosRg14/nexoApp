import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Send CSRF token from meta (Laravel) when available
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Include credentials (cookies) for cross-site requests if server allows it
window.axios.defaults.withCredentials = true;
