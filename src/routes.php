<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

Route::post('comments', Config::get('comments.controller') . '@store')->name('comments.store');
Route::delete('comments/{comment}', Config::get('comments.controller') . '@destroy')->name('comments.destroy');
Route::put('comments/{comment}', Config::get('comments.controller') . '@update')->name('comments.update');
Route::post('comments/{comment}', Config::get('comments.controller') . '@reply')->name('comments.reply');

Route::post('like', Config::get('likes.controller') . '@like')->name('like.store');
Route::post('dislike', Config::get('likes.controller') . '@dislike')->name('like.destroy');
Route::post('totalLikes/{comment_id}', Config::get('likes.controller') . '@countLike')->name('like.total');
Route::get('list-liker/{comment_id}', Config::get('likes.controller') . '@getLiker')->name('likes.getlistliker');
