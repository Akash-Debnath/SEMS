<?php

namespace App\Repositories;

use App\Models\Attach_file;
use App\Models\Attach_msg;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttachmentRepository implements RepositoryInterface
{

    /**
     * Display a listing of all attachment resource from `attach_msgs` table.
     *
     * @author Akash Chandra Debnath
     * @method getAllAttachment
     * @param void
     * @relation with `employees` table
     * @return all_attachments_details
    */
    public function getAllAttachment()
    {
        return Attach_msg::with('employee')->orderBy('id', 'DESC')->paginate(20);
    }



    /**
     * Display the specified attachment resource from `attach_msgs` table.
     *
     * @author Akash Chandra Debnath
     * @method showAttachment
     * @param  int  $id attachment_id
     * @relation with `attach_files` table
     * @return \Illuminate\Http\Response
    */
    public function showAttachment($id)
    {
        return Attach_msg::with('attachFiles')->where('id', '=', $id)->first();
    }



    /**
     * Get all employees from `employees` table.
     *
     * @author Akash Chandra Debnath
     * @method SearchEmployee
     * @return \Illuminate\Http\Response
    */
    public function SearchEmployee()
    {
        return Employee::where('archive','=', "N")->get();
    }


    /**
     * Get all employees from `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method getEmployeeDepartment
     * @return \Illuminate\Http\Response
    */
    public function getEmployeeDepartment()
    {
        return Department::all();
    }

    /**
     * Store a newly created attachment resource in `attach_msgs` table.
     *
     * @author Akash Chandra Debnath
     * @method createAttachment
     * @param  \Illuminate\Http\Request  $request message_date, subject, specific dept, custom_recipient_employee, message_content
     * @return \Illuminate\Http\Response
    */
    public function createAttachment($data)
    {
        $employees = implode(",",$data->custom_recipient);
        $attachment = Attach_msg::create(['subject' =>  $data->subject,'message_date'=>$data->message_date,'message'=>$data->message,'message_to'=>$data->message_to,'read_by'=>'','custom_recipient'=> $employees,'is_encrypted'=>'N','message_from'=>Auth::user()->username]);
        return  $attachment->id;
    }




    /**
     * Store a newly created attachment files in `attach_files` table.
     *
     * @author Akash Chandra Debnath
     * @method createAttachmentfile
     * @param  \Illuminate\Http\Request  $request attachment_files
     * @param attachmentId attachment_id
     * @return \Illuminate\Http\Response
    */
    public function createAttachmentfile($data,$attachmentId)
    {   
        $files = [];
        if($data->hasfile('filename'))
         {
            foreach($data->file('filename') as $file)
            {   
                $name = time().rand(1,100).'.'.$file->extension();
                $original_name = $file->getClientOriginalName();
                $file->move(public_path('AttachmentFiles'), $name);  
                $attachment= new Attach_file();
                $attachment->filename =  $name; 
                $attachment->original_name =  $original_name; 
                $attachment->attachment_id =  $attachmentId; 
                $attachment->save();  
            }
         }
        return;
    }



    /**
     * Get data for edit attachment resource from `attach_msgs` table
     * 
     * @author Akash Chandra Debnath
     * @method getEditAttachment
     * @param $id attachment_id
     * @relation with `attach_files` table
     * @return void
    */
    public function getEditAttachment($id)
    {
        return Attach_msg::where('id',$id)->with('attachFiles')->first();
    }



    public function updateAttachment($data, $id)
    {
        $employees = implode(",",$data->custom_recipient);
        $attachment = Attach_msg::where('id', $id)->update(['subject' =>  $data->subject, 'message_date'=>$data->message_date, 'message'=>$data->message, 'message_to'=>$data->message_to, 'read_by'=>'', 'custom_recipient'=> $employees, 'is_encrypted'=>'N', 'message_from'=>Auth::user()->username]);
        $files = [];
        if($data->hasfile('filename'))
        {
            foreach($data->file('filename') as $file)
            {   
                $name = time().rand(1,100).'.'.$file->extension();
                $original_name = $file->getClientOriginalName();
                $file->move(public_path('AttachmentFiles'), $name);  
                $attachment= new Attach_file();
                $attachment->filename =  $name; 
                $attachment->original_name =  $original_name; 
                $attachment->attachment_id =  $id; 
                $attachment->save();  
            }
        }
        return;
    }



    /**
     * Remove the specified attachment file from `attach_files` table.
     *
     * @author Akash chandra Debnath
     * @method deleteAttachmentFile
     * @param  int  $id attachment_file_id 
     * @return \Illuminate\Http\Response
    */
    public function deleteAttachmentFile($id)
    {
        return Attach_file::find($id)->delete();
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


    /**
     * Remove the specified attachment resource from `attach_msgs` table.
     *
     * @author Akash chandra Debnath
     * @method delete
     * @param  int  $id attachment_id 
     * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {
       return Attach_msg::find($id)->delete();
    }


}