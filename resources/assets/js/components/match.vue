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
		<div class="col-md-6">
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
					<button @click="start">Start Match</button>
				</li>
			</ol>
		</div>
		<div class="col-md-6 center" v-if="">
			<ol>
				<li v-for="(comment,index) in commentary">
					{{comment}}
				</li>

				<button @click="clear">Clear</button>
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
			powers: [],
			state: {
				disabled: {
					to: new Date()
				}
			},
			villainHealth: '',
			heroHealth: '',
			weaponDamage: '',
			weaponName: '',
			commentary: []
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
				that.powers	= all.power;
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
		},
		start : function () {
			this.commentary.push('Match Start');
			this.show = true;
			this.toss();
		},
		common : function () {
			return Math.floor((Math.random() * 10));
		},
		toss : function () {
			var winner = this.common() % 2;
//			console.log(winner);
			if(winner == 0) {
				this.commentary.push('Hero Win the toss');
				this.heroAttack(this.heroHealth=100, this.villainHealth=100);
			} else {
				this.commentary.push('Villain Win the toss');
				this.villainAttack(this.heroHealth=100, this.villainHealth=100);
			}
		},
		villainShield : function () {
//			console.log('Shielded villain');
			this.villainHealth = this.villainHealth - (this.weaponDamage * 0.2);
			this.commentary.push('Villain Shield the attack of the Hero but got a knick'+ ' ' +this.villainHealth);
		},
		heroShield : function () {
//			console.log('Shielded Hero');
			this.heroHealth = this.heroHealth - (this.weaponDamage * 0.2);
			this.commentary.push('Hero Shield the attack of the Villain but got a knick'+ ' ' +this.heroHealth);
		},
		heroAttack : function () {
//			console.log('Hero Attack');
			var weaponChoice = this.common();
			this.weaponDamage = this.powers[weaponChoice].damage;
			this.weaponName = this.powers[weaponChoice].powerName;
			this.commentary.push('Hero attacked with'+ ' ' +this.weaponName);
//			console.log("Villain Health <br>"+this.villainHealth);
//			console.log("Hero Health <br>"+this.heroHealth);
			if(this.common() % 2 == 0) {
				this.villainShield(this.villainHealth, this.weaponDamage);
			} else {
				this.villainHealth = this.villainHealth - this.weaponDamage;
				this.commentary.push('Hero hit the villain and strike his life down to'+ ' ' +this.villainHealth);
			}
//			console.log("Hero hit Villain Health"+ "<br>" + this.villainHealth);
			if(this.villainHealth > 0) {
				this.villainAttack(this.villainHealth, this.heroHealth);
			} else {
//				console.log('Villain lost');
				this.commentary.push('Villain Lost');
			}
		},
		villainAttack : function () {
//			console.log('Villain Attack');
			var weaponChoice = this.common();
			this.weaponDamage = this.powers[weaponChoice].damage;
			this.weaponName = this.powers[weaponChoice].powerName;
			this.commentary.push('Villain attacked with'+ ' ' +this.weaponName);
//			console.log("Hero Health <br>" + this.heroHealth);
//			console.log("Villain Health <br>"+this.villainHealth);
			if(this.common() % 2 == 0) {
				this.heroShield(this.heroHealth, this.weaponDamage);
			} else {
				this.heroHealth = this.heroHealth - this.weaponDamage;
				this.commentary.push('Villain hit the hero and strike his life down to'+ ' ' +this.heroHealth);
			}
//			console.log("Villain hit Hero Health"+ "<br>" + this.heroHealth);
			if(this.heroHealth > 0) {
				this.heroAttack(this.villainHealth, this.heroHealth);
			} else {
				console.log('Hero lost');
				this.commentary.push('Hero Lost');
			}
		},
		clear : function () {
			this.commentary = [];
		}
    },
	computed: {
		isValid: function () {
			return this.superhero != '' && this.villain != '' && this.cause != '' && this.place != '' && this.date != ''
		}
	}
}

</script>