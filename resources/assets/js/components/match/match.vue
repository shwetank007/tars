<style>
	.select-picker {
		height: 30px;
		width: 146px;
	}
	.matches {
		margin-top: 75px;
		border: 1px solid #999;
		padding: 43px;
		border-radius: 20px;
		background-color: #e7e7e7;
	}

	.versus {
		font-size: 12px;
		font-weight: bold;
		text-align: center;
		margin-top: 7px;
		margin-left: 5px;
	}
	.button-reset {
		margin-top: 45px;
		text-align: center;
	}
	.circle {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		font-size: 14px;
		color: #fff;
		line-height: 40px;
		text-align: center;
		background: dimgrey;
		margin: 48px auto;
	}
	.detail {
		margin-top: 20px;
		line-height: 1.8;
		text-align: center;
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
													<option v-for="(superhero,index) in superheroes" v-bind:value="{id: superhero.id, name: superhero.actor, avatar: superhero.avatar}">{{superhero.actor}}</option>
												</select>
												<span v-show="errors.has('hero')" class="help-block">{{ errors.first('hero') }}</span>
											</div>
										</div>
										<div class="col-md-1 versus">V/S</div>
										<div class="col-md-5">
											<div class="form-group" :class="{'has-error': errors.has('antiHero')}">
												<select class="select-picker form-control" v-model="antiHero" v-validate data-vv-rules="required" data-vv-name="antiHero">
													<option value="">Select Villain</option>
													<option v-for="(villain,index) in villains" v-bind:value="{id: villain.id, name: villain.actor, avatar: villain.avatar}">{{villain.actor}}</option>
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
		<div class="container matches" v-for="(match,index) in matches" v-cloak>
			<div class="col-md-4 font-line">
				<div class="left-align">
					<img :src="'images/'+match.hero.avatar" height="120px" width="120px" style="border-radius: 50%;"><br>
					{{match.hero.actor}}
				</div>
			</div>
			<div class="col-md-4">
				<div class="circle">
					<b>V/S</b>
				</div>
				<div class="button-reset">
					<button @click="match.detail = !match.detail">{{(match.detail)?'Hide Detail':'Detail' }}</button>
					<button @click="remove(index,match.id)">Delete</button>
					<router-link :to="{ name: 'fight', params: { id: match.id }}"><button>Start Match</button></router-link>
					<!--<button v-on:click="start(match.hero.actor, match.villain.actor)">Start Match</button>-->
				</div>
				<div v-show="match.detail" class="detail">
					<b>Cause       :</b> {{ match.cause }}.<br>
					<b>Place       :</b> {{ match.place }}.<br>
					<b>Date        :</b> {{match.date}}.
				</div>
			</div>
			<div class="col-md-4 font-line">
				<div class="right-align">
					<img :src="'images/'+match.villain.avatar" height="120px" width="120px" style="border-radius: 50%;"><br>
					{{match.villain.actor}}
				</div>
			</div>
		</div>
	</div>
</template>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script>
import Datepicker from 'vuejs-datepicker';
var moment = require('moment');

export default {

	components: { Datepicker },

	data () {
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
			powers: [],
			state: {
				disabled: {
					to: new Date()
				}
			}
        }
    },

	name: 'match',

	created() {
		this.fetch();
	},

    methods: {

        fetch () {
			this.$http.get('api/match')
			.then((response) => {
			    let all = JSON.parse(response.body);
                this.matches = all.fixture;
                this.superheroes = all.heroes;
                this.villains = all.antiHeroes;
				this.powers	= all.power;
			})
			.catch((error) => {
				console.debug(error);
			});
        },

		add () {
			let match = {
				hero_id: this.hero.id,
				villain_id: this.antiHero.id,
				cause: this.cause,
				place: this.place,
                date: moment(this.date).format('DD/MM/YYYY'),
				detail: '0'
			};
			let fight = {
				hero: {
					actor: this.hero.name,
					avatar: this.hero.avatar
				},
				villain: {
					actor: this.antiHero.name,
					avatar: this.antiHero.avatar
				},
				cause: this.cause,
				place: this.place,
				date: moment(this.date).format('DD/MM/YYYY'),
				detail: false
			};
			this.$http.post('api/match', match)
			.then((response) => {
				this.matches.push(fight);
			})
			.catch((error) => {
				console.debug(error);
			});
			this.superhero = this.villain = this.cause = this.place = this.date = '';
			this.seen = false;
		},

		remove (item,id) {
			this.$http.delete('api/match/'+id)
			.then((response) => {
				this.matches.splice(item,1);
			})
			.catch((error) => {
				console.debug(error);
			});
		}
    },
	computed: {

		isValid () {
			return this.superhero != '' && this.villain != '' && this.cause != '' && this.place != '' && this.date != ''
		}
	}
}
</script>