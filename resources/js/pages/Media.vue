<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div class="dp-media" ref="dpMedia">
		<dp-toolbar></dp-toolbar>
		<dp-directories v-for="directory in directories" :directory="directory" :key="directory.path"></dp-directories>
		<dp-images v-for="image in images" :image="image" :key="image.id"></dp-images>
		<dp-modal v-if="selected" :image="selected"></dp-modal>
	</div>
</template>

<script>
import {defineAsyncComponent} from 'vue';
import Toolbar from '../components/media/Toolbar';
import Image from '../components/media/Image';
import Directory from '../components/media/Directory';

const Modal = defineAsyncComponent(() => import('../components/media/Modal'));

export default {
	data() {
		return {observer: null};
	},
	computed: {
		directories() {
			return this.$store.getters.directories;
		},
		images() {
			return this.$store.getters.images;
		},
		selected() {
			return this.$store.state.image;
		}
	},
	created() {
		this.observer = 'IntersectionObserver' in window === false ? null : new IntersectionObserver(this.observeImages);
	},
	updated() {
		this.$store.commit('SET_TITLE', this.$store.getters.current.title);

		const images = Array.from(document.querySelectorAll('.dp-image__image'));

		// Preload first image
		if (images.length) {
			const preloadLink = document.createElement('link');
			preloadLink.href = images[0].dataset.src;
			preloadLink.rel = 'preload';
			preloadLink.as = 'image';
			document.head.appendChild(preloadLink);
		}

		if (!this.observer) {
			images.forEach((image) => image.src = image.dataset.src);
			return;
		}

		this.observer.disconnect();
		images.forEach((image) => this.observer.observe(image));
	},
	methods: {
		observeImages(entries) {
			entries.forEach((entry) => {
				if (!entry.isIntersecting) {
					return;
				}

				const image = entry.target;
				image.src = image.dataset.src;
				this.observer.unobserve(image);
			});
		}
	},
	components: {dpToolbar: Toolbar, dpImages: Image, dpDirectories: Directory, dpModal: Modal}
};
</script>

<style lang="scss" scoped>
.dp-media {
	display: flex;
	flex-direction: column;

	@media only screen and (min-width: 400px) {
		display: grid;
		grid-gap: 1rem;
		grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
	}
}
</style>
