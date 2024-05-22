<?php

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


Route::get('/login', function () {
    return redirect('/admin/login');
});

Route::get('/municipios', [\App\Http\Controllers\DireccionController::class, 'getMunicipios'])->name('municipios');

Route::get('/', \App\Livewire\PaginaInicial::class);

Route::get('/categorias', \App\Livewire\CategoriasPage::class);
Route::get('/productos', \App\Livewire\ProductosPage::class);
Route::get('/carrito', \App\Livewire\CarritoPage::class);
Route::get('/productos/{slug}', \App\Livewire\DetallesProductoPage::class);


Route::middleware('auth')->group(function () {
    Route::get('logout', function (){
       auth()->logout();
       return redirect('/');
    });
    Route::get('/pedido', \App\Livewire\PedidoPage::class);
    Route::get('/mis-pedidos', \App\Livewire\MisPedidosPage::class);
    Route::get('/mis-pedidos/{orden}', \App\Livewire\DetallesPedidoPage::class);
    Route::get('/exito', \App\Livewire\ExitoPage::class);
    Route::get('/cancelar', \App\Livewire\CancelarPage::class);
});


Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\LoginPage::class)->name('login');
    Route::get('/registro', \App\Livewire\Auth\RegisterPage::class);
    Route::get('/recuperacion', \App\Livewire\Auth\ForgotPage::class)->name('password.request');
    Route::get('/reinicio/{token}', \App\Livewire\Auth\ResetPasswordPage::class)->name('password.reset');
});


