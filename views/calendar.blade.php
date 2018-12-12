@extends('layouts.test')

@section('title', 'Le titre')

@section('content')

    <table>
        <tr>
            <th></th>
            @for ($i = 0; $i <= 7; $i++)
                <th>{{ $weekStart++ }}
            @endfor
        </tr>
        
        @for ($i = 0; $i <= 23; $i++)
            <tr>
                @for($u = 0; $u <= 8; $u++)
                    @if ($u === 0)
                        <td>{{$i}}h00</td>
                    @endif
                    <td></td>
                @endfor
            </tr>
        @endfor
        
    
    </table>
@endsection