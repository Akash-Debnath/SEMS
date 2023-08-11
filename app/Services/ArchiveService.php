<?php
namespace App\Services;


use App\Repositories\ArchiveRepository;

class ArchiveService 
{
    /**
     * @var archiveRepository
    */
    protected $archiveRepository;


    /**
     * UserService constructor.
     * @param archiveRepository $archiveRepository
     */
    public function __construct(ArchiveRepository $archiveRepository)
    {
        $this->archiveRepository = $archiveRepository;
    }



    public function getAllArchiveEmployee()
    {
        return $this->archiveRepository->getAllArchiveEmployee(); 
    }



    public function getEmployeeInfo($id)
    {
        return $this->archiveRepository->getEmployeeInfo($id); 
    }

}