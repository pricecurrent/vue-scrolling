<?php

Route::get('cats', 'CatsController@index');

Route::get('/', function () {
    return view('welcome');
});
