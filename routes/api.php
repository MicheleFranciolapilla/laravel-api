<?php

use App\Http\Controllers\Api\ApiProjectController as ApiProjectController;
use App\Http\Controllers\Api\ApiCategoryController as ApiCategoryController;
use App\Http\Controllers\Api\ApiTechnologyController as ApiTechnologyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// localhost:8000/api/projects
route::get('/projects', [ApiProjectController::class, 'index'])->name('api.projects.index');
route::get('/projects/{slug}', [ApiProjectController::class, 'show'])->name('api.projects.show');

// localhost:8000/api/categories
route::get('/categories', [ApiCategoryController::class, 'index'])->name('api.categories.index');

// localhost:8000/api/technologies
route::get('/technologies', [ApiTechnologyController::class, 'index'])->name('api.technologies.index');
