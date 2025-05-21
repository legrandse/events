<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ShiftsController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CronTaskController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\WhatsappController;


use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Propaganistas\LaravelPhone\PhoneNumber;
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

Route::get('/', [WelcomeController::class, 'index'])->middleware(['guest'])->name('welcome');
Route::get('appredirect/{key}', function($key){
	$user_phone = new PhoneNumber(Crypt::decryptString($key),'BE');
	//dd($user_phone);
	// now find the user
	$user = User::where('phone',$user_phone->formatForMobileDialingInCountry('BE'))->first();
	if($user){
	      Auth::login($user); // login user automatically
	      if($user->password != null){
	      		return redirect('/home');
		  }
		  else {
		  	return redirect()->route('users.edit',['user'=>Crypt::encrypt( auth()->user()->id) ])
		  					->withErrors(['msg' => 'Please fill the missing field with your data.']);
		  }
	}else {
	      return redirect('/');
	}

})->name('appredirect');
Route::get('/crontask',[CronTaskController::class, 'executeTask']);
Route::get('/taskreminder/{days}',[CronTaskController::class, 'taskReminder']);
Route::get('/missingshiftreminder/{days}',[CronTaskController::class, 'missingShiftReminder']);

Route::get('/redirect', [SocialController::class, 'redirectFacebook']);
Route::get('/callback', [SocialController::class, 'facebookCallback']);
Route::get('/google', [SocialController::class, 'redirectGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialController::class, 'googleCallback']);

Route::post('/webhook/status',[WhatsappController::class, 'status'])->name('WStatus');
Route::post('/webhook/inbound',[WhatsappController::class, 'inbound'])->name('WInbound');
    
Auth::routes();


Route::group(['middleware' => ['auth'] ], function() {
   	Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RolesController::class);
    Route::resource('users', UsersController::class);
    Route::resource('events', EventsController::class);
    Route::resource('tasks', TasksController::class);
    Route::resource('shifts', ShiftsController::class);
    Route::PATCH('/home', [ShiftsController::class, 'massupdate'])->name('massupdate'); 
    Route::PATCH('/home/{shift}', [ShiftsController::class, 'updateShift'])->name('updateShift'); 
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/delivery',[SMSController::class, 'delivery'])->name('SMSDelivery');
    Route::get('/inbound',[SMSController::class, 'inbound'])->name('SMSDelivery');
    Route::get('/message',[WhatsappController::class, 'message'])->name('Wmessage');
   
  //  Route::PATCH('/home', [AjaxController::class, 'shiftSubmit'])->name('shiftSubmit'); 
});