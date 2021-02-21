<?php

namespace App\Http\Traits;

use App\Models\User;

trait LogedTrait
{
    public static function admin($id)
    {

        $rolUser = auth()->user()::with('companies')->find(auth()->user()['id'])['companies']->find($id);
        if ($rolUser != null) {
            if ($rolUser['pivot']['rol'] == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function empresa($id)
    {

        $rolUser = auth()->user()::with('companies')->find(auth()->user()['id'])['companies']->find($id);
        if ($rolUser != null) {
                return true;
        } else {
            return false;
        }
    }


    public static function mismo($id)
    {
        $user = User::find($id);

         if (strval($user) == auth()->user()) {
            return true;
        } else {
            return false;
        }
    }

    public static function loged()
    {
        if (auth()->user() != null){
            return true;
        }else {
            return false;
        }
    }
}
