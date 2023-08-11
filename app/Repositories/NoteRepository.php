<?php

namespace App\Repositories;

use App\Models\Task;

class NoteRepository implements RepositoryInterface
{
    

    public function getAllNote()
    {
        return Task::paginate(20);
    }


    public function createNote($data)
    {
        return Task::create(['date' => $data->date, 'subject' => $data->subject, 'note'=>$data->note])->save();
    }


    public function editNote($id)
    {
        return Task::where('id',$id)->first();
    }


    public function updateNote($request)
    {

        $data = $request->input('noteId');
        return Task::where('id', $data)->update(['date'=>$request->date, 'subject'=>$request->subject, 'note'=>$request->note]);

    }


    public function deleteNote($id)
    {
        return Task::findorFail($id)->delete();
    }


    public function all()
    {
        return true;
    }



    public function get($id)
    {
        return true;
    }



    public function create(array $data)
    {
        return true;
    }



    public function update(array $data, $id)
    {
        return true;
    }



    public function delete($id)
    {
        return true;
    }

}