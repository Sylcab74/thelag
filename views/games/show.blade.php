@extends('layouts.test')

@section('title', $game->name)

@section('content')
    <div id="alert" style="display: none"></div>
    
    <h1>{{ $game->name }}</h1>
    <p>{{ $description }}</p>
    <button id="add" data-id={{$game->id}}>Ajouter à ses jeux</button>
    <button id="remove">Supprimer de ses jeux</button>
@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addGame = document.querySelector('#add');
        const removeGame = document.querySelector('#remove');
        const alert = document.querySelector('#alert');

        const addRemove = async elem => {
            const formData = new FormData();
            const action = elem.getAttribute('id') === "add" ? "add" : "remove";
            
            formData.append('game', addGame.dataset.id);
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
                } else {
                    console.error(response.status);
                }
            } catch(e) {
                console.error(e);
            }
        };
        
        addGame.addEventListener('click', () => addRemove(addGame));
        removeGame.addEventListener('click', () => addRemove(removeGame));
    });
</script>
@endsection