<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Response;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\CreateEventRequest;

class EventsController extends Controller {

    //Classe controladora de eventos

    public function home(){
        Carbon::setLocale('pt_BR');
        return view('home', [   
            'name' => explode(' ', auth()->user()->name)[0]
        ]);
    }
    public function store(CreateEventRequest $request) {

        //Instancia um novo objeto do tipo Event
        $event = new Event;
        //A Classe Carbon cria um objeto do tipo timestamp com a data escolhida
        $event->scheduling = Carbon::create(Carbon::create($request->date)->year, Carbon::create($request->date)->month, Carbon::create($request->date)->day, $request->hour);
        $event->description = $request->desc;
        $event->user_id = $request->user_id  ? $request->user_id : Auth::user()->id;
        return $event->save() ? Response::json(['created' => 1]) : Response::json(['created' => 0]);
    }

    public function delete(Request $request) {
        return Response::json(['response' => Event::find($request->id)->delete()]);
    }

    public function edit(Request $request) {
        //Encontra o evento a ser editado.
        $event = Event::findOrFail($request->id);
        $eventScheduling = Event::findOrFail($request->id)->scheduling;
        $event->update([
            //É necessário o uso da classe Carbon para construir um novo timestamp a partir da mesma data mas com o novo horário
            'scheduling' => Carbon::create(Carbon::create($eventScheduling)->year, Carbon::create($eventScheduling)->month, Carbon::create($eventScheduling)->day, $request->time),
            'description' => $request->desc
        ]);
        $event->save() ? Response::json(['response' => true]) : Response::json(['response' => false]);
    }

    public function getModalNewScheduling(Request $request) {
        //Retorna a modal de agendamento novaReserva e envia junto a data e o horário selecionado.
        return view('modal.novaReserva', ['date' => $request->date, 'time' => $request->time]);
    }

    public function getModalReserva(Request $request) {
        //Captura a linha no DB com a reserva escolhida
        $row = Event::where('id', $request->r)->get()[0];
        $scheduling = Carbon::create($row->scheduling);
        $now = Carbon::now();
        //verifica se atende aos requisitos para o agendamento ser editado ou não.
        if ($row->user_id == auth()->user()->id && ($scheduling->day > $now->day || ($scheduling->day == $now->day and $scheduling->hour > $now->hour) xor ($scheduling->month > $now->today()->month)))  {
            $editable = true;
        } else {
            $editable = false;
        }
        //verifica se a data do agendamento é superior a uma semana.
        $outOfWeek = $scheduling->diffInDays($now->today()) < 7 ? false : true;

        //Retorna com a view detalhesReserva.
        return view('modal.detalhesReserva', [
            'r' => $row,
            'scheduling' => Carbon::create($row->scheduling),
            'outOfWeek' => $outOfWeek,
            'editable' => $editable
        ]);
    }

    public function getDay(Request $request) {
        //Retorna a view que contém os horários do dia com o dia e mês.
        return view('modal.day', ['day' => $request->day, 'month' => $request->month]);
    }

}
