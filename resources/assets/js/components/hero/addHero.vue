<style>
.background {
    background: white;
    padding: 30px;
}
</style>
<template>
    <div class="page-wrap">
        <div class="container background">
            <form>
                <div class="form-group center" :class="{'has-error': errors.has('avatar')}">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 120px;border-radius: 50%;">
                            <img src="default.gif">
                        </div>
                        <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">Upload Avatar</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" v-on:change="upload" class="form-control input-sm"
                                       v-validate data-vv-rules="required" data-vv-name="avatar">
                            <span v-show="errors.has('avatar')" class="help-block">{{ errors.first('avatar') }}</span>
                            </span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': errors.has('actor')}">
                    <input v-model="actor" v-validate data-vv-rules="required" data-vv-name="actor" type="text"
                           class="form-control input-sm" placeholder="Superhero Name">
                    <span v-show="errors.has('actor')" class="help-block">{{ errors.first('actor') }}</span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('name')}">
                    <input v-model="name" v-validate data-vv-rules="required" data-vv-name="name" type="text"
                           class="form-control input-sm" placeholder="Superhero Alias">
                    <span v-show="errors.has('name')" class="help-block">{{ errors.first('name') }}</span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('weakness')}">
                    <input v-model="weakness" v-validate data-vv-rules="required" data-vv-name="weakness" type="text"
                           class="form-control input-sm" placeholder="Weakness">
                    <span v-show="errors.has('weakness')" class="help-block">{{ errors.first('weakness') }}</span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('partner')}">
                    <input v-model="partner" v-validate data-vv-rules="required" data-vv-name="partner" type="text"
                           class="form-control input-sm" placeholder="Partner Name">
                    <span v-show="errors.has('partner')" class="help-block">{{ errors.first('partner') }}</span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('rival')}">
                    <input v-model="rival" v-validate data-vv-rules="required" data-vv-name="rival" type="text"
                           class="form-control input-sm" placeholder="Arch Rival Name">
                    <span v-show="errors.has('rival')" class="help-block">{{ errors.first('rival') }}</span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('powerName')}">
                    <input v-model="powerName" v-validate data-vv-rules="required" data-vv-name="powerName" type="text"
                           class="form-control input-sm" placeholder="Power Name">
                    <span v-show="errors.has('powerName')" class="help-block">{{ errors.first('powerName') }}</span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('powerDamage')}">
                    <input v-model="powerDamage" v-validate data-vv-rules="required" data-vv-name="powerDamage" type="text"
                           class="form-control input-sm" placeholder="Power Damage">
                    <span v-show="errors.has('powerDamage')" class="help-block">{{ errors.first('powerDamage') }}</span>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
//    data: function () {
//    },
//    methods:{
//
//    }
}
</script>