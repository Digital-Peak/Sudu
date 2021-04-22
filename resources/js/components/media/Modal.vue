<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div class="dp-modal" ref="dpModal">
		<div class="dp-modal__toolbar">
			<arrow-left-icon @click="prev(image.id)" class="dp-modal__prev"/>
			<div class="dp-modal__actions">
				<svg class="dp-modal__full" @click="full" v-if="!isFull">
					<use href="#dp-icon-full"/>
				</svg>
				<svg class="dp-modal__closefull" @click="full" v-if="isFull">
					<use href="#dp-icon-closefull"/>
				</svg>
				<share-icon @click="share" v-if="webShareApiSupported" class="dp-modal__share"/>
				<router-link :to="'/media' + encodeURI(image.path.slice(0, image.path.lastIndexOf('/') + 1))"
					:aria-label="$t('component.modal.button.close')">
					<x-icon class="dp-modal__close"/>
				</router-link>
			</div>
			<arrow-right-icon @click="next(image.id)" class="dp-modal__next"/>
		</div>
		<img class="dp-modal__image" :src="imagePath(image.path)" :width="image.data.width" :height="image.data.height"
			@load="loaded(image.id)" @touchstart="handleTouchStart" :alt="image.title"
			@touchmove="handleTouchMove" @touchend="handleTouchEnd" @swiped-right="prev(image.id)" @swiped-left="next(image.id)">
		<div class="dp-modal__caption">{{ image.title }}</div>
	</div>
</template>

<script>
import {ArrowLeftIcon, ArrowRightIcon, ShareIcon, XIcon} from '@heroicons/vue/solid';

export default {
	props: ['image'],
	data() {
		return {
			swiper: {
				xDown: null,
				xDiff: null,
				timeDown: null,
				startEl: null
			},
			isFull: false
		};
	},
	computed: {
		webShareApiSupported() {
			return navigator.share;
		}
	},
	methods: {
		imagePath(path) {
			return this.$store.state.config.webBase + '/' + this.$store.state.config.webImageFolder + path;
		},
		loaded() {
			this.$store.commit('SET_LOADING_STATUS', false);
		},
		full() {
			if (!document.fullscreenElement) {
				this.isFull = true;
				this.$refs.dpModal.requestFullscreen();
			} else if (document.exitFullscreen) {
				document.exitFullscreen();
				this.isFull = false;
			}
		},
		share() {
			if (navigator.share) {
				navigator.share({
					title: this.image.title,
					text: this.image.title,
					url: document.location.href
				});
			}
		},
		prev(id) {
			this.$store.getters.images.forEach((image, index, images) => {
				if (image.id !== id) {
					return;
				}

				if (index - 1 < 0) {
					index = images.length;
				}

				this.$store.commit('SET_LOADING_STATUS', true);
				this.$store.commit('SET_IMAGE', images[index - 1]);
			});
		},
		next(id) {
			this.$store.getters.images.forEach((image, index, images) => {
				if (image.id !== id) {
					return;
				}

				if (images.length === index + 1) {
					index = -1;
				}

				this.$store.commit('SET_LOADING_STATUS', true);
				this.$store.commit('SET_IMAGE', images[index + 1]);
			});
		},
		handleTouchEnd(e) {
			if (this.swiper.startEl !== e.target) {
				return;
			}

			if (Math.abs(this.swiper.xDiff) > 20 && Date.now() - this.swiper.timeDown < 1000) {
				this.swiper.startEl.dispatchEvent(new CustomEvent(this.swiper.xDiff > 0 ? 'swiped-left' : 'swiped-right'));
			}

			// Reset values
			this.swiper.xDown = null;
			this.swiper.timeDown = null;
		},
		handleTouchStart(e) {
			this.swiper.startEl = e.target;

			this.swiper.timeDown = Date.now();
			this.swiper.xDown = e.touches[0].clientX;
			this.swiper.xDiff = 0;
		},
		handleTouchMove(e) {
			if (!this.swiper.xDown) {
				return;
			}

			this.swiper.xDiff = this.swiper.xDown - e.touches[0].clientX;
		}
	},
	components: {ArrowLeftIcon, ArrowRightIcon, ShareIcon, XIcon}
};
</script>

<style lang="scss" scoped>
.dp-modal {
	position: fixed;
	display: flex;
	flex-direction: column;
	align-items: center;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	z-index: 1;
	padding-top: 1rem;
	overflow: auto;
	background-color: var(--dp-overlay);

	&__image {
		max-width: 80%;
		max-height: 80%;
		height: auto;
		width: auto;
		margin: 1.5rem 0;
	}

	&__caption {
		max-width: 80%;
		margin: auto;
		text-align: center;
		color: #ccc;
	}

	&__image, &__caption {
		animation-name: zoom;
		animation-duration: 0.6s;
	}

	@keyframes zoom {
		from {
			transform: scale(0)
		}
		to {
			transform: scale(1)
		}
	}

	&__toolbar {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	&__prev, &__next, &__full, &__closefull, &__close, &__share {
		width: var(--dp-icon-size);
		height: var(--dp-icon-size);
		color: #ffffff;
		fill: currentColor;
		cursor: pointer;
	}

	&__full, &__closefull {
		width: calc(var(--dp-icon-size) * 0.9);
		height: calc(var(--dp-icon-size) * 0.9);
	}

	&__close {
		width: calc(var(--dp-icon-size) * 1.2);
		height: calc(var(--dp-icon-size) * 1.2);
	}

	&__prev, &__full, &__closefull, &__close, &__share {
		margin-right: 1rem;
	}

	&__actions {
		display: flex;
		align-items: center;
	}
}
</style>
