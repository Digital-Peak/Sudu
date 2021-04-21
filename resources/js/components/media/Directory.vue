<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<figure class="dp-directory">
		<figcaption class="dp-directory__caption">{{ directory.title }}</figcaption>
		<router-link :to="'/media' + encodeURI(directory.path)" class="dp-directory__link dp-link-special" :aria-label="directory.title">
			<folder-icon class="dp-directory__icon" :id="1"/>
		</router-link>
	</figure>
</template>

<script>
import {FolderIcon} from '@heroicons/vue/solid';

export default {props: ['directory'], components: {FolderIcon}};
</script>

<style lang="scss" scoped>
@import 'resources/scss/link';

.dp-directory {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
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
}
</style>
