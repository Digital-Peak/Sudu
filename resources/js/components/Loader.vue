<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div class="dp-loader" v-if="loading">
		<div class="dp-loader__content">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
</template>

<script>
export default {
	computed: {
		loading() {
			return this.$store.state.loadingStatus;
		}
	}
};
</script>

<style lang="scss">
.dp-loader {
	display: flex;
	justify-content: center;
	align-items: center;
	position: fixed;
	z-index: 2;
	padding-top: 100px;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	background-color: rgba(0, 0, 0, 0.8);

	&__content {
		position: relative;
		width: 100px;
		height: 100px;

		& div {
			position: absolute;
			top: 33px;
			width: 13px;
			height: 13px;
			border-radius: 50%;
			background: #fff;
			animation-timing-function: cubic-bezier(0, 1, 1, 0);

			&:nth-child(1) {
				left: 8px;
				animation: dp-loader1 0.6s infinite;
			}

			&:nth-child(2) {
				left: 8px;
				animation: dp-loader2 0.6s infinite;
			}

			&:nth-child(3) {
				left: 32px;
				animation: dp-loader2 0.6s infinite;
			}

			&:nth-child(4) {
				left: 56px;
				animation: dp-loader3 0.6s infinite;
			}
		}
	}
}

@keyframes dp-loader1 {
	0% {
		transform: scale(0);
	}
	100% {
		transform: scale(1);
	}
}

@keyframes dp-loader3 {
	0% {
		transform: scale(1);
	}
	100% {
		transform: scale(0);
	}
}

@keyframes dp-loader2 {
	0% {
		transform: translate(0, 0);
	}
	100% {
		transform: translate(24px, 0);
	}
}
</style>
