@extends('layouts.test')

@section('title', 'Coachs')


@section('content')
    <form id="updateUser" data-id="{{$user->id}}">
        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant" value="{{$user->login}}"><br>
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" value="{{$user->firstname}}"><br>
        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname" value="{{$user->lastname}}"><br>
        <label for="">Email</label>
        <input type="email" name="mail" id="mail" value="{{$user->email}}"><br>
        <label for="biography">Biographie</label>
        <textarea name="biography" id="" cols="30" rows="10">{{$user->biography}}</textarea><br>
        <label for="price">Price</label>
        <input type="text" name="price" id="price" value="{{$user->price}}"><br>
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