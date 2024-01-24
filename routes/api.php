<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DjController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HobbyController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\DancerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CommentaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/***********************
 *** AUTHENTICATION ****
/******************* */

// routes for authentication
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// redirect on route after click email verified email
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifiedAuthEmail'])
    ->middleware(['signed'])->name('verification.verify');

/**********************
 *** FORGOT PASSWORD ***
/******************* */

// send email for update password
Route::post('/forgot-password', [UserController::class, 'forgotPassword'])
    ->name('password.email');
// redirect on front for update password
Route::get('/reset-password/{token}', [UserController::class, 'redirectForgotPassword'])
    ->name('password.reset');
// update password
Route::post('/reset-password', [UserController::class, 'updateForgotPassword'])
    ->name('password.update');

/**********************
 *** CONNECTED USER ***
/******************* */

// routes user connected
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // routes auth
    Route::get('auth/verified', [AuthController::class, 'verifiedAuth'])
        ->middleware('ispublic');
    Route::delete('auth/logout', [AuthController::class, 'logout'])
        ->middleware('ispublic');

    // route user
    Route::get('user/profil', [UserController::class, 'getProfil'])
        ->middleware('ispublic');
    Route::put('user/profil/update', [UserController::class, 'updateProfil'])
        ->middleware('ispublic');
    Route::put('user/profil/update/password', [UserController::class, 'updatePassword'])
        ->middleware('ispublic');
    Route::get('users', [UserController::class, 'getAll']);//->middleware('isadmin');
    Route::get('user/{id}', [UserController::class, 'getOne']);//->middleware('isadmin');
    Route::get('user/{iduser}/update-role/{idrole}', [UserController::class, 'updateRoleOfUser'])
        ->middleware('isadmin');
    Route::delete('user/delete', [UserController::class, 'deleteCurrent'])
        ->middleware('ispublic');
    Route::delete('user/delete/{id}', [UserController::class, 'delete'])
        ->middleware('isroot');
    Route::post('user/upload/avatar', [UserController::class, 'uploadAvatar'])
        ->middleware('ispublic');

    // route roles
    Route::get('roles', [RoleController::class, 'getAll'])
        ->middleware(['isadmin']);
    Route::get('role/{id}', [RoleController::class, 'getOne'])
        ->middleware(['isroot']);
    Route::post('role/create', [RoleController::class, 'create'])
        ->middleware(['isroot']);
    Route::put('role/update/{id}', [RoleController::class, 'update'])
        ->middleware(['isroot']);
    Route::delete('role/delete/{id}', [RoleController::class, 'delete'])
        ->middleware(['isroot']);

    // route lands
    Route::post('land/create', [LandController::class, 'create']);
        //->middleware('isadmin');
    Route::put('land/update/{id}', [LandController::class, 'update']);
        //->middleware('isadmin');
    Route::delete('land/delete/{id}', [LandController::class, 'delete']);
        //->middleware('isadmin');
    Route::post('land/uploads/{id}', [LandController::class, 'uploadFiles']);
        //->middleware('isadmin');

    // route tenants
    Route::post('tenant/create', [TenantController::class, 'create']);
        //->middleware('isadmin');
    Route::put('tenant/update/{id}', [TenantController::class, 'update']);
        //->middleware('isadmin');
    Route::delete('tenant/delete/{id}', [TenantController::class, 'delete']);
        //->middleware('isadmin'); 
        
    // route picture
    Route::post('picture/update/{id}', [PictureController::class, 'updateImage']);
        //->middleware('isadmin');
    Route::delete('picture/delete/{id}', [PictureController::class, 'delete']);
        //->middleware('isadmin');
    Route::get('picture/{id}/update/{favori}', [PictureController::class, 'updateFavori']);
        //->middleware('isadmin');
   
    // route clubs
    Route::post('club/create', [ClubController::class, 'create']);
    //->middleware('managerclub');
    Route::put('club/update/{id}', [ClubController::class, 'update']);
   // ->middleware('managerclub');
    Route::delete('club/delete/{id}', [ClubController::class, 'delete']);
    //->middleware('managerclub');
    Route::post('club/uploads/{id}', [ClubController::class, 'uploadFiles']);
    //->middleware('managerclub');

    // route parties
    Route::post('party/create', [PartyController::class, 'create']);
    //->middleware('managerclub');
    Route::put('party/update/{id}', [PartyController::class, 'update']);
    //->middleware('managerclub');
    Route::delete('party/delete/{id}', [PartyController::class, 'delete']);
    //->middleware('managerclub');
    Route::post('party/uploads/{id}', [PartyController::class, 'uploadFiles']);
    //->middleware('managerclub');

    // route dj
    Route::post('dj/create', [DjController::class, 'create']);
    //->middleware('managerdj');
    Route::put('dj/update/{id}', [DjController::class, 'update']);
    //->middleware('managerdj');
    Route::delete('dj/delete/{id}', [DjController::class, 'delete']);
    //->middleware('managerdj');
    Route::post('dj/uploads/{id}', [DjController::class, 'uploadFiles']);
   // ->middleware('managerdj');

    // route dancer
    Route::post('dancer/create', [DancerController::class, 'create']);
    //->middleware('managerdancer');
    Route::put('dancer/update/{id}', [DancerController::class, 'update']);
    //->middleware('managerdancer');
    Route::delete('dancer/delete/{id}', [DancerController::class, 'delete']);
    //->middleware('managerdancer');
    Route::post('dancer/uploads/{id}', [DancerController::class, 'uploadFiles']);
    //->middleware('managerdancer');
    });

    // route host
    Route::post('host/create', [HostController::class, 'create']);
    //->middleware('managerclub');
    Route::put('host/update/{id}', [HostController::class, 'update']);
    //->middleware('managerclub');
    Route::delete('host/delete/{id}', [HostController::class, 'delete']);
    //->middleware('managerclub');
    Route::post('host/uploads/{id}', [HostController::class, 'uploadFiles']);
    //->middleware('managerclub');

    // route shop
    Route::post('shop/create', [ShopController::class, 'create']);
    //->middleware('isManagerShop');
    Route::put('shop/update/{id}', [ShopController::class, 'update']);
    //->middleware('isManagerShop');
    Route::delete('shop/delete/{id}', [ShopController::class, 'delete']);
    //->middleware('isManagerShop');
    Route::post('shop/uploads/{id}', [ShopController::class, 'uploadFiles']);
    //->middleware('isManagerShop');

    // route hobby
    Route::post('hobby/create', [HobbyController::class, 'create']);
    //->middleware('isManagerHobby');
    Route::put('hobby/update/{id}', [HobbyController::class, 'update']);
    //->middleware('isManagerHobby');
    Route::delete('hobby/delete/{id}', [HobbyController::class, 'delete']);
    //->middleware('isManagerHobby');
    Route::post('hobby/uploads/{id}', [HobbyController::class, 'uploadFiles']);
    //->middleware('isManagerHobby');

     // route activity
     Route::post('activity/create', [ActivityController::class, 'create']);
     //->middleware('isManagerHobby');
     Route::put('activity/update/{id}', [ActivityController::class, 'update']);
     //->middleware('isManagerHobby');
     Route::delete('activity/delete/{id}', [ActivityController::class, 'delete']);
     //->middleware('isManagerHobby');
     Route::post('activity/uploads/{id}', [ActivityController::class, 'uploadFiles']);
     //->middleware('isManagerHobby')

     // route article
     Route::post('article/create', [ArticleController::class, 'create']);
     //->middleware('isManagerHobby');
     Route::put('article/update/{id}', [ArticleController::class, 'update']);
     //->middleware('isManagerHobby');
     Route::delete('article/delete/{id}', [ArticleController::class, 'delete']);
     //->middleware('isManagerHobby');
     Route::post('article/uploads/{id}', [ArticleController::class, 'uploadFiles']);
     //->middleware('isManagerHobby')

/********************
 *** NOT CONNECTED ***
/***************** */
// route lands
Route::get('lands', [LandController::class, 'getAll']);
Route::get('land/{id}', [LandController::class, 'getOne']);

// route tenants
Route::get('tenants', [TenantController::class, 'getAll']);
Route::get('tenant/{id}', [TenantController::class, 'getOne']);

//Route club
Route::get('/clubs', [ClubController::class, 'getAll']);
Route::get('/club/{id}', [ClubController::class, 'getOne']);

//Route dj
Route::get('/djs', [DjController::class, 'getAll']);
Route::get('/dj/{id}', [DjController::class, 'getOne']);

//Route dancer
Route::get('/dancers', [DancerController::class, 'getAll']);
Route::get('/dancer/{id}', [DancerController::class, 'getOne']);

//Route party
Route::get('/parties', [PartyController::class, 'getAll']);
Route::get('/party/{id}', [PartyController::class, 'getOne']);

//Route host
Route::get('/hosts', [HostController::class, 'getAll']);
Route::get('/host/{id}', [HostController::class, 'getOne']);

//Route shop
Route::get('/shops', [ShopController::class, 'getAll']);
Route::get('/shop/{id}', [ShopController::class, 'getOne']);

//Route article
Route::get('/articles', [ArticleController::class, 'getAll']);
Route::get('/article/{id}', [ArticleController::class, 'getOne']);

//Route hobby
Route::get('/hobbies', [HobbyController::class, 'getAll']);
Route::get('/hobby/{id}', [HobbyController::class, 'getOne']);

//Route activity
Route::get('/activities', [ActivityController::class, 'getAll']);
Route::get('/activity/{id}', [ActivityController::class, 'getOne']);

// route commentaire club
Route::get('/commentaireClub', [CommentaireController::class, 'getAll']);
Route::get('/commentaireClub/{id}', [CommentaireController::class, 'getOne']);
Route::post('/commentaireClub/add', [CommentaireController::class, 'store'])->name('comment.add');
Route::put('/commentaireClub/update/{id}', [CommentaireController::class, 'update']);
Route::delete('/commentaireClub/delete/{id}', [CommentaireController::class, 'delete']);

