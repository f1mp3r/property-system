<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PropertyController::class, 'list'])->name('index');
Route::get('/property/{property}', [PropertyController::class, 'view'])->name('view');
Route::get('/property/{property}/delete/{agent}', [PropertyController::class, 'deleteAgent'])->name('property.delete_agent');
Route::put('/property/{property}', [PropertyController::class, 'addAgent'])->name('property.add_agent');

Route::get('/agent/', [AgentController::class, 'list'])->name('agent.list');
Route::get('/agent/{agent}', [AgentController::class, 'view'])
    ->name('agent.view')
    ->whereNumber('agent')
;
Route::get('/agent/create', [AgentController::class, 'create'])->name('agent.create');
Route::post('/agent/store', [AgentController::class, 'store'])->name('agent.store');
