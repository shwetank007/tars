<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>T.A.R.S.| Hero</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<style>
    [v-cloak] {
        display: none;
    }
</style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">T.A.R.S.</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{route('hero.index')}}">Hero <span class="sr-only">(current)</span></a></li>
                <li><a href="{{route('villain.index')}}">Villain</a></li>
                <li><a href="{{route('match.index')}}">Match</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="example-2">
    <child message="hello!"></child>
</div>
<!-- <div id="heros"> -->
<!--     <button @click="seen = !seen">Add Hero</button>
    <div v-if="seen">
        <input v-model="newHeroes" placeholder="Add New Superhero"><br>
        <input v-model="name" placeholder="Add Name of Superhero"><br>
        <input v-model="weakness" placeholder="Add weakness"><br>
        <input v-model="partner" placeholder="Add partner/girlfriend/spouse"><br>
        <input v-model="rival" placeholder="Add Arch Rival">
        <button @click="add">Submit</button>
    </div>
    <ol>
        <li v-for="(hero,index) in heroes" v-cloak>
            @{{ hero.actor }}
            <div v-show="hero.detail">
                Name        : @{{ hero.name }}.<br>
                Weakness    : @{{ hero.weakness }}.<br>
                Partner     : @{{ hero.partner }}.<br>
                Rival       : @{{ hero.rival }}.
            </div>
            <button @click="hero.detail = !hero.detail">@{{(hero.detail)?'Hide Detail':'Detail' }}</button>
            <button v-on:click="removeHero(index)">Delete</button>
        </li>
    </ol> -->
<!-- </div> -->
<script src = "bootstrap/js/jQuery-2.2.0.min.js"></script>
<script src = "bootstrap/js/bootstrap.js"></script>
<script src= "js/vue.js"></script>
<script src= "">
<script>
Vue.component('child', {
  // declare the props
  props: ['message'],
  // just like data, the prop can be used inside templates
  // and is also made available in the vm as this.message
  template: '<span>@{{ message }}</span>'
})
new Vue({
  el: '#example-2'
})


//    new Vue({
//        el: '#heros'
//        data: {
//            newHeroes: '',
//            name: '',
//            weakness: '',
//            partner: '',
//            rival: '',
//            seen: false,
//            heroes: [
//                {   actor:'Superman',
//                    detail : false,
//                    name: 'Clarke Kent',
//                    weakness: 'Kryptonite',
//                    partner: 'Louise Lane',
//                    rival: 'Lex Luthor'
//                },
//                {   actor:'Batman',
//                    detail : false,
//                    name: 'Bruce Wayne',
//                    weakness: 'Nothing',
//                    partner: 'Rachel Dawson',
//                    rival: 'Joker'
//                },
//                {   actor:'Wonder Woman',
//                    name: 'Diana',
//                    detail : false,
//                    weakness: 'Never back down from fight',
//                    partner: 'Steve Trevor',
//                    rival: 'Cheetah'
//                },
//                {   actor:'Iron Man',
//                    name: 'Tony Stark',
//                    detail : false,
//                    weakness: 'Pride',
//                    partner: 'Pepper Potts',
//                    rival: 'Obadiah Stane'
//                },
//                {   actor:'Hulk',
//                    detail:false,
//                    name: 'Bruce Banner',
//                    weakness: 'Nothing',
//                    partner: 'Betty Ross',
//                    rival: 'Abomination'
//                },
//                {   actor:'Thor',
//                    detail:false,
//                    name: 'Thor',
//                    weakness: 'Pride',
//                    partner: 'Jane Foster',
//                    rival: 'Loki'
//                },
//                {   actor:'Captain America',
//                    detail:false,
//                    name: 'Steve Rogers',
//                    weakness: 'Nothing',
//                    partner: 'Agent Carter',
//                    rival: 'Red Skull'
//                },
//                {   actor:'Doctor Strange',
//                    detail:false,
//                    name: 'Stephen Strange',
//                    weakness: 'Obsessed',
//                    partner: 'Christine Palmer',
//                    rival: 'Mordo'
//                },
//                {   actor:'Spider-Man',
//                    detail:false,
//                    name: 'Peter Parker',
//                    weakness: 'Family',
//                    partner: 'Christine Palmer',
//                    rival: 'Mordo'
//                },
//                {   actor:'Flash',
//                    detail:false,
//                    name: 'Barry Allen',
//                    weakness: 'Instantaneous',
//                    partner: 'Iris West',
//                    rival: 'Reverse Flash'
//                }
//            ]
//        },
//        methods: {
//            add: function () {
//                this.heroes.push({  actor: this.newHeroes,
//                                    detail: false,
//                                    name: this.name,
//                                    weakness: this.weakness,
//                                    partner: this.partner,
//                                    rival: this.rival
//                });
//                this.newHeroes = this.name = this.weakness = this.partner = this.rival = '';
//                this.seen = false;
//            },
//            removeHero: function (item) {
//                this.heroes.splice(item,1);
//            }
//        }
//    });


</script>
</body>
</html>

