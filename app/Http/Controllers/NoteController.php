<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoteService;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    
    /**
     * @var noteService
    */
    protected $noteService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }


    /**
     * Display a listing of the resource by directing to noteService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-note')){
            $notes = $this->noteService->getAllNote();
            return view('note', compact('notes'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
     * Store a newly created note resource in storage by directing to noteService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request date, subject, note_description
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('note-create')){
            $this->noteService->createNote($request);
            return redirect()->back()->with('success','Note Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
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
    }

    /**
     * Show modal for editing the specified note resource by directing to noteService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id note_id 
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if(Auth::user()->can('note-edit')){
            return $this->noteService->editNote($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified note resource in storage by directing to noteService.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request date, subject, note_description
     * @param  int  $id note_id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        if(Auth::user()->can('note-edit')){
            $this->noteService->updateNote($request);
            return redirect()->back()->with('success','Note Updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified note resource from storage by directing to noteService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id note_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('note-delete')){
            $this->noteService->deleteNote($id);
            return redirect()->back()->with('fail','Note Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
