@extends('layouts.test')

@section('title', 'Le titre')

@section('content')
    <h1>{{$user->login}}</h1>
    @component('components.calendar') @endcomponent
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            const hours = [...Array(24).keys()];
            const containerTable = document.querySelector('#table');
            const previous = document.querySelector('#previous');
            const next = document.querySelector('#next');

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
                        const { calendar, start : newFirst } = data.response;
                        const start = numberDays.map(day => parseInt(day) + parseInt(Object.keys(calendar)[0]));

                        numberDays.pop()
                        containerTable.innerHTML = "";
                        containerTable.innerHTML = `
                        <table data-first="${newFirst}" data-month="12">
                            <tbody>
                                <tr>
                                    <th></th>
                                    ${Object.keys(calendar).map((elem, index) => `<th>${days[index]} ${elem}</th>`)}
                                </tr>
                                ${hours.map((hour, indexHours) => {
                                    return (`<tr>
                                            ${numberDays.map((elem, index) => {                                            
                                                if (index == 0) {
                                                    return `<td>${hour}</td>`;
                                                } else if (calendar[start[index-1]] !== undefined && calendar[start[index-1]][indexHours]) {
                                                    console.log(start[index]);
                                                    return `<td style="background-color: green"></td>`;
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

            previous.addEventListener('click', () => changeWeek(previous));
            next.addEventListener('click', () => changeWeek(next));
        })
    </script>
@endsection