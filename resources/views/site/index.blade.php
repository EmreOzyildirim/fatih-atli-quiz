@extends('site.layout.app')

@section('content')
    @if(session('message'))
        <div class="modal" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{session('title')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{session('message')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary">Tamam</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Status</td>
                        <td>Created</td>
                        <td>Updated</td>
                        <td>Deadline</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    <form action="/update-status-todo-items" method="POST">
                        @csrf
                        <hr>
                        <button type="submit" name="completed_button" class="btn btn-success">Tamamlandı</button>
                        <button type="submit" name="uncompleted_button" class="btn btn-danger">Tamamlanmadı</button>
                        <hr>
                        @foreach($todo_items as $item)
                            <tr style="{{$item->deadline_passed == 1 ?'background-color:darkred;color:white;font-weight:500;':''}}">
                                <td>
                                    <input type="checkbox" name="todo_item_id[]" value="{{$item->item->id}}">
                                    {{$item->item->title}}</td>
                                <td>{{$item->item->description}}</td>
                                <td>
                                    <span
                                        class="text-white p-1 bg-{{$item->item->status == 1 ?'success':''}}{{$item->item->status == 0 ?'danger':''}}">
                                        {{$item->item->status == 1 ?'Completed':''}}
                                        {{$item->item->status == 0 ?'Uncompleted':''}}
                                    </span>
                                </td>
                                <td>{{$item->item->created_at}}</td>
                                <td>{{$item->item->updated_at}}</td>
                                <td>{{$item->item->deadline}}</td>
                                <td>
                                    <a href="/update-todo-item/{{$item->item->id}}"
                                       class="btn btn-sm btn-outline-info">Update</a>
                                    <a href="/delete-todo-item/{{$item->item->id}}"
                                       class="btn btn-sm btn-outline-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('js')

    <script>
        $(window).ready(function () {
            setInterval(function () {
                $('.modal').removeAttr("style");
            }, 2000);

        });
    </script>
@endsection
