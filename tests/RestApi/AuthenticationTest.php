<?php

namespace Tests\RestApi;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    function testMustFieldValidation(){
        $response = $this->json('post','api/auth/register',[
        ]);

        $response->assertUnprocessable();
    }

    function testFieldValidFormat(){
        $response = $this->json('post','api/auth/register',[
            'name'=>'name',
            'email'=>'testemail',
            'password'=>'password',
            'password_confirmation'=>'password',
        ]);

        $response->assertUnprocessable();

        $response = $this->json('post','api/auth/register',[
            'name'=>'name',
            'email'=>'test@email',
            'password'=>'pa',
            'password_confirmation'=>'password',
        ]);

        $response->assertUnprocessable();

        $response = $this->json('post','api/auth/register',[
            'name'=>'n',
            'email'=>'test@email',
            'password'=>'123',
            'password_confirmation'=>'123',
        ]);

        $response->assertUnprocessable();

    }

    function testDuplicateEmail(){
        $response = $this->json('post','api/auth/register',[
            'name'=>'name',
            'email'=>'test21212111@email',
            'password'=>'password',
            'password_confirmation'=>'password',
        ]);

        $response->assertSuccessful();

        $response = $this->json('post','api/auth/register',[
            'name'=>'name',
            'email'=>'test21212111@email',
            'password'=>'password',
            'password_confirmation'=>'password',
        ]);

        $response->assertUnprocessable();
    }

    function  testSuccessfulRegister(){
        $response = $this->json('post','api/auth/register',[
            'name'=>'name',
            'email'=>'tessww1as22stsucc1ess@email',
            'password'=>'123123',
            'password_confirmation'=>'123123',
        ]);

        $response->assertSuccessful();
    }

    function testSuccessLogin(){
        $response = $this->json('post', 'api/auth/login',[
            'email' =>'test@dev.io',
            'password' =>'testdevc',
        ]);

        $response->assertUnprocessable();

        $response = $this->json('post', 'api/auth/login',[
            'email' =>'test@dev.io',
            'password' =>'testdev',
        ]);

        $response->assertSuccessful();
    }

}
