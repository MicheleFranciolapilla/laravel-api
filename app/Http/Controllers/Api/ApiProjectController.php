<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Project as Project;
use GrahamCampbell\ResultType\Success;

class ApiProjectController extends Controller
{
    function index()
    {
        $all_projects = Project::All();
        if (count($all_projects) != 0)
            return response()->json([
                                        'success'   => true,
                                        'projects'  => $all_projects
                                    ]);
        else
            return response()->json([
                                        'success'   => false,
                                        'error'     => "Collezione vuota!"
                                    ])->setStatusCode(404);
    }
}
