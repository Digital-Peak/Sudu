<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<aside class="dp-sidebar">
		<button @click.prevent="toggleMenu" aria-label="Menu" class="dp-sidebar__handle">
			<menu-icon :class="!showMenu ? '' : 'dp-sidebar__icon_closed'" class="dp-sidebar__icon"></menu-icon>
			<x-icon :class="showMenu ? '' : 'dp-sidebar__icon_closed'" class="dp-sidebar__icon"></x-icon>
		</button>
		<nav :class="[showMenu ? 'dp-sidebar__menu_open' : '']" class="dp-sidebar__menu">
			<div class="dp-sidebar__item dp-sidebar__item-user">{{ $t('component.sidebar.text.title', user) }}</div>
			<router-link to="/media" :class="{'dp-sidebar__item_active': isMenuActive('/media', false)}" class="dp-sidebar__item">
				<photograph-icon class="dp-sidebar__item-icon"/>
				{{ $t('component.sidebar.menu.images') }}
			</router-link>
			<router-link to="/users" v-if="user.id" :class="{'dp-sidebar__item_active': isMenuActive('/users', false)}" class="dp-sidebar__item">
				<users-icon class="dp-sidebar__item-icon"/>
				{{ $t('component.sidebar.menu.users') }}
			</router-link>
			<router-link to="/user" v-if="user.id" :class="{'dp-sidebar__item_active': isMenuActive('/user', true)}" class="dp-sidebar__item">
				<user-add-icon class="dp-sidebar__item-icon"/>
				{{ $t('component.sidebar.menu.usercreate') }}
			</router-link>
			<router-link to="/user/me" v-if="user.id" :class="{'dp-sidebar__item_active': isMenuActive('/user/me', true)}" class="dp-sidebar__item">
				<user-circle-icon class="dp-sidebar__item-icon"/>
				{{ $t('component.sidebar.menu.user') }}
			</router-link>
			<button @click="logout" v-if="user.id" class="dp-sidebar__item dp-sidebar__item-button">
				<logout-icon class="dp-sidebar__item-icon"/>
				<span>{{ $t('component.sidebar.text.logout') }}</span>
			</button>
			<button @click="showLogin = true" v-if="!user.id" class="dp-sidebar__item dp-sidebar__item-button">
				<login-icon class="dp-sidebar__item-icon"/>
				<span>{{ $t('component.sidebar.text.login') }}</span>
			</button>
		</nav>
	</aside>
	<dp-login-dialog v-if="showLogin" @close="showLogin = false"></dp-login-dialog>
</template>

<script>
import {defineAsyncComponent} from 'vue';
import {LoginIcon, LogoutIcon, MenuIcon, PhotographIcon, UserAddIcon, UserCircleIcon, UsersIcon, XIcon} from '@heroicons/vue/solid';
import api from '../plugins/api';

const LoginDialog = defineAsyncComponent(() => import( './LoginDialog'));

export default {
	data()
	{
		return {showLogin: false}
	},
	computed: {
		user()
		{
			return this.$store.state.user;
		},
		showMenu()
		{
			return this.$store.state.showMenu;
		}
	},
	methods: {
		logout()
		{
			api.user().logout()
				.then(() => this.$store.commit('SET_USER'))
				.then(() => this.$store.commit('SET_MESSAGE'))
				.then(() => this.$router.push('/media/'))
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		},
		toggleMenu()
		{
			this.$store.commit('SET_SHOW_MENU', !this.showMenu);
		},
		isMenuActive(input, exact)
		{
			if (exact) {
				return (Array.isArray(input) ? input : [input]).some((path) => this.$route.path === path);
			}

			return (Array.isArray(input) ? input : [input]).some((path) => this.$route.path.indexOf(path) === 0);
		}
	},
	components: {dpLoginDialog: LoginDialog, LoginIcon, LogoutIcon, MenuIcon, PhotographIcon, UserAddIcon, UserCircleIcon, UsersIcon, XIcon}
};
</script>

<style lang="scss" scoped>
.dp-sidebar {
	&__handle {
		width: var(--dp-icon-size);
		height: var(--dp-icon-size);
		margin-right: 1rem;
		text-align: center;
		color: #000000;
		background-color: #ffffff;
		border: 0;
		cursor: pointer;
		pointer-events: auto;
		transition-property: background-color, border-color, color, fill, stroke;
		transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		transition-duration: 300ms;

		&:focus {
			outline: none;
		}
	}

	&__icon {
		width: var(--dp-icon-size);
		height: var(--dp-icon-size);

		&_closed {
			display: none;
		}
	}

	&__item {
		display: flex;
		align-items: center;
		padding: 1rem;
		text-decoration: none;

		&-button {
			width: 100%;
			background-color: unset;
			border: 0;
			border-top: var(--dp-border);
			font-size: inherit;
			cursor: pointer;

			&:focus {
				outline: none;
			}
		}

		&-icon {
			width: calc(var(--dp-icon-size) * 0.5);
			height: calc(var(--dp-icon-size) * 0.5);
			margin-right: 1rem;
		}

		&-user {
			border-bottom: var(--dp-border);
		}

		&_active {
			background-color: #E2E4EAFF;
		}
	}


	@media only screen and (max-width: 639px) {
		&__menu {
			max-height: 0rem;
			overflow: hidden;
			color: #000000;
			background-color: #ffffff;
			border-bottom: var(--dp-border);
			pointer-events: auto;
			transition-property: all;
			transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
			transition-duration: 700ms;

			&_open {
				max-height: 16rem;
			}
		}
	}
	@media only screen and (min-width: 640px) {
		position: absolute;
		display: flex;
		top: 0;
		right: 0;
		bottom: 0;
		min-height: 100vh;
		z-index: 1;
		pointer-events: none;

		&__menu {
			max-width: 0rem;
			overflow: hidden;
			color: #000000;
			background-color: #ffffff;
			border-left: var(--dp-border);
			pointer-events: auto;
			transition-property: all;
			transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
			transition-duration: 700ms;

			&_open {
				max-width: 16rem;
			}
		}
	}
}
</style>