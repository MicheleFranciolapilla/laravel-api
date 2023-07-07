<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Technology as Technology;

class ApiTechnologyController extends Controller
{
    function index()
    {
        $all_technologies = Technology::All();
        if ($all_technologies->isNotEmpty())
            return response()->json([
                                        'success'   => true,
                                        'technologies'  => $all_technologies
                                    ]);
        else
            return response()->json([
                                        'success'   => false,
                                        'error'     => "Non ci sono tecnologie disponibili!"
                                    ])->setStatusCode(404);
    }
}