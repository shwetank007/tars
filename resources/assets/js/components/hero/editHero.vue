<template>
    <div class="page-wrap">
        <div class="container background">
            <ul class="nav nav-tabs header-fix" role="tablist">
                <li role="presentation" class="active"><a href="#bio" aria-controls="bio" role="tab" data-toggle="tab">Bio</a></li>
                <li role="presentation"><a href="#power" aria-controls="power" role="tab" data-toggle="tab">Power</a></li>
            </ul>
            <form>
                <!--Start Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="bio">
                        <div class="form-group center">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 120px;border-radius: 50%;">
                                    <img :src="'images/'+avatar">
                                </div>
                                <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">Upload Avatar</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" class="form-control input-sm" v-on:change="upload"
                                       data-vv-name="avatar">
                            </span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-sm-offset-3">
                                <div class="form-group" :class="{'has-error': errors.has('actor')}">
                                    <input v-model="actor" v-validate data-vv-rules="required" data-vv-name="actor" type="text"
                                           class="form-control input-sm" placeholder="Superhero Name">
                                    <span v-show="errors.has('actor')" class="help-block">{{ errors.first('actor') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" :class="{'has-error': errors.has('name')}">
                                    <input v-model="name" v-validate data-vv-rules="required" data-vv-name="name" type="text"
                                           class="form-control input-sm" placeholder="Superhero Alias">
                                    <span v-show="errors.has('name')" class="help-block">{{ errors.first('name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-sm-offset-3">
                                <div class="form-group" :class="{'has-error': errors.has('partner')}">
                                    <input v-model="partner" v-validate data-vv-rules="required" data-vv-name="partner" type="text"
                                           class="form-control input-sm" placeholder="Partner Name">
                                    <span v-show="errors.has('partner')" class="help-block">{{ errors.first('partner') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" :class="{'has-error': errors.has('rival')}">
                                    <input v-model="rival" v-validate data-vv-rules="required" data-vv-name="rival" type="text"
                                           class="form-control input-sm" placeholder="Arch Rival Name">
                                    <span v-show="errors.has('rival')" class="help-block">{{ errors.first('rival') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4 note-text">
                                Note :- To submit the form fill power in power tab.
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="power">
                        <div class="col-sm-3 col-sm-offset-3">
                            <div class="form-group" :class="{'has-error': errors.has('powerName')}">
                                <input v-model="powerName" v-validate data-vv-rules="required" data-vv-name="powerName" type="text"
                                       class="form-control input-sm" placeholder="Power Name">
                                <span v-show="errors.has('powerName')" class="help-block">{{ errors.first('powerName') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" :class="{'has-error': errors.has('powerDamage')}">
                                <input v-model="powerDamage" v-validate data-vv-rules="required|between:1,100" data-vv-name="powerDamage" type="text"
                                       class="form-control input-sm" placeholder="Power Damage">
                                <span v-show="errors.has('powerDamage')" class="help-block">{{ errors.first('powerDamage') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4 center">
                                <!--<button @click="submitPower" v-bind:disabled="!checkPower" class="btn btn-primary">Submit Power</button>-->
                            </div>
                        </div>
                        <div><!--v-if="seen"-->
                            <div class="row table-start center">
                                <div class="col-sm-2 col-sm-offset-3 power-border">
                                    Power Name
                                </div>
                                <div class="col-sm-2 power-border">
                                    Power Damage
                                </div>
                                <div class="col-sm-2 power-border">
                                    Actions
                                </div>
                            </div>
                            <div class="row center" v-for="(power,index) in powers">
                                <div class="col-sm-2 col-sm-offset-3 power-border border-fix">
                                    {{power.power_name}}
                                </div>
                                <div class="col-sm-2 power-border border-fix">
                                    {{power.damage}}
                                </div>
                                <div class="col-sm-2 power-border action-border">
                                    <!--@click="editPower(index)"--><button class="btn btn-primary edit-button">Edit</button>
                                    <!-- @click="deletePower(index)"--><button class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                            <div class="row submit-button center">
                                <div class="col-sm-4 col-sm-offset-4 center"><!--v-bind:disabled="!isValid"-->
                                    <button @click.prevent="editHero()" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Tab panes-->
            </form>
        </div>
    </div>
</template>
<script>
    export default {

        data () {
            return {
                actor: '',
                avatar: '',
                name: '',
                partner: '',
                rival: '',
                powerName: '',
                powerDamage: 0,
                powers: [],
            }
        },

        name: 'edit-hero',

        created () {
            this.fetch();
        },

        methods: {

            upload (e) {
                this.avatar = e.target.files[0] || e.dataTransfer.files[0];
            },

            fetch () {
                let id  = this.$route.params.id;
                this.$http.get('api/hero/' + id)
                        .then((response)=> {
                            let data = JSON.parse(response.body);
                            this.avatar     = data.hero.avatar;
                            this.actor      = data.hero.actor;
                            this.name       = data.hero.name;
                            this.partner    = data.hero.partner;
                            this.rival      = data.hero.rival;
                            this.powers     = data.hero.power;
                        })
                        .catch((error)=>{
                            console.debug(error);
                        });
            },

            editHero () {
                let id  = this.$route.params.id;
                let form = new FormData;
                form.append('avatar', this.avatar);
                form.append('_method', 'put');

                let hero = {
                    actor: this.actor,
                    name: this.name,
                    rival: this.rival,
                    partner: this.partner,
                    power: this.powers,
                    detail: 0,
                };

                //form.append('hero', JSON.stringify(hero));

                this.$http.post('api/hero/' + id, form)
                .then((response)=> {
                    console.log(response);
                })
                .catch((error)=>{

                });
            },

        }
    }
</script>