var _token = $("input[name='_token']").val();
function openModalDay(day, month) {
    $.post("event/getDay", {day: day, month: month, _token: _token})
            .done(function (data) {
                $('.explain_day').empty();
                $('.explain_day').append(data);
                $('#ExplainDay').modal('show');
            });
}
function openReserva(r) {
    $.post("event/getModalReserva", {r: r, _token: _token})
            .done(function (data) {
                $('#insert-modal-reserva').empty();
                $('#insert-modal-reserva').html(data);
                var a = true;
                $('#ExplainDay').modal('hide').on('hidden.bs.modal', function () {
                    if (a) {
                        $('#reserva').modal('show');
                        a = false;
                    }
                });

            });
}
function confirmaCancelarReserva(id) {
    $('#alertConfirmaDeleteReserva').modal('show');
    $('#alertConfirmaDeleteReservaId').val(id);
}
function cancelarReserva() {
    $.post("event/delete", {id: $("#alertConfirmaDeleteReservaId").val()})
            .done(function () {
                $('#reserva').modal('hide');
                $('#alertDeleteReservaSucess').modal('show');
            });
}
function alterarReserva(id) {
    $.post("event/edit", {id: id, time: $('#hour-scheduling :selected').val(), desc: $('#desc-reserva').val()})
            .done(function () {
                $('#reserva').modal('hide');
                $('#alertAlterReservaSucess').modal('show');
            });
}

//Função chamada ao clicar no botão "Reservar da modal que explana os horários do dia"
function openModalSheduling(date, time) {
    $('#ExplainDay').modal('hide');
    $.post("event/getModalNewScheduling", {date: date, time: time, _token: _token})
            .done(function (data) {
                $('#insert-modal-new-scheduling').html(data);
                $('#novaReserva').modal('show');
            });
}

$.ajaxSetup({
    //Headers para o CSRF do laravel
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}
);

