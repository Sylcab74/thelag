@extends('layouts.layout')

@section('title', 'Connexion')

@section('content')
    @if ($errors)
        <ul>
            @foreach($errors as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <form id="addUser" action="/user/register" method="POST">
        <label for="login">Identifiant</label>
        <input type="text" name="login" id="login"><br>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="Enregistrer">
    </form>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateUser = document.querySelector('#updateUser');


            const udpate = async (e, form) => {
                e.preventDefault();
                const formData = new FormData(form);

                try {
                    const response = await fetch(window.location.origin + '/coach/edit/' + form.dataset.id, {
                        method: 'POST',
                        mode:"cors",
                        body : formData
                    });
                    if (response.ok) {
                        window.location.replace(window.location.origin + '/coach/profil');
                    } else{
                        console.error(response.status);
                    }
                } catch(e) {
                    console.error(e);
                }
            }

            updateUser.addEventListener('submit', e => udpate(e, updateUser));

        })
    </script>
@endsection