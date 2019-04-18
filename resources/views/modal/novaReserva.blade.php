<!--View chamada pela função "openModalSheduling(id, date)" do arquivo script.js-->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="novaReserva">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova reserva</h5>

            </div>
            <div class="modal-body">
                <form class="form-new-scheduling">


                    <div class="form-group">
                        <label for="inputDescription">Data</label>
                        <input disabled type="text" value="{{ Carbon\Carbon::create($date)->formatLocalized('%A %d de %B de %Y') }}" class="form-control">
                        <input id="date-scheduling" type="hidden" value="{{ Carbon\Carbon::create($date) }}">
                        <small id="timeHelp" class="form-text text-muted">Caso queira alterar a data, selecione uma nova no calendário.</small>
                    </div>


                    <div class="form-group">
                        <label for="select-time">Horário</label> <br>
                        <select id="hour-scheduling" class="select-time form-control" id="select-time">
                            @for($i = 6; $i <= 23; $i++)
                            @if($i >= $time and (!App\Event::isReserved($date, $i)))
                            {{ $o = ($i == $time) ? '<option selected' : '<option ' }} 

                            {!! $o !!} value="{{ $i }}"> {{ $i}}h </option>
                            @endif
                            @endfor
                        </select>
                        <small id="timeHelp" class="form-text text-muted">Por favor, confirme o horário.</small>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Conte-nos mais sobre a sua reserva...</label>
                        <textarea required id="description-scheduling" required name="description-scheduling" class="form-control"></textarea>
                        <small id="description-scheduling-help" name="description-scheduling" class="form-text text-muted">Isso nos ajuda a entender o motivo do agendamento. Seja breve.</small>
                    </div>


                    <button class="btn btn-primary">Concluir agendamento</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="alertReservaSucess">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reserva realizada!</h5>

            </div>
            <div class="modal-body">
                Você ainda pode editá-la até o dia agendado.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(".form-new-scheduling").on('submit', function (e) {
        e.preventDefault();

        var date = $('#date-scheduling').val();
        var hour = $('#hour-scheduling').val();
        var desc = $('#description-scheduling').val();

        $.ajax({
            type: 'POST',
            url: 'event/store',
            data: {date: date, hour: hour, desc: desc}

        }).done(function () {
            $('#novaReserva').modal('hide');
            $('#alertReservaSucess').modal('show');
        });
    });

</script>