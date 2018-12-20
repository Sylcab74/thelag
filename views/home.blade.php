@extends('layouts.layout')

@section('title', 'Accueil')

@section('content')
    <div role="search" class="searchbar">
        <form id="searchGamesCoach">
            <input type="text" class="search_home" id="search" placeholder="RECHERCHER UN JEU OU UN COACH">
            <select id="filter">
                <option value="jeu">JEU</option>
                <option value="coach">COACH</option>
            </select>
        </form>
    </div>
    <h1 class="title">BIENVENUE SUR THE LAG !</h1>
    <div class="container">
        <p>Vide, quantum, inquam, fallare, Torquate. oratio me istius philosophi non offendit; nam et complectitur verbis, quod vult, et dicit plane, quod intellegam; et tamen ego a philosopho, si afferat eloquentiam, non asperner, si non habeat, non admodum flagitem. re mihi non aeque satisfacit, et quidem locis pluribus. sed quot homines, tot sententiae; falli igitur possumus.
        Dum apud Persas, ut supra narravimus, perfidia regis motus agitat insperatos, et in eois tractibus bella rediviva consurgunt, anno sexto decimo et eo diutius post Nepotiani exitium, saeviens per urbem aeternam urebat cuncta Bellona, ex primordiis minimis ad clades excita luctuosas, quas obliterasset utinam iuge silentium! ne forte paria quandoque temptentur, plus exemplis generalibus nocitura quam delictis. Nepotiani exitium, saeviens per urbem aeternam urebat cuncta Bellona, ex primordiis minimis ad clades excita luctuosas, quas obliterasset utinam iuge silentium! ne forte paria quandoque temptentur, plus exemplis generalibus nocitura quam delictis.</p>
    </div>
    <div id="home-main">
            <img class="home-pic" src="../../public/img/img1.jpg" alt="The Lag"/>
            <img class="home-pic" src="../../public/img/img2.jpg" alt="The Lag"/>
            <img class="home-pic" src="../../public/img/img3.jpg" alt="The Lag"/>
        
    </div>
    <div class="partnership">
        <h1>ILS NOUS ONT REJOINT</h1>
        <img class="footer-pic" src="../../public/img/logo1.png" alt="logo1"/>
        <img class="footer-pic" src="../../public/img/logo2.png" alt="logo2"/>
        <img class="footer-pic" src="../../public/img/logo3.png" alt="logo3"/>
        <img class="footer-pic" src="../../public/img/logo4.png" alt="logo4"/>
    </div>
    <div>
        <ul id="searchResult">

        </ul>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filter = document.querySelector('#filter');
            const inputSearch = document.querySelector('#search');
            const searchGamesCoach = document.querySelector('#searchGamesCoach');
            const searchResult = document.querySelector('#searchResult');

            const search = async (e, form) => {
                e.preventDefault();

                if (e.keyCode === 13) {
                    const formData = new FormData(form);
                    formData.append('action', filter.value);
                    formData.append('search', inputSearch.value);

                    try {
                        const response = await fetch(window.location.origin + '/index/search', {
                            method: 'POST',
                            mode:"cors",
                            body : formData
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if (filter.value === "jeu") {
                                data.response.forEach(game => {
                                    searchResult.innerHTML += `
                                    <a href="game/show/${game.id}">
                                        <li class="li_game">
                                            <img class="img_game" src="${ game.picture }" alt="${ game.name }" /> <br>
                                            <h2>${game.name}</h2>
                                            <p>${game.type}</p>
                                        </li>
                                    </a>
                                `;
                                })
                            } else {
                                data.response.forEach(user => {
                                    searchResult.innerHTML += `
                                        <a href="/coach/show/${user.id}">
                                        <li class="li_game">
                                            <img class="img_game" src="${user.picture}" alt="${user.login}" /> <br>
                                            <h2>${user.login}</h2>
                                            <p>${user.price}€/h</p>
                                        </li>
                                    </a>
                                    `
                                });
                            }
                        } else {
                            console.error(response.status);
                        }
                    } catch(e) {
                        console.error(e);
                    }
                }
            };

            searchGamesCoach.addEventListener('submit', e =>e.preventDefault());
            inputSearch.addEventListener('keyup', e => search(e, searchGamesCoach));
        })
    </script>
@endsection