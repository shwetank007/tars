<style>
	.center {
		text-align: center;
	}
</style>
<template>
	<div class="center">
		<div class="alert alert-danger" v-if="error">
        	<p>Invalid Credentials</p>
      	</div>
		<input v-model="credentials.email" placeholder="E-Mail Address" type="email"><br>
		<input v-model="credentials.password" placeholder="Password" type="password"><br>
		<button @click="submit()">Submit</button>
	</div>
</template>
<script>

export default {
	data() {
		return {
			credentials: {
				email: '',
				passsword: ''
			},	
			error: false
		}
	},
	methods: { 
		submit: function() {
			let that = this;
			var credentials = {
				email: this.credentials.email,
				password: this.credentials.password
			}
			this.$http.post('api/login', credentials)
            .then((response) => {
                if(response.status == 'success') {
                	window.location = "http://localhost/tars/public/index#/hero";
            	}
            })
            .catch((error) => {
            	that.error = true;
            });     
		}
	}
}
</script>