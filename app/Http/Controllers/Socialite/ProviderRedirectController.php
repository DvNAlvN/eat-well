<?php

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class ProviderRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $provider)
    {
        if(!in_array($provider, ['google'])){
            return redirect(route('register'))->withErrors(['provider'=>'Invalid provider']);
        }

        try{
            return Socialite::driver($provider)->redirect();
        } catch(\Exception $e){
            return redirect(route('register'))->withErrors(['provider'=>'Something went wrong']);
        }
    }
}
