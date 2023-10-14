<?php

use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');  //cambiar
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('pedidos', 'App\Http\Controllers\PedidoController')->middleware('auth');
Route::get('/proforma', 'App\Http\Controllers\PedidoController@proforma')->name('pedidos.proforma')->middleware('auth');
Route::resource('detallepedido', 'App\Http\Controllers\DetallePedidoController')->middleware('auth');
Route::get('/cargar-productos-por-categoria/{categoria}', 'App\Http\Controllers\PedidoController@cargarProductosPorCategoria');

Route::resource('personas', 'App\Http\Controllers\UserController')->middleware('auth');
Route::get('/clientes', 'App\Http\Controllers\UserController@clientes')->name('clientes.index')->middleware('auth');
Route::get('/administradores', 'App\Http\Controllers\UserController@administradores')->name('administradores.index')->middleware('auth');

Route::resource('categorias', 'App\Http\Controllers\CategoriaController')->middleware('auth');
Route::resource('productos', 'App\Http\Controllers\ProductoController')->middleware('auth');


Route::prefix('ubicaciones')->middleware('auth')->group(function () {
    Route::get('{cliente_id}', [UbicacionController::class, 'index'])->name('ubicaciones.index');
    Route::get('create/{cliente_id}', [UbicacionController::class, 'create'])->name('ubicaciones.create');
    Route::post('store/{cliente_id}', [UbicacionController::class, 'store'])->name('ubicaciones.store');
    Route::get('edit/{ubicacion_id}', [UbicacionController::class, 'edit'])->name('ubicaciones.edit');
    Route::put('update/{ubicacion_id}', [UbicacionController::class, 'update'])->name('ubicaciones.update');
    Route::delete('destroy/{ubicacion_id}', [UbicacionController::class, 'destroy'])->name('ubicaciones.destroy');
});

