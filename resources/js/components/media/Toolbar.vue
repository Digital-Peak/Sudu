<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<div class="dp-toolbar">
		<share-icon @click="share" v-if="webShareApiSupported" class="dp-toolbar__icon dp-toolbar__icon-share"/>
		<folder-add-icon @click="createFolder" v-if="user.id" class="dp-toolbar__icon dp-toolbar__icon-folder-add"/>
		<trash-icon @click="deleteImages" v-if="user.id && selectedImages.length > 0" class="dp-toolbar__icon dp-toolbar__icon-trash"/>
		<span v-show="selectedImages.length > 0">
			<download-icon @click="download" class="dp-toolbar__icon dp-toolbar__icon-download" ref="dpDownloadIcon"/>
		</span>
		<cloud-upload-icon @click="$refs.dpUpload.click()" v-if="user.id" class="dp-toolbar__icon dp-toolbar__icon-upload"/>
		<input type="file" @change="upload" v-if="user.id" ref="dpUpload" accept="image/png,image/gif,image/jpeg,image/webp"
			   multiple class="dp-toolbar__input">
		<div class="dp-toolbar__files" v-if="user.id && files">
			<div v-for="file in files" class="dp-toolbar__file dp-file">
				<div class="dp-file__progress" v-if="file.progress < 100">{{ file.progress }}%</div>
				<check-circle-icon class="dp-file__finished" v-if="file.progress === 100"/>
				<div class="dp-file__name">{{ file.file.name }}</div>
			</div>
		</div>
	</div>
</template>

<script>
import {CheckCircleIcon, CloudUploadIcon, DownloadIcon, FolderAddIcon, TrashIcon, ShareIcon} from '@heroicons/vue/solid';
import api from '../../plugins/api';

export default {
	data() {
		return {files: []}
	},
	computed: {
		selectedImages() {
			return this.$store.getters.images.filter((image) => image.selected);
		},
		webShareApiSupported() {
			return navigator.share;
		},
		user() {
			return this.$store.state.user;
		}
	},
	mounted() {
		this.$refs.dpDownloadIcon.id = 'dp-icon-download';
	},
	methods: {
		download() {
			this.$store.commit('SET_LOADING_STATUS', true);
			api.files().download(this.$store.getters.images.filter((image) => image.selected).map((image) => image.path))
				.then(data => {
					this.$store.commit('SET_LOADING_STATUS', false);
					if (!data || !data.file) {
						return;
					}
					const link = document.createElement('a');
					link.href = this.$store.state.config.webBase + data.file;
					link.download = 'download.zip';
					link.click();
				}).catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		},
		async upload(event) {
			this.files = Array.from(event.target.files).map((file) => ({file: file, progress: 0}));
			const promises = [];
			this.files.forEach((image) => {
				promises.push(api.files().upload(image.file, this.$store.getters.current.path, (progress) => image.progress = progress)
					.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'})));
			});
			Promise.all(promises).then(() => {
				this.$refs.dpUpload.value = null;
				this.files = [];
				this.$store.dispatch('fetchFiles', this.$store.getters.current.path);
			});
		},
		deleteImages() {
			this.$store.commit('SET_LOADING_STATUS', true);

			const deleteCount = this.selectedImages.length;
			api.files().delete(this.selectedImages.map((image) => image.path), this.$store.getters.current.path)
				.then(files => {
					this.$store.commit('SET_LOADING_STATUS', false);
					this.$store.commit('SET_FILES', files);
					this.$store.getters.images.forEach((image) => image.selected = false);
					this.$store.commit('SET_MESSAGE', {text: this.$tc('component.toolbar.action.delete.success', deleteCount), type: 'info'});
				})
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		},
		share() {
			if (navigator.share) {
				navigator.share({
					title: this.$store.getters.current.title,
					text: this.$store.getters.current.title,
					url: document.location.href
				});
			}
		},
		createFolder() {
			const name = prompt(this.$t('component.toolbar.question.foldername'));
			if (!name) {
				return;
			}
			api.files().createFolder(name, this.$store.getters.current.path)
				.then((folder) => this.$router.push('/media' + folder.path))
				.catch((error) => this.$store.commit('SET_MESSAGE', {text: error.message, type: 'error'}));
		}
	},
	components: {CheckCircleIcon, CloudUploadIcon, DownloadIcon, FolderAddIcon, TrashIcon, ShareIcon}
};
</script>

<style lang="scss" scoped>
.dp-toolbar {
	position: absolute;
	top: 0;
	left: 1rem;
	display: flex;
	align-items: center;
	flex-wrap: wrap;

	&__icon {
		width: var(--dp-icon-size);
		height: var(--dp-icon-size);
		margin-right: 0.5rem;
		cursor: pointer;

		&-folder-add {
			width: calc(var(--dp-icon-size) * 1.3);
			height: calc(var(--dp-icon-size) * 1.3);
		}
	}

	&__input {
		display: none;
	}

	&__files {
		width: 100%;
		color: #ffffff;
		background-color: #000000;
		border: 1px solid var(--dp-border);
		box-shadow: var(--dp-shadow);
	}

	.dp-file {
		display: flex;
		align-items: center;
		padding: 1rem;
		border-bottom: var(--dp-border);

		&:last-of-type {
			border-bottom: 0;
		}

		&__progress {
			min-width: 3rem;
		}

		&__finished {
			min-width: 3rem;
			width: 1.5rem;
			height: 1.5rem;
			fill: #155724;
		}
	}

	@media only screen and (max-width: 640px) {
		& {
			position: inherit;
		}
	}
}
</style>
