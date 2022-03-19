<?php

// Defining the list of routes
use Frontify\ColorApi\Http\Controllers\ColorController;
use Frontify\ColorApi\Http\Routing\Handler;
use Frontify\ColorApi\Http\Routing\Route;

return [
    Route::get('color_index', '/api/colors', new Handler(ColorController::class, 'index')),
    Route::post('color_save', '/api/colors', new Handler(ColorController::class, 'save')),
    Route::put('color_update', '/api/colors/{id}', new Handler(ColorController::class, 'update')),
    Route::delete('color_delete', '/api/colors/{id}', new Handler(ColorController::class, 'delete')),
];
