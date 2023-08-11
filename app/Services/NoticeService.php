<?php
namespace App\Services;

use App\Repositories\NoticeRepository;
use Illuminate\Support\Facades\Validator;

class NoticeService 
{

     /**
     * @var noticeRepository
    */
    protected $noticeRepository;


    /**
     * UserService constructor.
     * @param NoticeRepository $noticeRepository
     */
    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }


    public function getAllNotices()
    {
        return $this->noticeRepository->getAllNotices(); 
    }

    public function showNotices($id)
    {
        return $this->noticeRepository->showNotices($id); 
    }


    public function editNotice($id)
    {
        return $this->noticeRepository->editNotice($id); 
    }



    public function deleteNotice($id)
    {
        return $this->noticeRepository->deleteNotice($id); 
    }



    public function createNotice($request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'notice' => 'required', 
            'notice_date' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->noticeRepository->createNotice($request); 
    }


    public function updateNotice($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'notice' => 'required', 
            'notice_date' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->noticeRepository->updateNotice($request, $id); 
    }

}