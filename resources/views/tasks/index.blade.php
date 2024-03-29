@extends('layouts.app')

@section('content')


<!-- ここにページ毎のコンテンツを書く -->
<div class="prose ml-4">
        <h2>タスク一覧</h2>
    </div>

    @if (isset($tasks))
        <table class="table table-zebra w-full my-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>status</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td><a class="link link-hover text-info" href="{{ route('tasks.show', $task->id) }}">{{ $task->id }}</a></td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    {{-- メッセージ作成ページへのリンク --}}                                                   
    <a class="btn btn-primary" href="{{ route('tasks.create') }}">追加</a> 
@endsection