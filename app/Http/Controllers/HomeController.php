<?php

namespace App\Http\Controllers;

use App\Models\AssignedWork;
use App\Models\Department;
use App\Models\Kanban;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::query()
            ->withCount('assignedWorks')
            ->get(['id', 'name']);

        $suppliers = Supplier::query()
            ->get(['id', 'name']);

        $materials = Material::query()
            ->get(['id', 'name']);

        $kanbans = Kanban::query()
        ->get(['id', 'name']);

        return view('home', [
            'departments' => $departments,
            'suppliers' => $suppliers,
            'materials' => $materials,
            'kanbans' => $kanbans
        ]);
    }
}
