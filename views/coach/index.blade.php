@extends('layouts.test')

@section('title', 'Coachs')


@section('content')
    <h2>Les coachs</h2>
    <input type="text" id="search_coachs">
    <div class="box">
        <ul>
            @forelse ($users as $user)
                <li><a href="/coach/show/{{ $user->id }}">{{ $user->firstname }}</a></li>
            @empty
                <p>Aucun utilisateur n'a été créé</p>
            @endforelse
        </ul>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('#search_coachs');
            const list = document.querySelector('.box ul');

            const searchGames =  async e => {
                e.preventDefault();
                if (e.keyCode === 13) {
                    const formData = new FormData();
                    formData.append('search', searchInput.value);

                    try {
                        const response = await fetch(window.location.origin + '/coach/search', {
                            method: 'POST',
                            mode:"cors",
                            body : formData
                        });

                        if (response.ok) {
                            const data = await response.json();
                            list.innerHTML = '';
                            data.response.forEach(user => {
                                /*list.innerHTML += `
                                    <a href="game/show/${.id}">
                                        <li class="li_game">
                                            <img class="img_game" src="${ game.picture }" alt="${ game.name }" /> <br>
                                            <h2>${game.name}</h2>
                                            <p>${game.type}</p>
                                        </li>
                                    </a>
                                `;*/
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