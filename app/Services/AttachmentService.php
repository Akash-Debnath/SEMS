<?php
namespace App\Services;


use App\Repositories\AttachmentRepository;
use Illuminate\Support\Facades\Validator;


class AttachmentService 
{

    /**
     * @var AttachmentRepository
    */
    protected $attachmentRepository;


    /**
     * UserService constructor.
     * @param AttachmentRepository $attachmentRepository
     */
    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }



    /**
     * Display a listing of all attachment resource by directing to attachmentRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllAttachment
     * @param void
     * @return all_attachments_details
    */
    public function getAllAttachment()
    {
        return $this->attachmentRepository->getAllAttachment();
    }


    /**
     * Display the specified attachment resource by directing to attachmentRepository.
     *
     * @author Akash Chandra Debnath
     * @method showAttachment
     * @param  int  $id attachment_id
     * @return \Illuminate\Http\Response
    */
    public function showAttachment($id)
    {
        return $this->attachmentRepository->showAttachment($id);
    }



    /**
     * Show the all employees for creating a new attachment resource.
     *
     * @author Akash Chandra Debnath
     * @method SearchEmployee
     * @return \Illuminate\Http\Response
    */
    public function SearchEmployee()
    {
        return $this->attachmentRepository->SearchEmployee(); 
    }



    /**
     * Get all employees from related storage by directing to attachmentRepository.
     *
     * @author Akash Chandra Debnath
     * @method getEmployeeDepartment
     * @return \Illuminate\Http\Response
    */
    public function getEmployeeDepartment()
    {
        return $this->attachmentRepository->getEmployeeDepartment(); 
    }
    


    /**
     * Validate attachment request data and store a newly created attachment resource in storage by directing to attachmentRepository.
     *
     * @author Akash Chandra Debnath
     * @method createAttachment
     * @param  \Illuminate\Http\Request  $request message_date, subject, specific dept, custom_recipient_employee, message_content
     * @return \Illuminate\Http\Response
    */
    public function createAttachment($request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'message' => 'required', 
            'message_date' => 'required',
            // 'filename' => 'mimes:doc,pdf,docx'

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $attachmentId = $this->attachmentRepository->createAttachment($request); 
        $this->attachmentRepository->createAttachmentfile($request,$attachmentId); 
    }



    /**
     * Get data for edit attachment resource by directing to attachmentRepository
     * 
     * @author Akash Chandra Debnath
     * @method getEditAttachment
     * @param $id attachment_id
     * @return void
    */
    public function getEditAttachment($id)
    {
        return $this->attachmentRepository->getEditAttachment($id);
    }



    /**
     * Validate request data and update the specified attachment resource in storage by directing to attachmentRepository.
     *
     * @author Akash Chandra Debnath
     * @method updateAttachment
     * @param  \Illuminate\Http\Request $request message_date, subject, specific dept, custom_recipient_employee, message_content
     * @param  int  $id attachment_id 
     * @return \Illuminate\Http\Response
    */
    public function updateAttachment($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'message' => 'required', 
            'message_date' => 'required',
            // 'filename' => 'mimes:doc,pdf,docx'

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->attachmentRepository->updateAttachment($request, $id);
    }


    
    /**
     * Remove the specified attachment resource from storage by directing to attachmentRepository.
     *
     * @author Akash chandra Debnath
     * @method deleteAttachment
     * @param  int  $id attachment_id 
     * @return \Illuminate\Http\Response
    */
    public function deleteAttachment($id)
    {
        return $this->attachmentRepository->delete($id);
    }



    /**
     * Remove the specified attachment file from storage by directing to attachmentRepository.
     *
     * @author Akash chandra Debnath
     * @method deleteAttachmentFile
     * @param  int  $id attachment_file_id 
     * @return \Illuminate\Http\Response
    */
    public function deleteAttachmentFile($id)
    {
        return $this->attachmentRepository->deleteAttachmentFile($id);
    }

}