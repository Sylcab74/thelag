<div class="button-availability">
    <button id="previous">&lt</button>
    <h3>Du {{ explode('-',$start)[0] }} au {{explode('-',$end)[0]}}</h3>
    <button id="next">&gt</button>
</div>
<div id="table">
    <table data-month={{$month}} data-first={{$start}} data-year={{$year}}>
        <tbody>
            <tr>
                <th></th>
                @foreach ($calendar as $key => $day)
                    <th>{{ $days[$loop->index-1] }}</th>
                @endforeach
            </tr>

            @for ($i = 0; $i <= 23; $i++)
                <tr>
                    @for($u = $start-1; $u <= $start + 6; $u++)
                        
                        @if ($u == $start-1)
                            <td>{{$i}}h00</td>
                        @elseif ($calendar[$u.'-'.$month][$i] === "session")
                            <td class="session"></td>
                        @elseif ($calendar[$u.'-'.$month][$i] === 'yo')
                            <td data-id={{$calendar[$u.'-'.$month][$i]}} class="availability"></td>
                        @else
                            <td></td>                        
                        @endif
                            
                    @endfor
                </tr>
            @endfor
        </tbody>

    </table>
</div>