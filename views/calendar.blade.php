@extends('layouts.test')

@section('title', 'Le titre')

@section('content')

    <h1>{{$user->login}}</h1>
    <table>
        <tr>
            <th></th>
            @for ($i = $start; $i <= $start + 7; $i++)
                <th>{{ $i }}</th>
            @endfor
        </tr>

        @for ($i = 0; $i <= 23; $i++)
            <tr>
                @for($u = $start-1; $u <= $start + 7; $u++)
                    
                    @if ($u == $start-1)
                        <td>{{$i}}</td>
                    @elseif ($calendar[$u][$i])
                        <td style="background: green"></td>
                    @else
                        <td></td>                        
                    @endif
                        
                @endfor
            </tr>
        @endfor
    
    </table>
@endsection