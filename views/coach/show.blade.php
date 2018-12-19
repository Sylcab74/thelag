@extends('layouts.test')

@section('title', $user->login)

@section('content')

    <section class="profil">
        <div class="profil_container">
            <img src="{{$user->picture}}" alt="{{$user->login}}" class="profil_container__picture">
            <div class="profil_container__informations">
                <h1>{{$user->login}}</h1>
                <ul>
                    <li>{{ $user->firstname }} {{ $user->lastname }}</li>
                    <li>{{ $user->email }}</li>
                </ul>
            </div>
        </div>
        <div class="profil_bio">
            <h2>Sa bio</h2>
            <p>{{ $user->biography }}</p>
        </div>
        <div class="profil_stats">
            <h2>Ses stats</h2>
            <p>{{ $user->price}}€/h</p>
        </div>
    </section>
    <section class="games">
        <h2>Ses jeux</h2>
        <ul>
            @foreach($user->games as $game)
                @component('components.gamecard',['game'=>$game]) @endcomponent
            @endforeach
        </ul>
    </section>
    <section class="calendar">
        <h2>Ses disponibilités</h2>
        @component('components.calendar') @endcomponent
    </section>
    <div class="alert" id="alert">
        <div class="alert_container">
            <h2>Réservation</h2>
            <form id="formSession">
                <label for="start">Début</label>
                <select name="start" id="start"></select><br>
                <label for="duration">Durée</label>
                <select name="duration" id="duration"></select><br>
                <label for="game">Jeux</label>
                <select name="game" id="game"></select><br>
                <label for="comments">Commentaires</label>
                <textarea name="comments" id="comments" cols="30" rows="10"></textarea><br>
                <input type="hidden" value="" name="availability">
                <input type="submit" value="Valider">
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            const hours = [...Array(24).keys()];

            const availabilityInput = document.querySelector('input[name="availability"]');
            const dateButton = document.querySelector('.button-availability h3');
            const formSession = document.querySelector("#formSession");
            const containerTable = document.querySelector('#table');
            const duration = document.querySelector('#duration');
            const previous = document.querySelector('#previous');
            const start = document.querySelector('#start');
            const alert = document.querySelector('#alert');
            const game = document.querySelector('#game');
            const next = document.querySelector('#next');

            const availabilities = document.querySelectorAll('.availability');
            const url = window.location.href.split('/');
            const user = url[url.length-1];

            const changeWeek = async elem => {
                const table = document.querySelector('table');
                const first = table.dataset.first;
                const month = table.dataset.month;
                const last = parseInt(first) + 6;

                const action = elem.textContent === '>' ? 'next' : 'previous'; 
                const numberDays = [...Array(8).keys()];
                
                const fd = new FormData();

                fd.append('action', action);
                fd.append('user', user);
                fd.append('first', first);
                fd.append('month', month);
                fd.append('last', last);
                
                try {
                    const response = await fetch(window.location.origin + '/coach/changeWeek', {
                        method: 'POST',
                        mode:"cors",
                        body : fd
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        const { calendar, start : newFirst, month } = data.response;
                        const start = numberDays.map(day => parseInt(day) + parseInt(Object.keys(calendar)[0]));
                        start.pop();


                        containerTable.innerHTML = "";
                        dateButton.textContent = `Du ${newFirst.split('-')[0]} au ${parseInt(newFirst.split('-')[0]) + 6}`;

                        containerTable.innerHTML = `
                        <table data-first="${newFirst}" data-month="${month}">
                            <tbody>
                                <tr>
                                    <th></th>
                                    ${Object.keys(calendar).map((elem, index) => {
                                        return `<th>${days[index]} </th>`;
                                    })}
                                </tr>
                                ${hours.map((hour, indexHours) => {
                                    return (`<tr>
                                            ${numberDays.map((elem, index) => {                                            
                                                if (index == 0) {
                                                    return `<td>${hour}h00</td>`;
                                                } else if (calendar[start[index-1]+'-'+month] !== undefined && calendar[start[index-1]+'-'+month][indexHours] !== false) {
                                                    return `<td style="background-color: green" data-id="${calendar[start[index-1]+'-'+month][indexHours]}" class="availability"></td>`;
                                                } else if (index === numberDays.length){
                                                    return;
                                                } else {
                                                    return `<td></td>`;
                                                }
                                            })}
                                        </tr>
                                    `)
                                })}
                            </tbody>
                        </table>`.replace(/,/g, '');
                    } else {
                        console.error(response.status);
                    }

                } catch(e) {
                    console.error(e);
                }
            };

            const addSession = async (e, form)=> {
                e.preventDefault();

                const formData = new FormData(form);
                formData.append('user', user);

                try {
                    const response = await fetch(window.location.origin + '/session/create', {
                        method: 'POST',
                        mode: "cors",
                        body: formData
                    });

                    if (response.ok) {
                        alert.style.display = 'none';
                    } else {
                        console.error(response.status);
                    }
                } catch(e) {
                    console.error(e);
                }
            };

            const getAvailabality = async elem => {
                const id = elem.dataset.id;
                alert.style.display = 'flex';

                try {
                    const response = await fetch(window.location.origin + '/availability/getAvailability/' + id);
                    if (response.ok){
                        const data = await response.json();

                        availabilityInput.value = id;
                        data.session.forEach((elem, index) => {
                            start.innerHTML += `<option value="${elem[0]}">${elem[1]}</option>`;
                            duration.innerHTML += `<option value="${index+1}" >${index+1}</option>`;
                        });
                        data.games.forEach(elem => game.innerHTML += `<option value="${elem.id}">${elem.name}</option>`)
                    } else {
                        console.error(response.status);
                    }
                } catch(e) {
                    console.error(e);
                }
            };

            /*alert.addEventListener('click', e => {
                e.stopPropagation();
                alert.style.display = "none"
            });*/

            availabilities.forEach(elem => elem.addEventListener('click', () => getAvailabality(elem)));
            formSession.addEventListener('submit', e => addSession(e, formSession));
            previous.addEventListener('click', () => changeWeek(previous));
            next.addEventListener('click', () => changeWeek(next));
        })
    </script>
@endsection