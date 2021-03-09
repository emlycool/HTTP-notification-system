<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function send_message_to_all_subscribers_on_a_topic()
    {
        $this->withoutExceptionHandling();
        Http::fake();

        $topic = Topic::factory()
        ->hasSubscribers(1, [
            'endpoint' => "https://api.com/test"
        ])
        ->create();
        
        $response = $this->post("/publish/{$topic->name}", [
            'name' => "John Doe",
            'email' => "john.doe@gmail.com",
        ]);
        
        Http::assertSent(function (Request $request) {
            return 
             $request->url() == 'https://api.com/test' &&
                    $request['data']['name'] == 'John Doe' &&
                    $request['data']['email'] == 'john.doe@gmail.com';
        });

        $response->assertStatus(202);
    }
}
