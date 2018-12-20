@extends('layouts.layout')

@section('title', $game->name)

@section('content')
    <div class="box">
        <div id="alert" style="display: none"></div>
        <h1 data-id={{$game->id}}>{{ $game->name }}</h1>     
        <img class="game-pic" src="{{$game->picture}}"/>
        <h2>{{ $game->type }}</h2>
        <p class="game-description">{{ $game->description }}</p>
        
        @if ($getThisGame)
            <button class="add_remove_action" id="remove">Retirer de la bibliothéque</button>
        @else
            <button class="add_remove_action" id="add">Ajouter à ses jeux</button>
        @endif
        
    </div>
@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addRemoveAction = document.querySelector('.add_remove_action');
        const alert = document.querySelector('#alert');
        const id = document.querySelector('h1').dataset.id;

        const addRemove = async elem => {
            const formData = new FormData();
            const action = elem.getAttribute('id') === "add" ? "add" : "remove";
            
            formData.append('game', id);
            formData.append('action', action);

            try {
                const response = await fetch(window.location.origin + '/coach/handleGame', {
                    method: 'POST',
                    mode:"cors",
                    body : formData
                });

                if (response.ok) {
                    const data = await response.json();
                    alert.style.display = 'block';
                    alert.innerHTML = `<p>${data.response}</p>`;

                    if (action == "add"){
                        addRemoveAction.setAttribute("id", "remove");
                        addRemoveAction.textContent = "Retirer de la bibliothéque";
                    } else {
                        addRemoveAction.setAttribute("id", "add");
                        addRemoveAction.textContent = "Ajouter à ses jeux";
                    }

                } else {
                    console.error(response.status);
                }
            } catch(e) {
                console.error(e);
            }
        };
        
        addRemoveAction.addEventListener('click', () => addRemove(addRemoveAction));
    });
</script>
@endsection