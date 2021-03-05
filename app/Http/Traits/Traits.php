<?php

namespace App\Http\Traits;

use App\Models\Invitation;
use App\Models\User;

trait Traits
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

    public static function coworker(User $user)
    {
        $empresas = $user->companies;

        $value = false;

        foreach ($empresas as $empresa) {
            if (self::empresa($empresa->id)) {
                $value = true;
            }

            return $value;
        }
    }

    public static function invitation($code, $company_id)
    {
        $check = Invitation::where('code', $code)->where('company_id', $company_id)->first();
        if ($check != null) {
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
        if (auth()->user() != null) {
            return true;
        } else {
            return false;
        }
    }

    public static function superadmin()
    {
        return auth()->user()->superadmin;
    }
}
