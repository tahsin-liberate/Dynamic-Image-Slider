<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sliderController; //app/Http/Controllers/sliderController.php

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
    return view('welcome');
});

Route::get('/slider', [sliderController::class, 'getData'])->name('slider_home'); //app/Http/Controllers/Api/ConsignmentsController.php

// Route::post('/update-orders', [sliderController::class, 'updateOrder'])->name('update_orders');

Route::post('/image-slider', [sliderController::class, 'store'])->name('image_slider.store');

Route::delete('/image-slider/{id}', [sliderController::class, 'destroy'])->name('image_slider.destroy');

Route::post('/update-orders/{id}', [sliderController::class, 'updateOrder']);
