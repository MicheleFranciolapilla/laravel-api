<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Project as Project;
use GrahamCampbell\ResultType\Success;

class ProjectController extends Controller
{
    function index()
    {
        $all_projects = Project::All();
        return response()->json([
                                    'success'   => true,
                                    'projects'  => $all_projects
                                ]);
    }
}
