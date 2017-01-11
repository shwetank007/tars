<style>
	body{
		background-color: #d3d3d3;
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
	<div>
		<div class="center">
			<button @click="seen = !seen">Add Match</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add New Match</h3>
								</div>
								<div class="panel-body">
                                    <div class="form-group">
                                        <select class="select-picker" v-model="hero">
                                            <option disabled value="">Select Superhero</option>
                                            <option v-for="(superhero,index) in superheroes">{{superhero.actor}}</option>
                                        </select>
                                             V/S
                                        <select class="select-picker" v-model="antiHero">
                                            <option disabled value="">Select Villain</option>
                                            <option v-for="(villain,index) in villains">{{villain.actor}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <textarea v-model="cause" name="cause" class="form-control input-sm" placeholder="Cause of Match"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="place" type="text" name="place" class="form-control input-sm" placeholder="Place of Match">
                                    </div>

                                    <div class="form-group">

                                    </div>

                                    <div class="form-group">
                                        <datepicker placeholder="Match Date" v-model="date"></datepicker>
                                    </div>
                                    <button @click="add" class="btn btn-info btn-block">Submit</button>
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
            date: ''
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
    }
}

</script>