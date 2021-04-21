/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

import {createStore} from 'vuex';
import api from './api';

export default createStore({
	state: {
		title: '',
		files: [],
		image: null,
		user: {id: 0, name: null, email: null, password: null},
		loadingStatus: false,
		showMenu: localStorage.getItem('Sudu.menu.state') === 'true',
		config: window.CONFIG,
		message: null
	},
	getters: {
		images(state) {
			return state.files.filter((file) => file.type === 'image');
		},
		directories(state) {
			return state.files.filter((file, index) => index > 0 && file.type === 'dir');
		},
		current(state) {
			if (state.files.length === 0) {
				return {title: state.config.webBase};
			}
			return state.files[0];
		}
	},
	actions: {
		fetchFiles(context, path) {
			// The API request url
			const url = context.state.config.webBase + '/public/api/v1/files' + path;

			// Load first from cache
			if (window.caches !== undefined) {
				window.caches.open('Sudu').then((cache) => cache.match(url))
					.then((response) => {
						if (!response) {
							throw Error('No data');
						}
						return response.json();
					})
					.then((files) => {
						if (!Array.isArray(files)) {
							return;
						}

						context.commit('SET_FILES', files);
					})
					// Do nothing here, so we can get data from the network
					.catch(() => true);
			}

			// Starting to sync data with the server
			context.commit('SET_MESSAGE', {text: 'store.action.fetchFiles.sync', type: 'info'});

			return api.files().get(path)
				.then((files) => {
					context.commit('SET_FILES', files);
					context.commit('SET_MESSAGE');
				})
				.catch((error) => context.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		},
		fetchUser(context) {
			return api.users().get('me')
				.then((user) => {
					context.commit('SET_USER', user);
					return user;
				})
				.catch((error) => context.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		}
	},
	mutations: {
		SET_FILES(state, files) {
			state.files = files;
		},
		SET_MESSAGE(state, message) {
			state.message = message;
		},
		SET_USER(state, user) {
			if (!user) {
				user = {id: 0, name: null, email: null, password: null};
			}
			state.user = user;
		},
		SET_SHOW_MENU(state, showMenu) {
			localStorage.setItem('Sudu.menu.state', showMenu);
			state.showMenu = showMenu;
		},
		SET_LOADING_STATUS(state, loadingStatus) {
			state.loadingStatus = loadingStatus;
		},
		SET_TITLE(state, title) {
			state.title = title;
		},
		SET_IMAGE(state, image) {
			state.image = image;
		},
		SELECT_IMAGE(state, payload) {
			state.files.find((file) => file.id === payload.id).selected = payload.checked;
		}
	}
});
