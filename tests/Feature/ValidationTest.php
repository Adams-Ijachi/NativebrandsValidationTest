<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_error_is_thrown_with_incorrect_data()
    {
        $response = $this->post('/api/register',[

                        "first_name" => [
                            "value" => "John",
                            "rules" => "alpha|required|number"
                        ],
                        "last_name" => [
                            "value" => "Doe",
                            "rules" => "alpha|required|number"
                        ],
                        "email" => [
                            "value" => "Doe",
                            "rules" => "email"
                        ],
                        "phone" => [
                            "value" => "08175020A329t",
                            "rules" => "alpha|required|number"
                        ],
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
                'last_name',
                'email',
                'phone'
            ]
        ]);
    }
}
