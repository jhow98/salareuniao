<?php
$today = Carbon\Carbon::today();

echo '<h1 class="w3-text-teal"><center>' . $today->format('F Y') . '</center></h1>';

$tempDate = Carbon\Carbon::createFromDate($today->year, $today->month, 1);

$skip = $tempDate->dayOfWeek;


for ($i = 0; $i < $skip; $i++) {
    $tempDate->subDay();
}
?>

<table class = "table">
    <thead>
        <tr class="w3-theme">
            <th>Segunda</th>
            <th>Terça</th>
            <th>Quarta</th>
            <th>Quinta</th>
            <th>Sexta</th>
        </tr>
    </thead>

<?php
//loops no mês
do {
    echo '<tr>';
    //loops na semana
    for ($i = 0; $i < 7; $i++) {
        //desconsidera sábados e domingos
        if ($i > 0 && $i < 6) {
            echo '<td><span class="date">';
            echo "<button type='button' class='btn btn-outline-dark ' onclick='openModalDay(" . $tempDate->day . ", " . $tempDate->month . ")'>" . $tempDate->day . "</button>";

            echo '</span></td>';
        }
        $tempDate->addDay();
    }
    echo '</tr>';
} while ($tempDate->month == $today->month);

echo '</table>';
?>

    @include('modal._day')
    <div id="insert-modal-new-scheduling"></div>
    <div id="insert-modal-reserva"></div>

