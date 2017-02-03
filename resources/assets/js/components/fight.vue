<style>
    .comment{
        margin-top: 45px;
        text-align: center;
    }
</style>
<template>
    <div class="page-wrap">
        <div class="container matches">
            <div class="col-md-2 set">
                <div class="left">
                    <img :src="'images/'+match.hero.avatar" height="120px" width="120px" style="border-radius: 50%;"><br>
                    {{match.hero.actor}}
                </div>
            </div>
            <div class="col-md-8 comment">
                <ol style="list-style-type: none">
                    <li v-for="(comment,index) in commentary">
                        {{comment}}
                    </li>
                </ol>
            </div>
            <div class="col-md-2 set">
                <div class="right">
                    <img :src="'images/'+match.villain.avatar" height="120px" width="120px" style="border-radius: 50%;"><br>
                    {{match.villain.actor}}
                </div>
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
            narration: [],
            commentary: [],
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
            this.comment('Match Start');
            this.toss();
        },
        toss : function () {
            var tossWin = Math.floor(Math.random() * 2);
            var n = 0;
            if(tossWin == 0) {
                this.comment(this.heroName +' win the toss');
                this.comment(this.heroName +' Health '+ 100 + ', '+ this.villainName +' Health '+ 100);
                while(this.heroHealth >= 0 && this.villainHealth >= 0) {
                    if(n % 2 == 0) {
                        this.attack(this.chance = 0);
                    } else {
                        this.attack(this.chance = 1);
                    }
                    if(this.heroHealth <= 0) {
                        this.heroHealth = 0;
                        this.comment(this.heroName +' Dead');
                        this.showCommentary();
                        break;
                    } else if(this.villainHealth <= 0) {
                        this.villainHealth = 0;
                        this.comment(this.villainName +' Dead');
                        this.showCommentary();
                        break;
                    } else {
                        this.comment(this.heroName +" Health " + this.heroHealth +" "+ this.villainName +" Health " + this.villainHealth);
                    }
                    n++;
                }
            } else {
                this.comment(this.villainName +' Win the toss');
                this.comment(this.heroName +' Health '+ 100 + ', ' +this.villainName+' Health '+ 100);
                while(this.heroHealth >= 0 && this.villainHealth >= 0) {
                    if(n % 2 != 0) {
                        this.attack(this.chance = 0);
                    } else {
                        this.attack(this.chance = 1);
                    }
                    if(this.heroHealth <= 0	) {
                        this.heroHealth = 0;
                        this.comment(this.heroName +' Dead');
                        this.showCommentary();
                        break;
                    }else if(this.villainHealth <= 0) {
                        this.villainHealth = 0;
                        this.comment(this.villainName +' Dead');
                        this.showCommentary();
                        break;
                    } else {
                        this.comment(this.heroName + " Health " + this.heroHealth +", "+ this.villainName + " Health " + this.villainHealth);
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
                    this.comment(this.heroName + ' hit ' + this.villainName + ' with ' + this.weaponName);
                    this.villainHealth = this.villainHealth - this.weaponDamage;
                }
            } else {
                if (this.defence == 0) {
                    this.shield(this.defence = 1);//Shield is on for Hero
                } else {
                    this.comment(this.villainName + ' hit ' + this.heroName + ' with ' + this.weaponName);
                    this.heroHealth = this.heroHealth - this.weaponDamage;
                }
            }
        },
        shield : function () {
            if(this.defence==0) {
                this.villainHealth = this.villainHealth - (this.weaponDamage * 0.2);
                this.comment(this.heroName + ' hit '+ this.villainName +' with ' + this.weaponName);
                if(this.villainHealth < 0) {
                    this.villainHealth = 0;
                    this.comment(this.villainName +' shield attack of '+this.heroName+ ' but got a knick'+ ' ' +this.villainHealth);
                } else {
                    this.comment(this.villainName +' shield attack of '+this.heroName+ ' but got a knick'+ ' ' +this.villainHealth);
                }
            } else {
                this.heroHealth = this.heroHealth - (this.weaponDamage * 0.2);
                this.comment(this.villainName+' hit '+this.heroName+ ' with ' + this.weaponName);
                if(this.heroHealth < 0) {
                    this.heroHealth = 0;
                    this.comment(this.heroName +' shield attack of '+this.villainName +' but got a knick'+ ' ' +this.heroHealth);
                } else {
                    this.comment(this.heroName +' shield attack of '+this.villainName +' but got a knick'+ ' ' +this.heroHealth);
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
            if(this.narration.length > 0) {
                var comments = this.narration[0];
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