<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<dp-message></dp-message>
	<dp-sidebar></dp-sidebar>
	<dp-loader></dp-loader>
	<dp-header></dp-header>
	<main>
		<router-view/>
	</main>
</template>

<script>
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Loader from './components/Loader';
import Message from './components/Message';
import api from './plugins/api';

export default {
	name: 'App',
	computed: {
		loading()
		{
			return this.$store.state.loadingStatus;
		}
	},
	created()
	{
		if (!parseInt(localStorage.getItem('Sudu.user'))) {
			return;
		}

		api.users().get('me')
			.then((user) => this.$store.commit('SET_USER', user))
			.catch(() => localStorage.removeItem('Sudu.user'));
	},
	watch: {
		async $route(to, from)
		{
			// Hide menu when route has changed, but not on initial load
			if (from.matched.length !== 0) {
				this.$store.commit('SET_SHOW_MENU', false);
			}

			if (to.fullPath.indexOf('/media') !== 0) {
				return;
			}

			// If we land here by direct link
			if (from.matched.length === 0
				// If it is not an image
				|| to.fullPath.indexOf('.') === -1 || !['jpg', 'png', 'jpeg', 'webp'].includes(to.fullPath.split('.').pop().toLowerCase())) {
				await this.$store.dispatch('fetchFiles', to.fullPath.replace('/media', ''));
			}

			// Select the image from the path if a directory then selected image will be reset
			this.$store.commit('SELECT_IMAGE', this.$store.state.files.find((file) => file.type === 'image' && encodeURI(file.path) == to.fullPath.replace('/media', '')));
		},
		'$store.state.user'(to)
		{
			localStorage.setItem('Sudu.user', to.id);
		}
	},
	components: {dpSidebar: Sidebar, dpLoader: Loader, dpMessage: Message, dpHeader: Header}
};
</script>

<style>
.dp-app {
	position: relative;
	margin: 0 auto;
	padding: 1rem;
	background-color: white;
	font-family: arial, courier, helvetica;
}
</style>
