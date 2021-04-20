<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div :class="'dp-message dp-message_' + message.type + (message.type != 'error' ? ' dp-message_fadeout' : '')" v-if="message">
		{{ $t(message.text, message.props ? message.props : {}) }}
	</div>
</template>

<script>
export default {
	computed: {
		message()
		{
			return this.$store.state.message;
		}
	},
	updated()
	{
		if (!this.message || this.message.type == 'error') {
			return;
		}

		// Remove message when animation has finished
		setTimeout(() => this.$store.commit('SET_MESSAGE'), 8000);
	}
};
</script>

<style lang="scss" scoped>
.dp-message {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	padding: 1rem 0;
	text-align: center;
	z-index: 2;

	&_fadeout {
		animation: fadeOut 2s forwards;
		animation-delay: 5s;
	}

	&_info {
		color: #0c5460;
		background-color: #d1ecf1;
		border-color: #bee5eb;
	}

	&_success {
		color: #155724;
		background-color: #d4edda;
		border-color: #c3e6cb;
	}

	&_error {
		color: #721c24;
		background-color: #f8d7da;
		border-color: #f5c6cb;
	}
}

@keyframes fadeOut {
	from {
		opacity: 1;
	}
	to {
		opacity: 0;
	}
}
</style>