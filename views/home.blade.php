@extends('layouts.layout')

@section('title', 'Jeux')


@section('content')
    <div role="search" class="searchbar">
        <input type="text" id="search_coachs" placeholder="RECHERCHER UN JEU OU UN COACH">
        <select>
            <option>JEU</option>
            <option>COACH</option>
        </select>
    </div>
    <h1 class="title">BIENVENUE SUR THE LAG !</h1>
    <div class="container">
        <p>Vide, quantum, inquam, fallare, Torquate. oratio me istius philosophi non offendit; nam et complectitur verbis, quod vult, et dicit plane, quod intellegam; et tamen ego a philosopho, si afferat eloquentiam, non asperner, si non habeat, non admodum flagitem. re mihi non aeque satisfacit, et quidem locis pluribus. sed quot homines, tot sententiae; falli igitur possumus.
        Dum apud Persas, ut supra narravimus, perfidia regis motus agitat insperatos, et in eois tractibus bella rediviva consurgunt, anno sexto decimo et eo diutius post Nepotiani exitium, saeviens per urbem aeternam urebat cuncta Bellona, ex primordiis minimis ad clades excita luctuosas, quas obliterasset utinam iuge silentium! ne forte paria quandoque temptentur, plus exemplis generalibus nocitura quam delictis. Nepotiani exitium, saeviens per urbem aeternam urebat cuncta Bellona, ex primordiis minimis ad clades excita luctuosas, quas obliterasset utinam iuge silentium! ne forte paria quandoque temptentur, plus exemplis generalibus nocitura quam delictis.</p>
    </div>
    <div id="home-main">
        <div class="home-pic">
        </div>
        <div class="home-pic">
        </div>
        <div class="home-pic">
        </div>
    </div>
    <footer>
        <h1>ILS NOUS ONT REJOINT</h1>
        <img class="footer-pic"/>
        <img class="footer-pic"/>
        <img class="footer-pic"/>
        <img class="footer-pic"/>
    </footer>
@endsection