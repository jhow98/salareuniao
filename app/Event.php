<?php

namespace App;
//Model para a tabela Eventos
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $table = 'events';
    protected $fillable = [
        'id',
        'scheduling',
        'description',
        'user_id'
    ];

    //Retorna o evento a partir da data
    public static function getEvent($date) {
        $event = Event::where('scheduling', $date)->first();
        return $event ? $event : null;
    }

    //Retorna se a data está reservada
    public static function IsReserved($date, $time) {
        return Event::where('scheduling', Carbon::create(Carbon::create($date)->year, Carbon::create($date)->month, Carbon::create($date)->day, $time))->first();
    }

    //Diz que um evento pertence a um usuário.
    public function user() {
        return $this->belongsTo('App\User');
    }

}
