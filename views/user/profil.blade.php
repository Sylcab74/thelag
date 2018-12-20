@extends('layouts.layout')

@section('title', $user->login)

@section('content')

    <section class="profil">
        <div class="profil_container">
            <img src="{{$user->picture}}" alt="{{$user->login}}" class="profil_container__picture">
            <div class="profil_container__informations">
                <a href="/user/update/{{$user->id}}"><img src="../../public/img/edit.png" alt="Edit profil" class="edit_button"/></a>
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
        <h2>Mes jeux</h2>
        <ul>
            @foreach($games as $game)
                @component('components.gamecard',['game'=>$game]) @endcomponent
            @endforeach
        </ul>
    </section>
    <section class="calendar">
        <h2>Mes disponibilités</h2>
        @component('components.calendar') @endcomponent
        <div class="availability_container">
            <h2>Disponibilités</h2>
            <form id="formAvailability">
                <label for="start">Début</label>
                <input type="date" name="start_date">
                <input type="time" name="start_hour"><br>
                <label for="duration">Fin</label>
                <input type="date" name="end_date">
                <input type="time" name="end_hour"><br>
                <input type="hidden" name="user" value="2">
                <input type="submit">
            </form>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            const hours = [...Array(24).keys()];

            const dateButton = document.querySelector('.button-availability h3');
            const formAvailability= document.querySelector("#formAvailability");
            const containerTable = document.querySelector('#table');
            const previous = document.querySelector('#previous');
            const next = document.querySelector('#next');
            const user = document.querySelector('input[type="hidden"]');

            const changeWeek = async elem => {
                const table = document.querySelector('table');
                const first = table.dataset.first;
                const month = table.dataset.month;
                const last = parseInt(first) + 6;

                const action = elem.textContent === '>' ? 'next' : 'previous';
                const numberDays = [...Array(8).keys()];

                const fd = new FormData();

                fd.append('action', action);
                fd.append('user', user.value);
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
                        const { calendar, start : newFirst, month, end } = data.response;
                        const start = numberDays.map(day => parseInt(day) + parseInt(Object.keys(calendar)[0]));
                        start.pop();

                        containerTable.innerHTML = "";
                        dateButton.textContent = `Du ${newFirst.split('-')[0]} au ${parseInt(end.split('-')[0])}`;

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
                                } else if (calendar[start[index-1]+'-'+month] !== undefined && calendar[start[index-1]+'-'+month][indexHours] === "session") {
                                    return `<td class="session"></td>`;
                                } else if (calendar[start[index-1]+'-'+month] !== undefined && calendar[start[index-1]+'-'+month][indexHours] !== false) {
                                    return `<td data-id="${calendar[start[index-1]+'-'+month][indexHours]}" class="availability"></td>`;
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

                try {
                    const response = await fetch(window.location.origin + '/availability/create', {
                        method: 'POST',
                        mode: "cors",
                        body: formData
                    });

                    if (response.ok) {
                        const data = await response.json();
                        consoel.log(data);
                    } else {
                        console.error(response.status);
                    }
                } catch(e) {
                    console.error(e);
                }
            };

            formAvailability.addEventListener('submit', e => addSession(e, formAvailability));
            previous.addEventListener('click', () => changeWeek(previous));
            next.addEventListener('click', () => changeWeek(next));
        })
    </script>
@endsection