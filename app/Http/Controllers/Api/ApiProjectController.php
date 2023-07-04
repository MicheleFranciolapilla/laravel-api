<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Project as Project;
use GrahamCampbell\ResultType\Success;

class ApiProjectController extends Controller
{
    function index(Request $request)
    {
        if ($request->has('category_id'))
            $projects = Project::with(['category', 'technologies'])->where('category_id', $request->category_id)->paginate(4);
        else
            $projects = Project::with(['category', 'technologies'])->paginate(4);
        if (!empty($projects))
            return response()->json([
                                        'success'   => true,
                                        'projects'  => $projects
                                    ]);
        else
            return response()->json([
                                        'success'   => false,
                                        'error'     => "Collezione vuota!"
                                    ])->setStatusCode(404);
    }

    function show($slug)
    {
        $project = Project::with(['category', 'technologies'])->where('slug', $slug)->first();
        if ($project)
            return response()->json([
                                        'success'   => true,
                                        'project'  => $project
                                    ]);
        else
            return response()->json([
                                        'success'   => false,
                                        'error'     => "Il progetto non esiste"
                                    ])->setStatusCode(404);
    }
}
