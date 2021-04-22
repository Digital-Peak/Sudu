<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div class="dp-users">
		<div v-for="user in users" :key="user.id" class="dp-users__user dp-user">
			<user-remove-icon @click="deleteUser(user)" v-if="user.id !== loggedInUser.id" class="dp-user__icon"/>
			<router-link :to="'/user/' + user.id" class="dp-user__edit-link dp-link-special">
				<pencil-icon class="dp-user__icon"></pencil-icon>
			</router-link>
			<span class="dp-user__name">{{ user.name }}</span>
			<span class="dp-user__email">{{ user.email }}</span>
		</div>
	</div>
</template>

<script>
import {UserRemoveIcon, PencilIcon} from '@heroicons/vue/solid';
import api from '../plugins/api';

export default {
	data() {
		return {users: []};
	},
	computed: {
		loggedInUser() {
			return this.$store.state.user;
		}
	},
	created() {
		this.$store.commit('SET_TITLE', this.$t('page.users.title'));
		api.users().list()
			.then((users) => this.users = users)
			.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
	},
	methods: {
		deleteUser(user) {
			api.users().delete(user.id)
				.then(() => api.users().list())
				.then((users) => this.users = users)
				.then(() => this.$store.commit('SET_MESSAGE', {text: 'global.action.delete', props: {name: user.name}, type: 'success'}))
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		}
	},
	components: {UserRemoveIcon, PencilIcon}
};
</script>

<style lang="scss" scoped>
@import 'resources/scss/link';

.dp-users .dp-user {
	display: flex;
	align-items: center;
	padding: 1rem;

	&__icon {
		width: 1.5rem;
		height: 1.5rem;
		margin-right: 0.5rem;
		text-decoration: none;
		cursor: pointer;
	}

	&__name {
		margin-right: 1rem;
	}

	&__email {
		color: #48515EFF;
		font-style: italic;
	}

	&:nth-of-type(odd) {
		background-color: #E5E7EB;
	}
}
</style>
