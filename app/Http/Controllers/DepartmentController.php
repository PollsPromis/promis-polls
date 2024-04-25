<?php


    namespace App\Http\Controllers;


    class DepartmentController extends Controller
    {
        public function showForm()
        {
            $departments = Department::all(); // Получаем все отделы
            return view('departments', ['departments' => $departments]);
        }
    }

