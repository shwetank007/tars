<template>
<div>
	<site-header></site-header>
	<router-view></router-view>
	<site-footer></site-footer>
</div>
</template>

<script>
import Vue from 'vue';
import SiteHeader from './components/header.vue';
import SiteFooter from './components/footer.vue';

export default {
	components: { SiteHeader, SiteFooter }
}
</script>