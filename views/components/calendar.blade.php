<table>
    <tr>
        <th></th>
        @foreach ($calendar as $key => $day)
            <th>{{ $days[$loop->index-1] }} {{ $key }}</th>
        @endforeach
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