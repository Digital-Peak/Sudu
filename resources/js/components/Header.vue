<!--
 @package   Sudu
 @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
-->

<template>
	<header class="dp-heading"><h1>{{ title }}</h1></header>
</template>

<script>
export default {
	computed: {
		title()
		{
			return this.$store.state.title;
		}
	}
};
</script>

<style scoped>
.dp-heading {
	margin: 0 0 1rem 0;
	padding: 1rem 0 0 0;
	text-align: center;
}
</style>
