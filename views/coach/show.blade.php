@extends('layouts.test')

@section('title', 'Le titre')

@section('content')
    <h1>{{$user->login}}</h1>
    <h2>{!! $user->firstname !!}</h2>
    @component('components.calendar') @endcomponent

    <h2>Mes jeux</h2>
    <ul>
        @foreach($user->games as $game)
            @component('components.gamecard',['game'=>$game]) @endcomponent    
        @endforeach
    </ul>
    <div class="alert" id="alert">
        <div class="alert_container">
            <h2>Réservation</h2>
            <form>
                <label for="start">Début</label>
                <select name="start" id="start"></select><br>
                <label for="duration">Durée</label>
                <select name="duration" id="duration"></select><br>
                <label for="comments">Commentaires</label>
                <textarea name="comments" id="comments" cols="30" rows="10"></textarea><br>
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
            const containerTable = document.querySelector('#table');
            const previous = document.querySelector('#previous');
            const next = document.querySelector('#next');
            const availabilities = document.querySelectorAll('.availability');
            const alert = document.querySelector('#alert');

            const changeWeek = async elem => {
                const table = document.querySelector('table');
                const url = window.location.href.split('/');
                const user = url[url.length-1];
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
                        containerTable.innerHTML = `
                        <table data-first="${newFirst}" data-month="${month}">
                            <tbody>
                                <tr>
                                    <th></th>
                                    ${Object.keys(calendar).map((elem, index) => {
                                        let date = elem.split('-');
                                        return `<th>${days[index]} ${date[0]}</th>`;
                                    })}
                                </tr>
                                ${hours.map((hour, indexHours) => {
                                    return (`<tr>
                                            ${numberDays.map((elem, index) => {                                            
                                                if (index == 0) {
                                                    return `<td>${hour}</td>`;
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

            const addSession = async elem => {
                const id = elem.dataset.id;
                alert.style.display = 'flex';
                try {
                    const response = await fetch(window.location.origin + '/availability/getAvailability/' + id);
                    if (response.ok){
                        const data = await response.json();
                        console.log(data);
                    } else {
                        console.error(response.status);
                    }
                } catch(e) {
                    console.error(e);
                }
            };

            availabilities.forEach(elem => elem.addEventListener('click', () => addSession(elem)));
            previous.addEventListener('click', () => changeWeek(previous));
            next.addEventListener('click', () => changeWeek(next));
        })
    </script>
@endsection