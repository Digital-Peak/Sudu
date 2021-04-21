<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<figure :id="image.id" ref="dpImage" :class="{'dp-image_selected': image.selected}" class="dp-image">
		<figcaption class="dp-image__caption dp-caption">
			<div class="dp-caption__title">{{ image.title }}</div>
			<span class="dp-caption__data">
				<span class="dp-caption__info">{{ formatDate(image.data.date) }}</span>
				<span class="dp-caption__info">{{ image.data.width }}x{{ image.data.height }}</span>
				<span class="dp-caption__info">{{ humanFileSize(image.data.size) }}</span>
				<input type="checkbox" name="images[]" v-model="select"
					:aria-label="$t('component.image.button.download')" class="dp-caption__info dp-caption__checkbox">
				<a :href="imagePath(image.path)" :aria-label="image.title" download class="dp-caption__info dp-caption__download">
					<svg class="dp-caption__icon">
						<use href="#dp-icon-download"/>
					</svg>
				</a>
			</span>
		</figcaption>
		<router-link :to="'/media' + encodeURI(image.path)" :aria-label="image.title" class="dp-image__link">
			<img :src="this.$store.state.config.webBase + '/icons/default.jpg'" :data-src="imagePath(image.thumbnail.path)" width="300" height="300"
				class="dp-image__image" :alt="image.title">
		</router-link>
	</figure>
</template>

<script>
export default {
	props: ['image'],
	computed: {
		select: {
			get() {
				return this.image.selected;
			},
			set(value) {
				this.$store.commit('SELECT_IMAGE', {id: this.image.id, checked: value});
			}
		}
	},
	methods: {
		imagePath(path) {
			return this.$store.state.config.webBase + '/' + this.$store.state.config.webImageFolder + path;
		},
		humanFileSize(size) {
			const i = Math.floor(Math.log(size) / Math.log(1024));
			return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
		},
		formatDate(date) {
			return (new Date(date)).toDateString();
		}
	}
};
</script>

<style lang="scss">
.dp-image {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	margin: 0;
	padding: 1rem;
	box-shadow: var(--dp-shadow);

	&__caption {
		width: 100%;
		text-align: center;
	}

	&__icon {
		width: 10rem;
		height: 10rem;
	}

	&__image {
		max-width: 100%;
		margin-top: 1rem;
		object-fit: cover;
	}

	&_selected {
		background-color: #52aa5d;
	}

	.dp-caption {
		&__data {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: center;
		}

		&__info {
			margin: 1rem 0.5rem;
			font-style: italic;
		}

		&__checkbox {
			margin: 1rem 0.8rem 1rem 0.5rem;
			background-color: #fff;
			border-color: #6b7280;
			border-width: 1px;
		}

		&__icon {
			display: block;
			width: 1rem;
			height: 1rem;
		}
	}
}
</style>
