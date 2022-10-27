<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');





Route::get('/', ['as'=>'frontend.index','uses'=>'Frontend\IndexController@index']);

Route::get('login', 'Frontend\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Frontend\Auth\LoginController@login')->name('login');
Route::post('logout', 'Frontend\Auth\LoginController@logout')->name('logout');
Route::get('register', 'Frontend\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Frontend\Auth\RegisterController@register')->name('register');
Route::get('password/reset', 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Frontend\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Frontend\Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/confirm', 'Frontend\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Frontend\Auth\ConfirmPasswordController@confirm')->name('password.confirm');
        
Route::get('email/verify', 'Frontend\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Frontend\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Frontend\Auth\VerificationController@resend')->name('verification.resend');


Route::group(['middleware'=>'verified'],function(){
    Route::get('/dashboard', ['as'=>'frontend.dashboard','uses'=>'Frontend\UserController@index']);
    Route::get('/create-post', ['as'=>'frontend.user.createpost','uses'=>'Frontend\UserController@create_post']);
    Route::post('/store-post', ['as'=>'frontend.user.storepost','uses'=>'Frontend\UserController@store_post']);

        Route::get('/edit-post/{post_id}', ['as'=>'frontend.user.editpost','uses'=>'Frontend\UserController@edit_post']);
    Route::put('/update-post/{post_id}', ['as'=>'frontend.user.updatepost','uses'=>'Frontend\UserController@update_post']);

    Route::post('user/post/media/destroy/{media_id}', ['as'=>'frontend.user.postmediadestroy','uses'=>'Frontend\UserController@post_media_destroy']);

    Route::delete('user/post/destroy/{post_id}', ['as'=>'frontend.user.postdestroy','uses'=>'Frontend\UserController@post_destroy']);

    Route::get('user/comments', ['as'=>'frontend.user.comments','uses'=>'Frontend\UserController@show_comments']);

    Route::get('/edit-comment/{comment_id}', ['as'=>'frontend.user.editcomment','uses'=>'Frontend\UserController@edit_comment']);

    Route::put('/update-comment/{comment_id}', ['as'=>'frontend.user.updatecomment','uses'=>'Frontend\UserController@update_comment']);

    Route::delete('user/comment/destroy/{comment_id}', ['as'=>'frontend.user.commentdestroy','uses'=>'Frontend\UserController@comment_destroy']);


    Route::get('/edit-user', ['as'=>'frontend.user.edituser','uses'=>'Frontend\UserController@edit_user']);


Route::post('/update-user', ['as'=>'frontend.user.updateuser','uses'=>'Frontend\UserController@update_user']);
Route::post('/update-userpassword', ['as'=>'frontend.user.updatepassword','uses'=>'Frontend\UserController@update_userpassword']);

Route::any('/user/notification/get','Frontend\NotificationController@getNotificatons');
Route::any('/user/notification/read','Frontend\NotificationController@markAsRead');
Route::any('/user/notification/read/{id}','Frontend\NotificationController@markAsReadAndRedirect');



});


Route::prefix('admin')->group(function () {

    Route::get('login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'Backend\Auth\LoginController@login')->name('admin.login');
Route::post('logout', 'Backend\Auth\LoginController@logout')->name('admin.logout');
// Route::get('register', 'Backend/Auth\RegisterController@showRegistrationForm')->name('admin.register');
// Route::post('register', 'Backend/Auth\RegisterController@register');
Route::get('password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('password/email', 'Backend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('password/reset/{token}', 'Backend\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('password/reset', 'Backend\Auth\ResetPasswordController@reset')->name('admin.password.update');
Route::get('password/confirm', 'Backend\Auth\ConfirmPasswordController@showConfirmForm')->name('admin.password.confirm');
Route::post('password/confirm', 'Backend\Auth\ConfirmPasswordController@confirm');
Route::group(['middleware'=>['roles','role:admin|editor']],function () {
Route::get('/index', 'Backend\IndexController@index');
Route::resource('/posts', 'Backend\PostsController');
Route::resource('/pages', 'Backend\PagesController');
Route::resource('/post_comments', 'Backend\PostCommentsController');
Route::resource('/post_categories', 'Backend\PostCategoriesController');
Route::resource('/users', 'Backend\UsersController');
Route::resource('/contact_us', 'Backend\ContactUsController');
Route::resource('/supervisors', 'Backend\SupervisorsController');
Route::resource('/settings', 'Backend\SettingsController');
});
        
// Route::get('email/verify', 'Backend\Auth\VerificationController@show')->name('admin.verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Backend\Auth\VerificationController@verify')->name('admin.verification.verify');
// Route::post('email/resend', 'Backend\Auth\VerificationController@resend')->name('admin.verification.resend');
    
});




Route::get('/{post}', ['as'=>'post.show','uses'=>'Frontend\IndexController@post_show']);
Route::post('/{post}', ['as'=>'post.comment','uses'=>'Frontend\IndexController@post_comment']);

Route::get('search/search', ['as'=>'search','uses'=>'Frontend\IndexController@search']);

Route::get('contact/contact', ['as'=>'frontend.contact','uses'=>'Frontend\IndexController@contact_show']);
Route::post('contact/contact', ['as'=>'frontend.contact','uses'=>'Frontend\IndexController@post_contact']);

Route::get('/category/{category_slug}', ['as'=>'frontend.category.posts','uses'=>'Frontend\IndexController@category']);

Route::get('/archive/{date}', ['as'=>'frontend.archive.posts','uses'=>'Frontend\IndexController@archive']);

Route::get('/author/{username}', ['as'=>'frontend.author.posts','uses'=>'Frontend\IndexController@author']);