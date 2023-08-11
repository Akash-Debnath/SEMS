<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AttachmentService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AttachFilesController extends Controller
{
    /**
     * @var attachmentService
     */
    protected $attachmentService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }


    /**
     * Display a listing of all attachment resource by directing to attachmentService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @param void
     * @return all_attachments_details
    */
    public function index()
    {
        $attachments= $this->attachmentService->getAllAttachment();
        return view('attachment', compact('attachments'));
    }


    /**
     * Show the form for creating a new attachment resource.
     *
     * @author Akash Chandra Debnath
     * @method create
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        if(Auth::user()->can('attachment-create')){
            $employeeDept= $this->attachmentService->getEmployeeDepartment();
            $employeeSearch= $this->attachmentService->SearchEmployee();
            return view('add-attachment', compact('employeeDept','employeeSearch'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
    

    /**
     * Store a newly created attachment resource in storage by directing to attachmentService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request message_date, subject, specific dept, custom_recipient_employee, message_content
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {   
        if(Auth::user()->can('attachment-create')){
            $this->attachmentService->createAttachment($request);
            return redirect()->route('attachment.index')->with('success','Attachment Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Display the specified attachment resource by directing to attachmentService.
     *
     * @author Akash Chandra Debnath
     * @method show
     * @param  int  $id attachment_id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $attachmentDetails = $this->attachmentService->showAttachment($id);
        return view('attachment-detail', compact('attachmentDetails'));
    }


    /**
     * Show the form for editing the specified attachment resource by directing to attachmentService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id attachment_id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if(Auth::user()->can('attachment-edit')){
            $attachment = $this->attachmentService->getEditAttachment($id);
            $employeeSearch= $this->attachmentService->SearchEmployee();
            return view('edit-attachment', compact('attachment', 'employeeSearch'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Update the specified attachment resource in storage by directing to attachmentService.
     *
     * @author Akash Chandra Debnath
     * @method updateAttachment
     * @param  \Illuminate\Http\Request $request message_date, subject, specific dept, custom_recipient_employee, message_content
     * @param  int  $id attachment_id 
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('attachment-edit')){
            $this->attachmentService->updateAttachment($request, $id);
            return redirect()->route('attachment.index')->with('success', 'Attachment Updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Remove the specified attachment resource from storage by directing to attachmentService.
     *
     * @author Akash chandra Debnath
     * @method destroy
     * @param  int  $id attachment_id 
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('attachment-delete')){
            $this->attachmentService->deleteAttachment($id);
            return redirect()->route('attachment.index')->with('fail','Attachment Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Remove the specified attachment file from storage by directing to attachmentService.
     *
     * @author Akash chandra Debnath
     * @method deleteAttachmentFile
     * @param  int  $id attachment_file_id 
     * @return \Illuminate\Http\Response
    */
    public function deleteAttachmentFile($id)
    {
        if(Auth::user()->can('attachment-delete')){
            $this->attachmentService->deleteAttachmentFile($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
