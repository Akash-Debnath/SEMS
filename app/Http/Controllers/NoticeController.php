<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoticeService;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{


    /**
     * @var noticeService
     */
    protected $noticeService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }


    /**
     * Display a listing of all notices resource by directing to noticeService.
     * 
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices= $this->noticeService->getAllNotices();
        return view('notice', compact('notices'));
    }

    /**
     * Show the form for creating a new notice resource by directing to noticeService.
     *
     * @author Akash Chandra Debnath
     * @method create
     * @param void
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('notice-create')){
            return view('add-notice');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Store a newly created notice resource in storage by directing to noticeService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request notice_date, notice_subject, notice_content
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('notice-create')){
            $this->noticeService->createNotice($request);
            return redirect()->route('notice.index')->with('success','Notice Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Display the specified notice resource by directing to noticeService.
     *
     * @author Akash Chandra Debnath
     * @method show
     * @param  int  $id notice_id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noticeDetails = $this->noticeService->showNotices($id);
        return view('notice-details', compact('noticeDetails'));
    }

    /**
     * Show the form for editing the specified notice resource by directing to noticeService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id notice_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('notice-edit')){
            $notices = $this->noticeService->editNotice($id);
            return view('edit-notice', compact('notices'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified notice resource in storage by directing to noticeService.
     *
     * @author Akash Chandra Debnath
     * @param  \Illuminate\Http\Request  $request notice_date, notice_subject, notice_content
     * @method update
     * @param  int  $id notice_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('notice-edit')){
            $this->noticeService->updateNotice($request, $id);
            return redirect()->route('notice.index')->with('success','Notice Edited Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified notice resource from storage by directing to noticeService.
     *
     * @author Akash Chandra Debnath
     * @param  int  $id notice_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('notice-delete')){
            $this->noticeService->deleteNotice($id);
            return redirect()->route('notice.index')->with('fail','Notice Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
