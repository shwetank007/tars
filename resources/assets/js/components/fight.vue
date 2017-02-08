<style>
    .comment{
        margin-top: 45px;
        text-align: center;
    }
    .review {
        padding-top: 1px;
        padding-bottom: 4px;
        font-family: lato,sans-serif;
        font-weight: 500;
        font-size: 13px;
    }
    .strong{
        font-weight: bold;
    }
</style>
<template>
    <div class="page-wrap">
        <div class="container matches">
            <div class="col-md-2 font-line">
                <div class="left-align">
                    <img :src="'images/'+match.hero.avatar" height="120px" width="120px" style="border-radius: 50%;"><br>
                    {{match.hero.actor}}
                </div>
                <span>{{match.hero.actor}} Life: {{heroLife}}</span>
            </div>
            <div class="col-md-8 comment">
                <ol style="list-style-type: none">
                    <li v-for="(comment,index) in commentary"  v-html="comment.view" class="review">
                    </li>
                </ol>
            </div>
            <div class="col-md-2 font-line">
                <div class="right-align">
                    <img :src="'images/'+match.villain.avatar" height="120px" width="120px" style="border-radius: 50%;"><br>
                    {{match.villain.actor}}
                </div>
                <span>{{match.villain.actor}} Life: {{villainLife}}</span>
            </div>
        </div>
</template>
<script>
export default {
    data: function() {
        return {
            match:'',
            powers:'',
            chance: 0,
            villainHealth: 100,
            heroHealth: 100,
            weaponDamage: '',
            weaponName: '',
            defence: 0,
            heroName: '',
            villainName: '',
            narration: {},
            commentary: {},
            heroLife:100,
            villainLife:100,
            matchComplete: false
        }
    },
    created() {
        this.fetch();
    },
    methods: {
        fetch : function () {
            var id = this.$route.params.id;
            this.$http.get('api/match/' + id)
            .then((response) => {
                var all = JSON.parse(response.body);
                this.match = all.fixture;
                this.powers = all.power;
                var hero = this.match.hero.actor;
                var villain = this.match.villain.actor;
                this.start(hero, villain);
            })
            .catch((error) => {
               console.debug(error);
            });
        },
        start : function (hero,villain) {
            this.heroHealth = 100;
            this.villainHealth = 100;
            this.heroName = hero;
            this.villainName = villain;
            this.clear();
            this.comment({
                view: '<b>Match Start</b>',
                heroLife: this.heroHealth,
                villainLife: this.villainHealth
            });
            this.toss();
        },
        toss : function () {
            var tossWin = Math.floor(Math.random() * 2);
            var n = 0;
            if(tossWin == 0) {
                this.comment({
                    view: '<font color="green"><i>' + this.heroName + '</i>' +' won the toss</font>',
                    heroLife: this.heroHealth,
                    villainLife: this.villainHealth
                });
                while(this.heroHealth >= 0 && this.villainHealth >= 0) {
                    if(n % 2 == 0) {
                        this.attack(this.chance = 0);
                    } else {
                        this.attack(this.chance = 1);
                    }
                    if(this.heroHealth <= 0) {
                        this.heroHealth = 0;
                        this.comment({
                            view: '<font color="red"><i>' + this.heroName+ ' ' + '</i>' +'Dead</font>',
                            heroLife: this.heroHealth,
                            villainLife: this.villainHealth
                        });
                        this.showCommentary();
                        break;
                    } else if(this.villainHealth <= 0) {
                        this.villainHealth = 0;
                        this.comment({
                            view: '<font color="red"><i>' + this.villainName + '</i>'+ ' ' +'Dead</font>',
                            heroLife: this.heroHealth,
                            villainLife: this.villainHealth
                        });
                        this.showCommentary();
                        break;
                    } else {
                        this.comment({
                            view: this.heroName +" Health " + this.heroHealth +" "+ this.villainName +" Health " + this.villainHealth,
                            heroLife: this.heroHealth,
                            villainLife: this.villainHealth
                        });
                    }
                    n++;
                }
            } else {
                this.comment({
                    view: '<font color="green"><i>' +this.villainName  + '</i>' +' won the toss</font>',
                    heroLife: this.heroHealth,
                    villainLife: this.villainHealth
                });
                while(this.heroHealth >= 0 && this.villainHealth >= 0) {
                    if(n % 2 != 0) {
                        this.attack(this.chance = 0);
                    } else {
                        this.attack(this.chance = 1);
                    }
                    if(this.heroHealth <= 0	) {
                        this.heroHealth = 0;
                        this.comment({
                            view: '<font color="red"><i>' + this.heroName+ ' ' + '</i>' +'Dead</font>',
                            heroLife: this.heroHealth,
                            villainLife: this.villainHealth
                        });
                        this.showCommentary();
                        break;
                    }else if(this.villainHealth <= 0) {
                        this.villainHealth = 0;
                        this.comment({
                            view: '<font color="red"><i>' + this.villainName + '</i>'+ ' ' +'Dead</font>',
                            heroLife: this.heroHealth,
                            villainLife: this.villainHealth
                        });
                        this.showCommentary();
                        break;
                    } else {
                        this.comment({
                            view: '<i>' + this.heroName + '</i>' + " Health " + this.heroHealth +", "+ '<i>' + this.villainName + '</i>' + " Health " + this.villainHealth,
                            heroLife: this.heroHealth,
                            villainLife: this.villainHealth
                        });
                    }
                    n++;
                }
            }
        },
        attack : function () {
            var max = this.powers.length;//Total number of powers present
            var min = 0;
            this.defence = Math.floor(Math.random() * 2);
            var weaponChoice = Math.floor(Math.random() * (max - min) + min);
            this.weaponDamage = this.powers[weaponChoice].damage;
            this.weaponName = this.powers[weaponChoice].power_name;
            if (this.chance == 0) {
                if (this.defence == 0) {
                    this.shield(this.defence = 0);//Shield is on for Villain
                } else {
                    this.villainHealth = this.villainHealth - this.weaponDamage;
                    this.comment({
                        view: '<i>' + this.heroName + '</i>' + '<font color="red"> hit</font> ' +'<i>'+ this.villainName+'</i>' + ' with ' + '<b>' + this.weaponName +'</b>',
                        heroLife: this.heroHealth,
                        villainLife: this.villainHealth
                    });
                }
            } else {
                if (this.defence == 0) {
                    this.shield(this.defence = 1);//Shield is on for Hero
                } else {
                    this.heroHealth = this.heroHealth - this.weaponDamage;
                    this.comment({
                        view: '<i>' + this.villainName +'</i>' + '<font color="red"> hit</font> ' +'<i>'+ this.heroName+'</i>' + ' with ' + '<b>' + this.weaponName +'</b>',
                        heroLife: this.heroHealth,
                        villainLife: this.villainHealth
                    });
                }
            }
        },
        shield : function () {
            if(this.defence==0) {
                this.villainHealth = this.villainHealth - (this.weaponDamage * 0.2);
                this.comment({
                    view: '<i>'+this.heroName+'</i>' + '<font color="red"> hit</font> '+'<i>'+ this.villainName+'</i>' +' with ' + '<b>' + this.weaponName + '</b>',
                    heroLife: this.heroHealth,
                    villainLife: this.villainHealth
                });
                if(this.villainHealth < 0) {
                    this.villainHealth = 0;
                    this.comment({
                        view: '<i>'+this.villainName+'</i>' +'<font color="green"> shield </font>attack of '+'<i>'+ this.heroName+'</i>' + ' but got a knick'+ ' ' +this.villainHealth,
                        heroLife: this.heroHealth,
                        villainLife: this.villainHealth
                    });
                } else {
                    this.comment({
                        view: '<i>'+this.villainName+'</i>' +'<font color="green"> shield</font> attack of '+'<i>'+ this.heroName+'</i>' + ' but got a knick'+ ' ' +this.villainHealth,
                        heroLife: this.heroHealth,
                        villainLife: this.villainHealth
                    });
                }
            } else {
                this.heroHealth = this.heroHealth - (this.weaponDamage * 0.2);
                this.comment({
                    view: this.villainName+'<font color="red"> hit</font> '+this.heroName+ ' with ' + '<b>' + this.weaponName + '</b>',
                    heroLife: this.heroHealth,
                    villainLife: this.villainHealth
                });
                if(this.heroHealth < 0) {
                    this.heroHealth = 0;
                    this.comment({
                        view: '<i>'+this.heroName+'</i>' +'<font color="green"> shield</font> attack of '+'<i>'+ this.villainName+'</i>' +' but got a knick'+ ' ' +this.heroHealth,
                        heroLife: this.heroHealth,
                        villainLife: this.villainHealth
                    });
                } else {
                    this.comment({
                        view: '<i>'+this.heroName+'</i>' +'<font color="green"> shield</font> attack of '+'<i>'+ this.villainName+'</i>' +' but got a knick'+ ' ' +this.heroHealth,
                        heroLife: this.heroHealth,
                        villainLife: this.villainHealth
                    });
                }
            }
        },
        clear : function () {
            this.commentary = [];
            this.narration = [];
            return true;
        },
        comment : function (a) {
            this.narration.push(a);
            return true;
        },
        showCommentary() {
            let that =  this;
            if(this.narration.length > 0 ) {
                let comments = this.narration[0];
                this.heroLife = comments.heroLife;
                this.villainLife = comments.villainLife;
                this.commentary.push(comments);
                this.narration.splice(0,1);
                setTimeout(function () {
                    that.showCommentary();
                },1000);
            }
            return true;
        }
    }
}
</script>