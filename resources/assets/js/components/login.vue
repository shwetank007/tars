<style>
	.box {
		background-color: white;
		padding: 30px;
		font-family: Verdana sans-serif;
		font-size: large;
	}
	.box-count {
		margin: 100px 50px;
	}
</style>
<template>
	<div class="center page-wrap">
		<h1>Welcome to T.A.R.S.</h1>
		<div class="container box-count">
			<div class="col-sm-2 col-sm-offset-1 box">
				Hero {{heroCount}}
			</div>
			<div class="col-sm-2 col-sm-offset-2 box">
				Villain {{villainCount}}
			</div>
			<div class="col-sm-2 col-sm-offset-2 box">
				Match {{matchCount}}
			</div>
		</div>
	</div>
</template>
<script>

export default {
	data () {
		return {
			heroCount: 0,
			villainCount: 0,
			matchCount: 0,
		}
	},

	name: 'dashboard',

	created () {
		this.fetch();
	},

	methods: {
		fetch () {
			this.$http.get('api/dashboard')
			.then((response)=> {
				let data = JSON.parse(response.body);
				this.heroCount = data.hero;
				this.villainCount = data.villain;
				this.matchCount = data.match;
			})
			.catch((error)=> {
				console.debug(error);
			});
		}
	}
}
</script>