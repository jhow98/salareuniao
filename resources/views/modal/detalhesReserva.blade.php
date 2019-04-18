
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="reserva">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reserva de {{ auth()->user($r->user_id)->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="alterarReserva">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Agendamento realizado {{ $r->created_at->diffForHumans() }}</label>
                        <input disabled id="data-reserva" value="{{ $scheduling->formatLocalized('%A %d de %B de %Y às %Hh') }}" type="datetime" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">Caso queira alterar a data da sua reserva, crie uma nova.</small>
                    </div>

                    @if($editable)
                    <div class="form-group">
                        <label for="select-time">Horário</label> 
                        <br>
                        <select  <?php echo ($editable and ! $outOfWeek) ? false : 'disabled'; ?>  id="hour-scheduling" class="select-time form-control" id="select-time">
                            @for($i = 6; $i <= 23; $i++)
                            @if(!App\Event::isReserved($scheduling->hour, $i))
                            @if($i >= Carbon\Carbon::now()->hour or $scheduling->day > Carbon\Carbon::now()->day)
                            {{ $o = ($i == $scheduling->hour) ? '<option selected' : '<option ' }}
                            {!! $o !!} value="{{ $i }}"> {{ $i}}h </option>

                            @endif
                            @endif
                            @endfor
                        </select>
                        <small id="timeHelp" class="form-text text-muted">{{ $outOfWeek ? false : 'Por favor, confirme o horário.' }}</small>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="textarea">Descrição</label>
                        <textarea <?php echo ($editable and ! $outOfWeek) ? false : 'disabled'; ?> id="desc-reserva" type="text" class="form-control">{{ $r->description }}</textarea>

                    </div>
                    @if($editable)
                    <button onclick="confirmaCancelarReserva('{{ $r->id }}')" type="button" class="btn btn-primary">Cancelar Reserva</button>
                    @if(!$outOfWeek)
                    <button onclick="alterarReserva('{{ $r->id }}')" type="button" class="btn btn-primary">Alterar</button>
                    @endif
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                @if($r->created_at <> $r->updated_at)
                <small>Esta reserva foi alterada {{ $r->updated_at->diffForHumans() }} </small>
                @elseif($outOfWeek)
                <small>Você não pode editar esta reserva, mas pode excluí-la. </small>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="alertDeleteReservaSucess">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reserva cancelada!</h5>

            </div>
            <div class="modal-body">
                Você ainda pode criar uma nova.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="alertAlterReservaSucess">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tudo certo!</h5>

            </div>
            <div class="modal-body">
                Suas alterações foram salvas.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="alertConfirmaDeleteReserva">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelar reserva</h5>

            </div>
            <div class="modal-body">
                {{ auth()->user()->name }}, você tem certeza que deseja excluir esta reserva?<br>
                Se você mudar de ideia, pode ser que outra pessoa já tenha escolhido este horário...
            </div>
            <input type="hidden" id="alertConfirmaDeleteReservaId">
            <div class="modal-footer">
                <button onclick="cancelarReserva()" type="button" class="btn btn-secondary" data-dismiss="modal">Sim</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>