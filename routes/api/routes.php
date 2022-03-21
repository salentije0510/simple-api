<?php

// Defining the list of routes
use Frontify\ColorApi\Controllers\ColorController;
use Frontify\ColorApi\Routing\Route;

return [
    Route::get('color_index', '/api/colors', [ColorController::class, 'index'], ['auth' => true]),
    Route::get('color_view', '/api/colors/{id}', [ColorController::class, 'view'], ['auth' => true]),
    Route::post('color_save', '/api/colors', [ColorController::class, 'save'], ['auth' => true]),
    Route::put('color_update', '/api/colors/{id}', [ColorController::class, 'update'], ['auth' => true]),
    Route::delete('color_delete', '/api/colors/{id}', [ColorController::class, 'delete'], ['auth' => true]),
];
