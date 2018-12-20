@extends('layouts.test')

@section('title', 'Inscription')

@section('content')
    <form id="addUser">
        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant"><br>
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname"><br>
        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname"><br>
        <label for="">Email</label>
        <input type="email" name="mail" id="mail"><br>
        <label for="biography">Biographie</label>
        <textarea name="biography" id="" cols="30" rows="10"></textarea><br>
        <label for="price">Price</label>
        <input type="text" name="price" id="price"><br>
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