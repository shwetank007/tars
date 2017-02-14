<template>
    <div class="page-wrap">
        <div class="container background">
            <form>
                <div class="form-group center">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 120px;border-radius: 50%;">
                            <img src="default.gif">
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

                <!--Add Power Form-->
                <div v-if="showAddPower" class="row">
                    <div class="col-sm-3 col-sm-offset-3">
                        <div class="form-group" :class="{'has-error': errors.has('powerName')}">
                            <input v-model="powerName" v-validate data-vv-rules="required" data-vv-name="powerName" type="text"
                                   class="form-control input-sm" placeholder="Power Name">
                            <span v-show="errors.has('powerName')" class="help-block">{{ errors.first('powerName') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group" :class="{'has-error': errors.has('powerDamage')}">
                            <input v-model="powerDamage" v-validate data-vv-rules="required" data-vv-name="powerDamage" type="text"
                                   class="form-control input-sm" placeholder="Power Damage">
                            <span v-show="errors.has('powerDamage')" class="help-block">{{ errors.first('powerDamage') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4 center">
                            <button @click="submitPower" v-bind:disabled="!checkPower" class="btn btn-primary">Submit Power</button>
                        </div>
                    </div>
                </div>
                <!--End-->
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4 center">
                        <button @click="addPower" v-if="!this.showAddPower" type="submit" class="btn btn-primary">Add Power</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container power-table" v-show="seen">
            <div class="row table-start">
                <div class="col-sm-3 col-sm-offset-3 power-border">
                    Power Name
                </div>
                <div class="col-sm-3 power-border">
                    Power Damage
                </div>
            </div>
            <div class="row" v-for="power in powers">
                <div class="col-sm-3 col-sm-offset-3 power-border">
                    {{power.name}}
                </div>
                <div class="col-sm-3 power-border">
                    {{power.damage}}
                </div>
            </div>
            <div class="row submit-button">
                <div class="col-sm-4 col-sm-offset-4 center">
                    <button @click.prevent="addHero" v-bind:disabled="!isValid" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    data () {
        return{
            avatar:'',
            actor: '',
            name: '',
            partner: '',
            rival: '',
            powerName: '',
            powerDamage: 0,
            powers:[],
            showAddPower: false,
            weaponName:[],
            weaponDamage:[],
            seen: false,
        }
    },

    name: 'add-hero',

    methods:{

        upload (e) {
            this.avatar = e.target.files[0] || e.dataTransfer.files[0];
        },

        addHero () {
            let form = new FormData;
            form.append('avatar',this.avatar);
            let hero = {
                actor: this.actor,
                name: this.name,
                rival: this.rival,
                partner: this.partner,
                power: this.powers,
                detail: 0,
            };
            form.append('hero',JSON.stringify(hero));
            this.$http.post('api/hero', form)
                .then((response) => {
                    this.actor = this.name = this.partner = this.rival = this.avatar = '';
                    this.powers=[];
                    this.$router.push('/hero');
                })
                .catch((error) => {
                    console.debug(error);
                    this.errorMessage = true;
                });
        },

        clearPowerForm () {
            this.powerName = '';
            this.powerDamage = 0 ;
        },

        addPower () {
            this.clearPowerForm();
            this.showAddPower = true;
        },

        submitPower () {
            this.powers.push({
                name: this.powerName,
                damage: this.powerDamage
            });
            this.clearPowerForm();
            this.showAddPower = false;
            this.seen = true;
        }
    },
    computed:{

        isValid () {
            return this.actor != '' && this.name != '' && this.partner != '' && this.rival != ''
        },

        checkPower () {
            return this.powerName != '' && this.powerDamage != ''
        }
    }
}
</script>