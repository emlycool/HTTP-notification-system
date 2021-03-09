<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Jobs\PublishToSubscribers;

class PublishController extends Controller
{
    
    public function __invoke(Request $request, Topic $topic)
    {
        $data = $request->all();
        $message = $topic->messages()->create(['message' => $data]);
        PublishToSubscribers::dispatch($topic, $data);
        return response()->json(null, 202);
    }

}
