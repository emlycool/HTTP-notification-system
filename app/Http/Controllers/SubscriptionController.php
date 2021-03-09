<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request  $request, Topic $topic)
    {

        $request->validate([
            'url' => 'required|string|max:225|url'
        ]);
        $url = Str::endsWith($request->url, '/') ? Str::substr($request->url, 0, -1) : $request->url;
        
        $subscriber = Subscription::where([ ['topic_id', $topic->id], ['endpoint', $url] ])->first();
        if(!is_null($subscriber)){
            return response()->json("{$url} already subscribed to '{$topic->name}'", 200);
        }

        $subscriber = $topic->subscribers()->create(['endpoint' => $url]);

        return response()->json([
            'url' => $subscriber->endpoint,
            'topic' => $topic->name
        ], 201);
        
    }

}
