<a href="game/show/{{ $game->id }}">
    <li class="li_game">
        <img class="img_game" src="{{ $game->picture }}" alt="{{ $game->name  }}" /> <br> 
        <h2>{{ $game->name }}</h2>
        <p>{{$game->type}}</p>
    </li>
</a>
