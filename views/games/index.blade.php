@extends('layouts.test')

@section('title', 'Jeux')

@section('content')
    <div role="search" class="searchbar">
        <input type="text" id="search_games" placeholder="RECHERCHER UN JEU">
    </div>
    <div class="box">
        <ul>
        @forelse ($games as $game)
            @component('components.gamecard',['game'=>$game])
            @endcomponent
        @empty
            <p>Aucun jeu disponible</p>
        @endforelse
        </ul>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('#search_games');
            const list = document.querySelector('.box ul');

            const searchGames =  async e => {
                e.preventDefault();
                if (e.keyCode === 13) {
                    const formData = new FormData();
                    formData.append('search', searchInput.value);

                    try {
                        const response = await fetch(window.location.origin + '/game/search', {
                            method: 'POST',
                            mode:"cors",
                            body : formData
                        });
                        if (response.ok) {
                            const data = await response.json();
                            list.innerHTML = '';
                            data.response.forEach(game => {
                                list.innerHTML += `
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
                            console.error(response.status);
                        }
                    } catch(e) {
                        console.error(e);
                    }
                }
            };


            searchInput.addEventListener('keyup', e => searchGames(e))
        })
    </script>
@endsection