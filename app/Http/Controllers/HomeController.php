<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\todo_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();

        return view('.site.index', ['todo_items' => json_decode(todo_items::getTodoItems($user_id))]);
    }

    public function create_todo_item()
    {
        return view('.admin.create');
    }

    public function create_todo_item_post(Request $request)
    {
        $user_id = Auth::id();
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'deadline' => ['required'],
        ]);

        $todo_item = new todo_items();
        $todo_item->user_id = $user_id;
        $todo_item->title = $request['title'];
        $todo_item->description = $request['description'];
        $todo_item->status = 0;
        $todo_item->deadline = $request['deadline'];
        $todo_item->save();

        events::saveEvent($user_id, $todo_item->id, $todo_item->title . ' başlıklı görev başarıyla oluşturuldu.');

        return redirect('/')->with(['status'=>true,'message'=>'Görev başarıyla oluşturuldu.']);
    }

    public function update_todo_item($todo_id)
    {
        $todo = json_decode(todo_items::getTodoItemById($todo_id), true);
        return view('.admin.update_todo_item', ['todo_item' => $todo]);
    }

    public function update_todo_item_post(Request $request)
    {
        $user_id = Auth::id();
        $user = Auth::user();

        $request->validate([
            'id' => ['required'],
            'title' => ['required'],
            'description' => ['required']
        ]);

        $todo = todo_items::find($request->id);

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->updated_at = time();
        $todo->save();

        $todo = json_decode(todo_items::getTodoItemTitle($request->id), true);

        $message = $user->name . ', ' . $todo['title'] . ' başlıklı görevi güncelledi.';
        events::saveEvent($user_id, $request['id'], $message);

        $send = array('status' => true, 'message' => "''" . $todo['title'] . "'' başlıklı görev başarıyla güncellendi.");
        return redirect('/')->with($send);
    }

    public function update_status_todo_items(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();

        $request->validate([
            'todo_item_id' => ['required']
        ]);

        if (isset($request['completed_button'])) {


            foreach ($request->todo_item_id as $item) {
                $todo = todo_items::find($item);
                $todo->status = 1;
                $todo->save();

                events::saveEvent($user_id, $item, '"' . $todo->title . '"başıklı görev tamamlandı.');
            }

        }
        if (isset($request['uncompleted_button'])) {


            foreach ($request->todo_item_id as $item) {
                print_r($item);
                $todo = todo_items::find($item);
                $todo->status = 0;
                $todo->save();

                events::saveEvent($user_id, $item, '"' . $todo->title . '" başlıklı görev tamamlanmadı.');
            }

        }

        return redirect('/');
    }

    public function delete_todo_item($todo_id)
    {
        $user = Auth::user();
        $user_id = Auth::id();

        $todo = json_decode(todo_items::getTodoItemTitle($todo_id), true);

        $message = $user->name . ', ' . $todo['title'] . ' başlıklı görevi sildi.';
        events::saveEvent($user_id, $todo_id, $message);

        //delete the item.
        $todo_item = todo_items::find($todo_id);
        $todo_item->delete();
        return redirect('/')->with(['status' => true, 'message' => $todo['title'] . ' başlıklı görev başarıyla silindi.']);
    }

}
