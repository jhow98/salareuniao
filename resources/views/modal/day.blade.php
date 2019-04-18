<?php
$now = Carbon\Carbon::now();
for ($i = 6; $i <= 23; $i++) {//São as horas para agendamento.
    $date = Carbon\Carbon::create($now->year, $month, $day, $i);
    $r = App\Event::getEvent($date);
    if ($r) {
        echo
        '<tr>'
        . '<th scope="row">' . Carbon\Carbon::create($r['scheduling'])->hour . '</th>'
        . '<td>Reservado para ' . App\User::getName($r['user_id']) . '</td>'
        . '<td> ';

        $old = ($r['scheduling'] < $now) ? true : false;
        ?>

        <button type="button" class="btn btn-outline-info" onclick="openReserva({{$r->id }})">Detalhes</button>
        </td>
        </tr>

    <?php } else { ?>
        <tr>
            <th scope = "row">{{ $i }} </th>
            <td>{{ (($date->day > $now->day) || ($date->day == $now->day and $date->hour > $now->hour) || ($date->month > $now->month)) ? 'Disponível' : 'Não houve reserva'}}</td>
            @if(($date->day > $now->day) || ($date->day == $now->day and $date->hour > $now->hour) || ($date->month > $now->month))
                <td><button type="button" class="btn btn-outline-info" onclick="openModalSheduling('{{Carbon\Carbon::create($now->year, $month, $day)}}','{{$i}}')">Reservar</button></td>
            @endif
        </tr>
        <?php
    }
}




