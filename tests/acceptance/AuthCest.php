<?php

use App\User;

class AuthCest
{
    // test
    public function loginGoogle(\AcceptanceTester $I)
    {
        App::setLocale('en');

        Auth::logout();
        $I->amOnPage('/auth/login');
        $I->click('#google');
        $I->fillField('Email', 'julien@t4b.mx');
        $I->click('#next');
        $I->wait(1);
        $I->fillField('Passwd', 'Zee1shoo');
        $I->click('#signIn');
        $I->see(env('APP_NAME')); // Footer is the only common screen

    }

    

}


?>