<?php

namespace App\Services;

class UserService {
//Serviço para a criação dinâmica de usuários e eventos, correlacionados entre si por Eloquent.
    public function create($data) {
        $user = \App\User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password'])
        ]);

                \App\Event::create([
                    'description' => $data['description'],
                    'scheduling' => $data['scheduling'],
                    'user_id' => $user->id
                ]);

       
        return $user->id;
    }

}
