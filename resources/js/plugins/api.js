/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

const axios = require('axios');
axios.defaults.withCredentials = true;

export default {
	apiUrl: window.CONFIG.webBase + '/public/api/v1',
	users() {
		return {
			get: (id) => {
				return axios.get(this.apiUrl + '/users/' + (id || 'me'))
					.then((res) => res.data)
					.catch(this.handleError);
			},
			list: () => {
				return axios.get(this.apiUrl + '/users')
					.then((res) => res.data)
					.catch(this.handleError);
			},
			add: (user) => {
				return axios.post(this.apiUrl + '/users', user)
					.then((res) => res.data)
					.catch(this.handleError);
			},
			update: (user) => {
				return axios.put(this.apiUrl + '/users/' + user.id, user)
					.then((res) => res.data)
					.catch(this.handleError);
			},
			delete: (id) => {
				return axios.delete(this.apiUrl + '/users/' + id)
					.then((res) => res.data)
					.catch(this.handleError);
			}
		};
	},
	user() {
		return {
			login: (email, password) => {
				return axios.get(this.apiUrl + '/sanctum/csrf-cookie')
					.then((res) => axios.post(window.CONFIG.webBase + '/public/api/v1/user/login', {email: email, password: password}))
					.then((res) => res.data)
					.catch(this.handleError);
			},
			logout: () => {
				return axios.get(this.apiUrl + '/user/logout')
					.catch(this.handleError);
			}
		};
	},
	files() {
		return {
			get: (path) => {
				return axios.get(this.apiUrl + '/files' + path)
					.then((res) => res.data ? res.data : [])
					.catch(this.handleError);
			},
			createFolder: (name, parentPath) => {
				return axios.post(this.apiUrl + '/files/folder' + parentPath + '/' + name)
					.then((res) => res.data)
					.catch(this.handleError);
			},
			upload: (image, parentPath, progress) => {
				const data = new FormData();
				data.append('file', image);

				const config = {
					onUploadProgress: (event) => {
						if (!progress) {
							return;
						}
						progress(Math.round((event.loaded * 100) / event.total));
					}
				};

				return axios.post(this.apiUrl + '/files/images' + parentPath + '/' + image.name, data, config)
					.then((res) => res.data)
					.catch(this.handleError);
			},
			delete: (images, parentPath) => {
				return axios.delete(this.apiUrl + '/files/images/' + parentPath, {data: {images: images}})
					.then((res) => res.data)
					.catch(this.handleError);
			},
			download: (images) => {
				return axios.post(this.apiUrl + '/files/archive', {images: images})
					.then((res) => res.data)
					.catch(this.handleError);
			}
		};
	},
	handleError: (err) => {
		let message = err.message ? err.message : err;

		// Use the statusText property from the default response
		if (err.response && err.response.statusText) {
			message = err.response.statusText;
		}

		// Use the statusText property from the default response
		if (err.response && err.response.data.message) {
			message = err.response.data.message;
		}

		throw new Error(message);
	}
};
