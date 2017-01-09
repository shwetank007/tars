<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>T.A.R.S.| Match</title>
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
                <li><a href="{{route('villain.index')}}">Villain</a></li>
                <li class="active"><a href="{{route('match.index')}}">Match</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="matches">
    <button @click="seen = !seen">Add Match</button>
    <div v-if="seen">
        <select v-model="superhero">
            <option>Superman</option>
            <option>Batman</option>
            <option>Wonder Woman</option>
            <option>Iron Man</option>
            <option>Hulk</option>
            <option>Thor</option>
            <option>Captain America</option>
            <option>Doctor Strange</option>
            <option>Spider-Man</option>
            <option>Flash</option>
        </select>
        V/S
        <select v-model="villain">
            <option>Joker</option>
            <option>Lex Luthor</option>
            <option>Cheetah</option>
            <option>Obadiah Stane</option>
            <option>Abomination</option>
            <option>Loki</option>
            <option>Red Skull</option>
            <option>Mordo</option>
            <option>Vulture</option>
            <option>Reverse Flash</option>
        </select><br>
        <textarea v-model="cause" placeholder="Add Cause of Match"></textarea><br>
        <input v-model="place" placeholder="Add place of match">
        <button @click="add">Submit</button>
    </div>
    <ol>
        <li v-for="(match,index) in matchs" v-cloak>
            @{{ match.actor }}
            <div v-show="match.detail">
                Cause       : @{{ match.cause }}.<br>
                Place       : @{{ match.place }}.
            </div>
            <button @click="match.detail = !match.detail">@{{(match.detail)?'Hide Detail':'Detail' }}</button>
            <button v-on:click="removeMatch(index)">Delete</button>
        </li>
    </ol>
</div>
<script src = "bootstrap/js/jQuery-2.2.0.min.js"></script>
<script src = "bootstrap/js/bootstrap.js"></script>
<script src= "js/vue.js"></script>
<script>
    var matches = new Vue({
        el: '#matches',
        data: {
            superhero: '',
            villain: '',
            cause: '',
            place: '',
            seen: false,
            matchs: [
                {   actor: 'Superman vs Lex Luthor',
                    detail: false,
                    cause: 'Luthor want a world without superman',
                    place: 'Metropolis'
                },
                {   actor:'Batman vs Joker',
                    detail: false,
                    cause: 'Joker kidnapped Robin and now he is threating to kill him',
                    place: 'Gotham City'
                },
                {   actor:'Wonder Woman vs Cheetah',
                    detail: false,
                    cause: 'Causing trouble in Themyscira',
                    place: 'Themyscira'
                },
                {   actor:'Iron Man vs Obadiah Stane',
                    detail: false,
                    cause: 'Obadiah want to kill Tony in order to takeover stark industry',
                    place: 'Malibu'
                },
                {   actor:'Hulk vs Abomination',
                    detail: false,
                    cause: 'Abomination threaten Hulk to kill his girlfriend in order to prove himself supreme over hulk',
                    place: 'New York City'
                },
                {   actor:'Thor vs Loki',
                    detail: false,
                    cause: 'Loki finds out truth about himself now he wants to kill is half brother in order to become emperor of Asgard',
                    place: 'Asgard'
                },
                {   actor:'Captain America vs Red Skull',
                    detail: false,
                    cause: 'Captain America stops Red Skull to stop Hydra spreading terror all over the globe',
                    place: 'Asgard'
                },
                {   actor:'Doctor Strange vs Mordo',
                    detail: false,
                    cause: 'Mordo want to destroy the world and make the world to start worshipping Dormamu, the evil god',
                    place: 'Japan, New York City, London'
                },
                {   actor:'Spider-Man vs Vulture',
                    detail: false,
                    cause: 'Threatens to level entire New York City. Friendly Neighbourhood Spidey comes to rescue',
                    place: 'Queen, New York City'
                },
                {   actor:'Flash vs Reverse Flash',
                    detail: false,
                    cause: 'Challanged Barry to change his past and start flashpoint paradox',
                    place: 'Star City'
                }
            ]
        },
        methods: {
            add: function () {
                this.matchs.push({ actor: this.superhero + ' ' +  'vs' + ' ' + this.villain,
                                   detail: false,
                                   cause: this.cause,
                                   place: this.place
                });
                this.cause = this.place = this.superhero = this.villain = '';
                this.seen = false;
            },
            removeMatch: function (item) {
                this.matchs.splice(item,1)
            }
        }
    })
</script>
</body>
</html>
