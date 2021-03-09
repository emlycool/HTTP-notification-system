<?php

namespace Tests\Feature;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    protected $topic = null;

    /** @test*/
    public function can_subscribe_to_a_topic()
    {
        $this->withoutExceptionHandling();
        $this->topic = Topic::factory()->create();

        $response = $this->post("subscribe/{$this->topic->name}", [
            'url' => "https://api.com/test1"
        ]);
        
        $response->assertStatus(201);
        $response->assertJson([
            'url' => "https://api.com/test1",
            'topic' => $this->topic->name
        ]);
    }

    /** @test*/
    public function subscription_requires_url(){
        $this->withExceptionHandling();
        $this->topic = Topic::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->name}");
        
        $response->assertStatus(422);
    }

    /** @test*/
    public function subscription_requires_a_valid_url(){
        $this->withExceptionHandling();
        $this->topic = Topic::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->name}", ['url' => 'invalid-url']);
        
        $response->assertStatus(422);
    }

    /** @test*/
    public function same_subscriber_cant_be_subscribed_for_same_topic(){
        $this->withExceptionHandling();
        $this->topic = Topic::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->name}", ['url' => "https://api.com/test1"]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post("subscribe/{$this->topic->name}", ['url' => "https://api.com/test1"]);
        
        $response->assertStatus(200);
        $response->assertSeeText('already subscribed');
    }
}
