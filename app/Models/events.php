<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class events extends Model
{
    use HasFactory;

    public $timestamps = true;

    public static function saveEvent($user_id, $todo_item_id, $message)
    {

        $event = new events;

        $event->user_id = $user_id;
        $event->todo_item_id = $todo_item_id;
        $event->message = $message;

        $event->save();

        return ['status'=>true,'message'=>'Event başarıyla eklendi.'];
    }
}
