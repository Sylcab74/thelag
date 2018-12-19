<button id="previous">&lt</button>
<button id="next">&gt</button>
<div id="table">
    <table data-month={{$month}} data-first={{$start}} data-year={{$year}}>
        <tbody>
            <tr>
                <th></th>
                @foreach ($calendar as $key => $day)
                    <th>{{ $days[$loop->index-1] }} {{ reset(explode('-',$key)) }}</th>
                @endforeach
            </tr>

            @for ($i = 0; $i <= 23; $i++)
                <tr>
                    @for($u = $start-1; $u <= $start + 6; $u++)
                        
                        @if ($u == $start-1)
                            <td>{{$i}}</td>
                        @elseif ($calendar[$u.'-'.$month][$i] === "session")
                            <td style="background: blue" class="session"></td>
                        @elseif ($calendar[$u.'-'.$month][$i] !== false)
                            <td style="background: green" data-id={{$calendar[$u.'-'.$month][$i]}} class="availability"></td>
                        @else
                            <td></td>                        
                        @endif
                            
                    @endfor
                </tr>
            @endfor
        </tbody>

    </table>
</div>