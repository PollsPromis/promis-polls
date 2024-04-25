<?php

namespace App\Http\Controllers;

use App\Models\Department;

class IndexController
{
    public function index() {
        $departments = Department::all();

        return view('layouts.index', [
            'departments' => $departments,
        ]);
    }
}
