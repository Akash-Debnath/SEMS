<?php
namespace App\Services;

use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Validator;

class NoteService 
{

    /**
     * @var noteRepository
    */
    protected $noteRepository;


    /**
     * UserService constructor.
     * @param noteRepository $noteRepository
     */
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }



    public function getAllNote()
    {
        return $this->noteRepository->getAllNote(); 
    }



    public function createNote($request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'date' => 'required',
            'note' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->noteRepository->createNote($request); 
    }



    public function editNote($id)
    {   
        $data = $this->noteRepository->editNote($id);
        

        return response()->json([
            'status'=>200,
            'notes'=>$this->noteRepository->editNote($id)
        ]);
    }


    public function updateNote($request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'date' => 'required',
            'note' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->noteRepository->updateNote($request); 
    }


    public function deleteNote($id)
    {
        return $this->noteRepository->deleteNote($id); 
    }

}