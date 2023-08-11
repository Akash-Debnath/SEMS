<?php

namespace App\Repositories;

use App\Models\Notice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NoticeRepository implements RepositoryInterface
{

    public function getAllNotices()
    {
        return Notice::orderBy('id','DESC')->paginate(20);
    }


    public function showNotices($id)
    {
        return Notice::where('id', '=', $id)->first();
    }



    public function editNotice($id)
    {
        return Notice::find($id);
    }



    public function deleteNotice($id)
    {
        return Notice::findorFail($id)->delete();
    }

    
    public function updateNotice($request, $id)
    {
        $notice = Notice::find($id);
        $notice->subject = $request->subject;
        $notice->notice_date = $request->notice_date;
        $notice->notice = $request->notice;
        return $notice->update();
    }


    public function createNotice($data)
    {
        $notice = new Notice;
        $notice->subject = $data->subject;
        $notice->notice_date = $data->notice_date;
        $notice->notice = $data->notice;
        $notice->isEncrypted = "N";
        return $notice->save();
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