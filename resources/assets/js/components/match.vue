<style>
	html,body{
		background-color: #d3d3d3;
		height:100%;
	}
	.centered-form{
		margin-top: 60px;
	}

	.centered-form .panel{
		background: rgba(255, 255, 255, 0.8);
	}
	.panel{
		margin-top: 15px;
	}
	.select-picker {
		height: 30px;
		width: 146px;
	}
</style>
<template>
	<div class="page-wrap">
		<div class="center">
			<button @click="seen = !seen">{{(seen)?'Cancel':'Add Match' }}</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add New Match</h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-5">
											<div class="form-group" :class="{'has-error': errors.has('hero')}">
												<select class="select-picker form-control" v-model="hero" v-validate data-vv-rules="required" data-vv-name="hero">
													<option value="">Select Hero</option>
													<option v-for="(superhero,index) in superheroes">{{superhero.actor}}</option>
												</select>
												<span v-show="errors.has('hero')" class="help-block">{{ errors.first('hero') }}</span>
											</div>
										</div>
										<div class="col-md-1">V/S</div>
										<div class="col-md-5">
											<div class="form-group" :class="{'has-error': errors.has('antiHero')}">
												<select class="select-picker form-control" v-model="antiHero" v-validate data-vv-rules="required" data-vv-name="antiHero">
													<option value="">Select Villain</option>
													<option v-for="(villain,index) in villains">{{villain.actor}}</option>
												</select>
												<span v-show="errors.has('antiHero')" class="help-block">{{ errors.first('antiHero') }}</span>
											</div>
										</div>
									</div>

                                    <div class="form-group" :class="{'has-error': errors.has('cause')}">
                                        <textarea v-model="cause" v-validate data-vv-rules="required" data-vv-name="cause" class="form-control input-sm" placeholder="Cause of Match"></textarea>
										<span v-show="errors.has('cause')" class="help-block">{{ errors.first('cause') }}</span>
									</div>

                                    <div class="form-group" :class="{'has-error': errors.has('place')}">
                                        <input v-model="place" type="text" v-validate data-vv-rules="required" data-vv-name="place" class="form-control input-sm" placeholder="Place of Match">
										<span v-show="errors.has('place')" class="help-block">{{ errors.first('place') }}</span>
									</div>

                                    <div class="form-group" :class="{'has-error': errors.has('date')}">
                                        <datepicker :disabled="state.disabled" placeholder="Match Date" v-model="date" v-validate data-vv-rules="required" data-vv-name="date"></datepicker>
										<span v-show="errors.has('date')" class="help-block">{{ errors.first('date') }}</span>
									</div>
                                    <button @click.prevent="add" v-bind:disabled="!isValid" class="btn btn-info btn-block">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<ol>
				<li v-for="(match,index) in matches" v-cloak>
					{{ match.actor }}
					<div v-show="match.detail">
						Cause       : {{ match.cause }}.<br>
						Place       : {{ match.place }}.<br>
                        Date        : {{match.date}}.
					</div>
					<button @click="match.detail = !match.detail">{{(match.detail)?'Hide Detail':'Detail' }}</button>
					<button @click="remove(index,match.id)">Delete</button>
				</li>
			</ol>
		</div>
	</div>
</template>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script>
import Datepicker from 'vuejs-datepicker';
var moment = require('moment');

export default {
    components: { Datepicker },
    data: function () {
        return {
            seen: false,
            superheroes: [],
            villains: [],
            cause: '',
            place: '',
            actor: '',
            matches: [],
            hero: '',
            antiHero: '',
            date: '',
			state: {
				disabled: {
					to: new Date()
				}
			}
        }
    },
  	created() {
		this.fetch();
	},
    methods: {
        fetch: function () {
			let that = this;
			this.$http.get('api/match')
			.then((response) => {
			    var all = JSON.parse(response.body);
                that.matches = all.fixture;
                that.superheroes = all.heros;
                that.villains = all.aVillain;
			})
			.catch((response) => {
				console.log('fail');
			});
        },
        add : function () {
            let that = this;
			var match = {
				actor: that.hero + ' ' + 'v/s' + ' ' + that.antiHero,
				cause: that.cause,
				place: that.place,
                date: moment(that.date).format('DD/MM/YYYY'),
				detail: false
			};
			this.$http.post('api/match', match)
			.then((response) => {
				this.matches.push(match);
			})
			.catch((response) => {
				console.log('error');
			});
			this.superhero = this.villain = this.cause = this.place = this.date = '';
			this.seen = false;
		},
		remove : function (item,id) {
			this.$http.delete('api/match/'+id)
			.then((response) => {
				this.matches.splice(item,1);
			})
			.catch((response) => {
				console.log('Not Deleted');
			});
		}
    },
	computed: {
		isValid: function () {
			return this.superhero != '' && this.villain != '' && this.cause != '' && this.place != '' && this.date != ''
		}
	}
}

</script>