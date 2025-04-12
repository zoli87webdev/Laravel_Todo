<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        // $tasks = Task::orderBy('created_at', 'desc')->get();
        $tasks = Task::where('user_id', Auth::id())->latest()->get();

        return view('tasks.index', compact('tasks'));
    }



    public function store(TaskRequest $request){

        $task = new Task();
        $task->title = $request->input('title');
        $task->is_completed = $request->input('is_completed', false);
        $task->user_id = auth()->id(); // beállítjuk a bejelentkezett felhasználót
        $task->save();

        // $validated = $request->validate([
        //     'title' => [
        //         'required',
        //         'string',
        //         'max:255',
        //         'regex:/^[A-Za-zÀ-ÿ\s]+$/u',
        //     ]
        // ]);

        // Task::create([
        //     'title' => $validated['title'],
        //     'is_completed' => false,
        //     'user_id' => Auth::id(),
        // ]);

        

        session()->flash('success', 'A feladat sikeresen hozzáadva');

        return redirect('/');
    }


    public function update(TaskRequest $request, $id){


        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->is_completed = $request->has('is_completed');
        $task->user_id = auth()->id(); // frissítjük a user_id-t
        $task->save();


        // $task = Task::findOrFail($id);
        // $task->is_completed = $request->has('is_completed');
        // $task->save();

        session()->flash('success', 'Feladat állapota frissítve.');

        return redirect('/');

    }


    public function destroy($id){
        $task = Task::findOrFail($id);
        $task->delete();

        session()->flash('success', 'A feladat sikeresen törölve.');

        return redirect('/');
    }

}
