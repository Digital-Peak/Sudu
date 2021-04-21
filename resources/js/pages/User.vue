<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<form class="dp-user dp-form" @submit.prevent>
		<div class="dp-form__block">
			<label class="dp-form__label">{{ $t('page.user.input.name') }}</label>
			<input type="text" :placeholder="$t('page.user.input.name')" v-model="user.name" class="dp-form__input">
		</div>
		<div class="dp-form__block">
			<label class="dp-form__label">{{ $t('page.user.input.email') }}</label>
			<input type="text" :placeholder="$t('page.user.input.email')" v-model="user.email" class="dp-form__input">
		</div>
		<div class="dp-form__block">
			<label class="dp-form__label">{{ $t('page.user.input.password') }}</label>
			<input type="password" ref="dpInputPassword" class="dp-form__input">
		</div>
		<div class="dp-form__buttons">
			<button type="submit" @click="save" class="dp-button-save">{{ $t('page.user.button.save') }}</button>
			<button type="button" @click="reset" v-if="id" class="dp-button">{{ $t('page.user.button.reset') }}</button>
			<router-link to="/users" class="dp-button-cancel">{{ $t('page.user.button.cancel') }}</router-link>
		</div>
	</form>
</template>

<script>
import api from '../plugins/api';

export default {
	props: ['id'],
	data() {
		return {user: {}};
	},
	created() {
		this.$store.commit('SET_TITLE', this.$t('page.user.title'));
		this.reset();
	},
	methods: {
		save() {
			const user = Object.assign(this.user);
			user.password = this.$refs.dpInputPassword.value;
			(user.id ? api.users().update(user) : api.users().add(user))
				.then(() => this.$store.commit('SET_MESSAGE', {text: 'global.action.save', props: {name: user.name}, type: 'success'}))
				.then(() => this.id === 'me' ? this.$store.dispatch('fetchUser') : this.$router.push('/users'))
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		},
		reset() {
			if (!this.id) {
				this.user = {};
				return;
			}

			if (this.id === 'me') {
				this.$store.dispatch('fetchUser').then((user) => this.user = user);
				return;
			}

			api.users().get(this.id)
				.then((user) => this.user = user)
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		}
	},
	watch: {
		'$props.id'() {
			this.reset();
		}
	}
};
</script>
<style lang="scss" scoped>
@import 'resources/scss/button';
@import 'resources/scss/form';
</style>
