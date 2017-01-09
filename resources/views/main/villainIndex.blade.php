<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>T.A.R.S.| Villain</title>
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
                <li><a href="{{route('hero.index')}}">Hero <span class="sr-only">(current)</span></a></li>
                <li class="active"><a href="{{route('villain.index')}}">Villain</a></li>
                <li><a href="{{route('match.index')}}">Match</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="villains">
    <button @click="seen = !seen">Add Villain</button>
    <div v-if="seen">
        <input v-model="newVillains" placeholder="Add New Villain"><br>
        <input v-model="name" placeholder="Add Name of Villain"><br>
        <input v-model="company" placeholder="Add Company"><br>
        <input v-model="partner" placeholder="Add partner/girlfriend/spouse"><br>
        <input v-model="rival" placeholder="Add Arch Rival">
        <button @click="add">Submit</button>
    </div>
    <ol>
        <li v-for="(antiheroes,index) in antiHero" v-cloak>
            @{{ antiheroes.actor }}
            <div v-show="antiheroes.detail">
                Name        : @{{ antiheroes.name }}.<br>
                Company     : @{{ antiheroes.company }}.<br>
                Partner     : @{{ antiheroes.partner }}.<br>
                Rival       : @{{ antiheroes.rival }}.
            </div>
            <button @click="antiheroes.detail = !antiheroes.detail">@{{(antiheroes.detail)?'Hide Detail':'Detail' }}</button>
            <button v-on:click="removeVillain(index)">Delete</button>
        </li>
    </ol>
</div>
<script src = "bootstrap/js/jQuery-2.2.0.min.js"></script>
<script src = "bootstrap/js/bootstrap.js"></script>
<script src= "js/vue.js"></script>
<script>
    var villains = new Vue({
        el: '#villains',
        data: {
            newVillains: '',
            name: '',
            company: '',
            partner: '',
            rival: '',
            seen: false,
            antiHero: [
                {   actor:'Lex Luthor',
                    detail : false,
                    name: 'Lex Luthor',
                    company: 'Lex Corp',
                    partner: 'Leticia',
                    rival: 'Superman'
                },
                {   actor:'Joker',
                    detail : false,
                    name: 'Joker',
                    company: 'Arkham Asylum',
                    partner: 'Harley Quin',
                    rival: 'Batman'
                },
                {   actor:'Cheetah',
                    detail : false,
                    name: 'Priscilla Rich',
                    company: 'Villainy Inc.',
                    partner: 'Steve Trevor',
                    rival: 'Wonder Woman'
                },
                {   actor:'Obadiah Stane',
                    detail : false,
                    name: 'Obadiah Stane',
                    company: 'Stark Industry',
                    partner: 'Madame Masque',
                    rival: 'Iron Man'
                },
                {   actor:'Abomination',
                    detail : false,
                    name: 'Emil Blonsky',
                    company: 'KGB',
                    partner: 'No Partner',
                    rival: 'Hulk'
                },
                {   actor:'Loki',
                    detail: false,
                    name: 'Loki Laufeyson',
                    company: 'Cabal',
                    partner: 'Sigyn',
                    rival: 'Thor'
                },
                {   actor:'Red Skull',
                    detail: false,
                    name: 'Johann Shmidt',
                    company: 'Hydra',
                    partner: 'Sinthea Shmidt',
                    rival: 'Captain America'
                },
                {   actor:'Mordo',
                    detail: false,
                    name: 'Baron Mordo',
                    company: 'Legion Accursed',
                    partner: 'Ancient One',
                    rival: 'Doctor Strange'
                },
                {   actor:'Vulture',
                    detail: false,
                    name: 'Adrian Toomes',
                    company: 'Toomes Corp',
                    partner: 'No Partner',
                    rival: 'Spider-Man'
                },
                {   actor:'Reverse Flash',
                    detail: false,
                    name: 'Eobard Thawne',
                    company: 'Star Labs',
                    partner: 'Nora',
                    rival: 'Flash'
                }
            ]
        },
        methods: {
            add: function () {
                this.antiHero.push({ actor: this.newVillains,
                                     detail: false,
                                     name: this.name,
                                     company: this.company,
                                     partner: this.partner,
                                     rival: this.rival
                });
                this.newVillains = this.name = this.company = this.partner = this.rival = '';
                this.seen = false;
            },
            removeVillain: function (item) {
                this.antiHero.splice(item,1);
            }
        }
    })
</script>
</body>
</html>
