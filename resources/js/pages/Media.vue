<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<dp-toolbar></dp-toolbar>
	<div class="dp-media" ref="dpMedia">
		<dp-directories v-for="directory in directories" :directory="directory"></dp-directories>
		<dp-images v-for="image in images" :image="image"></dp-images>
	</div>
	<dp-modal v-if="selected" :image="selected"></dp-modal>
</template>

<script>
import {defineAsyncComponent} from 'vue';
import Toolbar from '../components/media/Toolbar';
import Image from '../components/media/Image';
import Directory from '../components/media/Directory';

const Modal = defineAsyncComponent(() => import( '../components/media/Modal'));

export default {
	data()
	{
		return {observer: null};
	},
	computed: {
		directories()
		{
			return this.$store.getters.directories;
		},
		images()
		{
			return this.$store.getters.images;
		},
		selected()
		{
			return this.$store.state.selectedImage;
		}
	},
	created()
	{
		this.observer = 'IntersectionObserver' in window === false ? null : new IntersectionObserver(this.observeImages);
	},
	updated()
	{
		this.$store.commit('SET_TITLE', this.$store.getters.current.title);

		if (!this.observer) {
			Array.from(document.querySelectorAll('.dp-image__image')).forEach((image) => image.src = image.dataset.src);
			return;
		}

		this.observer.disconnect();
		Array.from(document.querySelectorAll('.dp-image__image')).forEach((image) => this.observer.observe(image));
	},
	methods: {
		observeImages(entries)
		{
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