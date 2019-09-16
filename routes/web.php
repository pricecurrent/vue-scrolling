<?php

# cats
Route::get('cats', 'CatsController@index');

# Cat comments
Route::get('cats/{cat}/comments', 'CatCommentsController@index');
Route::post('cats/{cat}/comments', 'CatCommentsController@store');

Route::get('/', function () {
    return view('welcome');
});
