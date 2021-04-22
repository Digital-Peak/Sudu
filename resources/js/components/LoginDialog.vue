<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div class="dp-login-dialog">
		<div class="dp-login-dialog__content">
			<form class="dp-login-dialog__form dp-form" @submit.prevent>
				<div class="dp-form__block">
					<label class="dp-form__label">{{ $t('component.login.dialog.input.email') }}</label>
					<input type="text" :placeholder="$t('component.login.dialog.input.email')" ref="dpInputEmail" class="dp-form__input" v-focus>
				</div>
				<div class="dp-form__block">
					<label class="dp-form__label">{{ $t('component.login.dialog.input.password') }}</label>
					<input type="password" ref="dpInputPassword" class="dp-form__input">
				</div>
				<div class="dp-form__buttons">
					<button type="submit" @click="emit(true)" class="dp-button-save">{{ $t('component.login.dialog.button.submit') }}</button>
					<button type="button" @click="emit(false)" class="dp-button-cancel">{{ $t('component.login.dialog.button.close') }}</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import api from '../plugins/api';

export default {
	emits: ['close'],
	methods: {
		emit(submit) {
			if (!submit) {
				this.$emit('close');
				return;
			}

			api.user().login(this.$refs.dpInputEmail.value, this.$refs.dpInputPassword.value)
				.then((user) => this.$store.commit('SET_USER', user))
				.then(() => this.$store.commit('SET_MESSAGE'))
				.then(() => this.$emit('close'))
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		}
	}
};
</script>

<style lang="scss" scoped>
@import 'resources/scss/button';
@import 'resources/scss/form';

.dp-login-dialog {
	position: fixed;
	z-index: 1;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	display: flex;
	align-items: center;
	justify-content: center;
	background-color: var(--dp-overlay);
	pointer-events: auto;

	&__content {
		width: 80%;
	}

	&__form {
		padding: 1rem;
		background-color: #ffffff;
		box-shadow: var(--dp-shadow);
	}
}
</style>
