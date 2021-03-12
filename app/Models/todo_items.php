<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class todo_items extends Model
{
    use HasFactory;

    public $timestamps = true;

    public static function getTodoItems($user_id)
    {
        $todo_items = DB::table('todo_items')->where('user_id', '=', $user_id)->get();

        $all_items = array();

        foreach ($todo_items as $item) {

            $todo = array(
                'item' => $item,
                'deadline_passed' => 0
            );

            if ($item->deadline < date('Y-m-d')) {
                $todo['deadline_passed'] = 1;
            }

            array_push($all_items, $todo);
        }
        return json_encode($all_items);
    }

    public static function getTodoItemById($todo_id)
    {
        return json_encode(DB::table('todo_items')->where('id', '=', $todo_id)->first());
    }

    public static function getTodoItemTitle($todo_id)
    {
        return json_encode(DB::table('todo_items')->select('title')->where('id', '=', $todo_id)->first());
    }

}
