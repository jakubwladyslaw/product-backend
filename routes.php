<?php
Route::prefix('api')->middleware('api')->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('{id}', 'Jakub\ProductBackend\Http\Controllers\ProductController@productGet')->name('product.get');
        Route::put('{id}', 'Jakub\ProductBackend\Http\Controllers\ProductController@productEdit')->name('product.edit');
        Route::delete('{id}',
            'Jakub\ProductBackend\Http\Controllers\ProductController@productDelete')->name('product.delete');
        Route::post('', 'Jakub\ProductBackend\Http\Controllers\ProductController@productAdd');
    });

    Route::prefix('products')->group(function () {
        Route::get('', 'Jakub\ProductBackend\Http\Controllers\ProductsController@productsGet')->name('products.get');
    });
});