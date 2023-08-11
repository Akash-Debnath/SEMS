<?php
namespace App\Services;
use App\Repositories\Late_early_reqRepository;

class Late_early_reqService{
    protected $lateEarlyReqRepository;
    public function __construct(Late_early_reqRepository $lateEarlyReqRepository){
        $this->Late_early_reqRepository =$lateEarlyReqRepository;
    }
    public function getEmployee(){
        return $this->Late_early_reqRepository->getEmployee();
    }

    public function approvalReq(){
        return $this->Late_early_reqRepository->approvalReq();
    }

    public function verifyReq(){
        return $this->Late_early_reqRepository->verifyReq();
    }

    public function approve($id){
        return $this->Late_early_reqRepository->approve($id);
    }

    public function verify($id)
    {

        return $this->Late_early_reqRepository->verify($id);
    }

    public function create_Request($req){
        return $this->Late_early_reqRepository->create_Request($req);
    }

    public function delete($id)
    {
        return $this->Late_early_reqRepository->delete($id);
    }
}
