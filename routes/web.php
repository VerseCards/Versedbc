<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentDeatailController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PaymentWallPaymentController;
use App\Http\Controllers\MercadoPaymentController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\LeadContactController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\UserlogController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\AiTemplateController;



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


require __DIR__.'/auth.php';


Route::any('cookie_consent', [SystemController::class, 'CookieConsent'])->name('cookie-consent');
Route::any('card_cookie_consent', [BusinessController::class, 'cardCookieConsent'])->name('card-cookie-consent');

Route::middleware(['2fa', 'auth', 'impersonate'])->group(function () {
	
		Route::get('/', [HomeController::class, 'landingPage'])->middleware('XSS')->name('home');
		Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['XSS','auth'])->name('dashboard');
		Route::get('/dashboard/{id}', [HomeController::class, 'changeCurrantBusiness'])->name('business.change');
		
		Route::get('/appointment-calendar/{id?}', [AppointmentDeatailController::class, 'getCalenderAllData'])->middleware(['XSS','auth'])->name('appointment.calendar');

		Route::get('/appointment-note/{id?}', [AppointmentDeatailController::class, 'add_note'])->middleware(['XSS','auth'])->name('appointment.add-note');
		Route::post('/appointment-note-store/{id?}', [AppointmentDeatailController::class, 'note_store'])->middleware(['XSS','auth'])->name('appointment.note.store');
		Route::get('get-appointment-detail/{id}', [AppointmentDeatailController::class, 'getAppointmentDetails'])->middleware(['XSS','auth'])->name('appointment.details');

		Route::any('/get_appointment_data',[AppointmentDeatailController::class, 'get_appointment_data'])->middleware(['XSS','auth'])->name('get_appointment_data');
		Route::get('/impersonate/{id}', 'ImpersonateController@start')->middleware('XSS','auth')->name('impersonate');
		//Route::get('/impersonate/stop/{id}', 'ImpersonateController@stop')->name('impersonate.stop');
		
		Route::resource('business', BusinessController::class)->middleware(['XSS','auth']);
		Route::get('business-allcards', [BusinessController::class,'allCards'])->name('business.allcards');
Route::middleware(['auth','impersonate','XSS'])->group(function () {
    Route::get('business/edit/{id}', [BusinessController::class,'edit'])->name('business.edit');
    Route::get('business/theme-edit/{id}', [BusinessController::class,'edit2'])->name('business.edit2');
    Route::get('business/analytics/{id}', [BusinessController::class,'analytics'])->name('business.analytics');
    Route::post('business/edit-theme/{id}', [BusinessController::class,'editTheme'])->name('business.edit-theme');
    Route::post('business/domain-setting/{id}', [BusinessController::class,'domainsetting'])->name('business.domain-setting');
	

    Route::resource('appointments', AppointmentDeatailController::class);
    Route::get('appoinments/', [AppointmentDeatailController::class,'index'])->name('appointments.index');
	
	Route::get('/impersonate/{id}', 'ImpersonateController@start')->middleware('XSS','auth')->name('impersonate');
    Route::get('/impersonate-stop/', 'ImpersonateController@stop')->middleware('XSS','auth')->name('impersonate.stop');
    Route::get('business/preview/card/{slug}', [BusinessController::class,'getcard'])->name('business.template');
    Route::delete('business/destroy/{id}', [BusinessController::class,'destroy'])->name('business.destroy');

    Route::get('profile', [UserController::class,'profile'])->name('profile');
	
    Route::post('edit-profile', [UserController::class,'editprofile'])->name('update.account');

    Route::resource('systems', SystemController::class);
    Route::post('email-settings', [SystemController::class,'saveEmailSettings'])->name('email.settings');
    Route::post('company-settings-store', [SystemController::class,'storeCompanySetting'])->name('company.settings.store');
    Route::post('test-mail', [SystemController::class,'testMail'])->name('test.mail')->middleware(['auth','XSS']);
    Route::post('test-mail/send', [SystemController::class,'testSendMail'])->name('test.send.mail')->middleware(['auth','XSS']);

    Route::get('change-language/{lang}', [UserController::class,'changeLanquage'])->name('change.language');
    Route::get('manage-language/{lang}', [LanguageController::class,'manageLanguage'])->name('manage.language');
    Route::post('store-language-data/{lang}', [LanguageController::class,'storeLanguageData'])->name('store.language.data');
    Route::get('create-language', [LanguageController::class,'createLanguage'])->name('create.language');
    Route::post('store-language', [LanguageController::class,'storeLanguage'])->name('store.language');
    Route::delete('/lang/{lang}', [LanguageController::class,'destroyLang'])->name('lang.destroy');

     //Role
     Route::resource('roles', RoleController::class);
     Route::resource('permissions', PermissionController::class);
     Route::resource('users', UserController::class);

     //Contact Notes
    Route::get('/contact-note/{id?}', [ContactsController::class, 'add_note'])->middleware('XSS','auth')->name('contact.add-note');
    Route::post('/contact-note-store/{id?}', [ContactsController::class, 'note_store'])->middleware('XSS','auth')->name('contact.note.store');
	
	Route::get('/leadcontact-note/{id?}', [LeadContactController::class, 'add_note'])->middleware('XSS','auth')->name('leadcontact.add-note');
    Route::post('/leadcontact-note-store/{id?}', [LeadContactController::class, 'note_store'])->middleware('XSS','auth')->name('leadcontact.note.store');

     //Pixel
     Route::get('pixel/create/{id}', [BusinessController::class, 'pixel_create'])->name('pixel.create');
     Route::post('pixel', [BusinessController::class, 'pixel_store'])->name('pixel.store');
     Route::delete('pixel-delete/{id}', [BusinessController::class, 'pixeldestroy'])->name('pixel.destroy');
     Route::resource('userlogs', UserlogController::class);
	 Route::get('nfc-history', [UserlogController::class, 'loadTaps'])->name('loadTaps');
	 Route::get('pending_approval', [BusinessController::class, 'pendingApproval'])->name('pendingApproval');
	 Route::get('showPending/{id}', [BusinessController::class, 'showPending'])->name('showPending');
	 Route::get('show-user-pending/{id}', [UserController::class, 'showUserPending'])->name('showUserPending');
	 Route::post('approve-changes/{id}/{cid}', [BusinessController::class, 'approveChanges'])->name('approveChanges');
	 Route::get('activity-log', [BusinessController::class, 'activityLog'])->name('activityLog');
	 Route::get('new-user-approval', [UserController::class, 'pendingNewIUserApproval'])->name('newUserLog');
	 Route::post('approve-new-user-admin/{id}', [UserController::class, 'approveNewUserAdmin'])->name('approveNewUserAdmin');
	 Route::get('delete-approval/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
	 Route::post('approve-delete/{id}', [UserController::class, 'approveUserDelete'])->name('approveUserDelete');
	 Route::get('delete-user-pending/{id}', [UserController::class, 'deleteUserPending'])->name('deleteUserPending');
	 Route::get('user-update/{id}', [UserController::class, 'updateUser'])->name('userUpdate');
	 Route::get('update-user-pending/{id}', [UserController::class, 'updateUserPending'])->name('updateUserPending');
	 Route::post('approve-update/{id}', [UserController::class, 'approveUserUpdate'])->name('approveUserUpdate');
	 Route::post('approve-login-status/{id}', [UserController::class, 'approveLoginStatus'])->name('approveLoginStatus');
	 Route::get('export/activity-log', [BusinessController::class, 'exportActivityLog'])->name('activitylog.export');

     Route::resource('webhook', WebhookController::class);
     Route::post('cookie_setting', [SystemController::class, 'saveCookieSettings'])->middleware('XSS','auth')->name('cookie.setting');



    Route::get('user-login/{id}', 'UserController@LoginManage')->name('users.login');
	Route::get('admin-status/{id}', 'UserController@makeAdmin')->name('users.make_admin');
	Route::get('all-admins', 'UserController@allAdmins')->name('users.view_admin');
	Route::post('approve-maker-admin/{id}', 'UserController@approveMakerAdmin')->name('approveMakerAdmin');
	Route::get('run-migrate-now', 'UserController@optimizeApp')->name('users.runNow');
	
	
	
	
	
	/*====================================Contacts====================================================*/
	Route::resource('leadcontact', LeadContactController::class);
	Route::get('/contacts/show', [ContactsController::class, 'index'])->middleware('XSS','auth')->name('contacts.index');
	
	Route::get('/leads/show', [LeadContactController::class, 'index'])->middleware('XSS','auth')->name('leadcontact.index');
	Route::get('/leads/campaign', [LeadContactController::class, 'campaign'])->middleware('XSS','auth')->name('campaign.index');
	Route::get('/leads/campaign/{id}/{business_id_key}', [LeadContactController::class, 'campaignByLead'])->middleware('XSS','auth')->name('campaign.lead');
	Route::get('export/leads', [LeadContactController::class, 'get_lead_data'])->name('leads.export');
	Route::get('export/leads-campaign', [LeadContactController::class, 'get_lead_data_campaign'])->name('leads_campaign.export');
	Route::get('export/contacts', [ContactsController::class, 'get_lead_data'])->name('contacts.export');
	Route::delete('/contacts/delete/{id}', [ContactsController::class, 'destroy'])->middleware('XSS','auth')->name('contacts.destroy');
	Route::delete('/leads/delete/{id}', [LeadContactController::class, 'destroy'])->middleware('XSS','auth')->name('leadcontact.destroy');
	
	Route::get('/contacts/business/show{id}', [ContactsController::class, 'index'])->middleware('XSS','auth')->name('business.contacts.show');
	Route::get('/contacts/edit/{id}', [ContactsController::class, 'edit'])->middleware('XSS','auth')->name('contacts.edit');
	Route::post('/contacts/update/{id}', [ContactsController::class, 'update'])->middleware('XSS','auth')->name('Contacts.update');

	/*========================================================================================================================*/
	
	Route::get('business/{slug}/get_card', [BusinessController::class, 'cardpdf'])->name('get.card');
	Route::get('businessqr/download/', [BusinessController::class, 'downloadqr'])->middleware('XSS', 'auth')->name('download.qr');
	Route::post('business/block-setting/{id}', [BusinessController::class, 'blocksetting'])->middleware('XSS','auth')->name('business.block-setting');

	Route::post('business/custom-js-setting/{id}', [BusinessController::class, 'savejsandcss'])->name('business.custom-js-setting');
	Route::post('business/seo/{id}', [BusinessController::class, 'saveseo'])->name('business.seo-setting');
	Route::post('business/googlefont/{id}', [BusinessController::class, 'savegooglefont'])->name('business.googlefont-setting');
	Route::post('business/setpassword/{id}', [BusinessController::class, 'savepassword'])->name('business.password-setting');
	Route::post('business/setgdpr/{id}', [BusinessController::class, 'savegdpr'])->name('business.gdpr-setting');
	Route::post('business/setbranding/{id}', [BusinessController::class, 'savebranding'])->name('business.branding-setting');

	Route::post('business/destroy/', [BusinessController::class, 'destroyGallery'])->name('destory.gallery');

	Route::post('business/pwa/{id}', [BusinessController::class, 'savePWA'])->name('business.pwa-setting');
	Route::post('business/cookie/{id}', [BusinessController::class, 'saveCookiesetting'])->name('business.cookie-setting');
	Route::post('business/custom_qrcode/{id}', [BusinessController::class, 'saveCustomQrsetting'])->name('business.qrcode_setting');
	
	
	Route::get('email_template_lang/{id}/{lang?}', [EmailTemplateController::class, 'manageEmailLang'])->middleware('XSS','auth')->name('manage.email.language');
	Route::put('email_template_lang/{id}/', [EmailTemplateController::class, 'updateEmailSettings'])->middleware('XSS','auth')->name('updateEmail.settings');

	Route::post('storage-settings', [SystemController::class, 'storageSettingStore'])->middleware('XSS','auth')->name('storage.setting.store');
	Route::post('/google-settings',[SystemController::class,'saveGoogleCalendaSetting'])->name('setting.GoogleCalendaSetting')->middleware(['auth','XSS']);
	
	
	
	//End Middleware 2fa
});


	
		Route::group(['prefix'=>'multi-factor-authenticator'], function(){
			Route::get('/','LoginSecurityController@show2faForm')->name('show2faForm');
			Route::post('/generateSecret','LoginSecurityController@generate2faSecret')->name('generate2faSecret');
			Route::post('/enable2fa','LoginSecurityController@enable2fa')->name('enable2fa');
			Route::post('/disable2fa','LoginSecurityController@disable2fa')->name('disable2fa');
			 //Route::middleware('two_fa')->post('/2faVerify', function () { return redirect(URL()->previous()); })->name('2faVerify');

			// 2fa middleware
			//Route::post('/2faVerify', function () {return redirect(URL()->previous());})->name('2faVerify');
			Route::middleware('2fa')->post('/2faVerify', function () { return redirect('/'); })->name('2faVerify');
			
			//Route::post('/2faVerify', function () {return redirect('/')->name('2faVerify'); });
			
			
		});
});


Route::post('disable-language',[LanguageController::class,'disableLang'])->name('disablelanguage')->middleware(['auth','XSS']);
//================================= Custom Landing Page ====================================//
Route::post('/contacts/store/', [ContactsController::class, 'store'])->name('contacts.store');
Route::post('/leads/store/', [LeadContactController::class, 'store'])->name('leadcontact.store');
Route::get('/{slug}', [BusinessController::class, 'getcard']);
Route::post('appoinment/make-appointment', [AppointmentDeatailController::class, 'store'])->middleware('XSS')->name('appoinment.store');

Route::post('change-password', [UserController::class, 'updatePassword'])->name('update.password');
Route::get('/download/{slug}', [BusinessController::class, 'getVcardDownload'])->name('bussiness.save');



/*==================================Recaptcha====================================================*/

Route::post('/recaptcha-settings', [SystemController::class, 'recaptchaSettingStore'])->middleware('XSS','auth')->name('recaptcha.settings.store');
Route::post('/cache-clear', [SystemController::class, 'cacheClear'])->middleware('XSS','auth')->name('cache.settings.clear');





/*==============================================================================================================================*/

Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('user.reset');
Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');
Route::post('approve-password-reset-password/{id}', [UserController::class, 'approvePasswordReset'])->name('user.password.approve');


/*=============================*/

