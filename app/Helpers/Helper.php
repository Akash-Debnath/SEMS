<?php

namespace App\Helpers;

use App\Models\Department;

class Helper {


    /**
     * Department Code Generator method, every code need to be unique and 2 characters
     * 
     * @author Akash Chandra Debnath
     * @method deptCodeGenerator
     * @param $dept_name Department_full_name 
     * @return department_code
    */
    public static function deptCodeGenerator($dept_name)
    {
        $dept_name = preg_replace("/[^a-zA-Z]+/", "", $dept_name);

        $existing_dept_code = Department::get()->pluck('dept_code')->toarray();

        for($i=0;$i<strlen($dept_name);$i++) {
            $deptCode =strtoupper($dept_name[0].$dept_name[$i+1]);
            if (!in_array($deptCode, $existing_dept_code)) 
            {
                return  $deptCode;
                break;
            }
            
        }
        return null;
	}

}

