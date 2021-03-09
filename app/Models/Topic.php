<?php

namespace App\Models;

use App\Models\Message;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subscribers(){
        return $this->hasMany(Subscription::class, 'topic_id');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'topic_id');
    }
}
