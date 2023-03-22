<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data =[];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = Task::all();
        
            return view('tasks.index',[
                'tasks' => $tasks,
            ]);
        }
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        //
        return view('tasks.create',[
            'task' => $task,
            ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'status'=>'required|max:10',
            'content' => 'required|max:255',
            ]);
        
    
        
         $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status
        ]);
        
        
        return redirect('/');
        
    }
      

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) { 
            return view('tasks.show',[
                'task' => $task,
                ]);
        }

        // 前のURLへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = \App\Models\Task::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit',[
                'task' => $task,
            ]);
        }
        // 前のURLへリダイレクトさせる
        return redirect('/');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|max:10',  
            'content' => 'required|max:255',
        ]);
        
        //
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->content = $request->content;
        if (\Auth::id() === $task->user_id) {
            $task->save();
        }
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $task = \App\Models\Task::findOrFail($id);
         
        if (\Auth::id() === $task->user_id) {
            $task->DELETE();
        }
        return redirect('/');
    }
}
