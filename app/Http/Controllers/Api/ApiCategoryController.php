<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Category as Category;

class ApiCategoryController extends Controller
{
    function index()
    {
        $all_categories = Category::All();
        if (count($all_categories) != 0)
            return response()->json([
                                        'success'   => true,
                                        'categories'  => $all_categories
                                    ]);
        // else
        //     return response()->json([
        //                                 'success'   => false,
        //                                 'error'     => "Non ci sono categorie disponibili!"
        //                             ])->setStatusCode(404);
    }
}
