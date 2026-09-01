<?php
use App\Http\Controllers\App\AppAlertController;
use App\Http\Controllers\App\MobileAppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Callcenter\OperatorController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentGateways\StripeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Role\APIKeyController;
use App\Http\Controllers\Role\MyPermissionController;
use App\Http\Controllers\Role\MyRoleController;
use App\Http\Controllers\Role\MyUserController;
use App\Http\Controllers\Role\Security\TwoStepVerificationController;
use App\Http\Controllers\Role\Security\SecurityController;
use App\Http\Controllers\Setting\SettingAppController;
use App\Http\Controllers\Stripe\StripeController as StripeStripeController;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\PMM\CallCenter\Callcontroller;
use  App\Http\Controllers\PMM\Lookup\lookupController;
use App\Http\Controllers\PMM\CruncyController;
use App\Http\Controllers\UppSellController;
use App\Http\Controllers\GLSShipmentController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleIndexingController;
use App\Http\Controllers\Job\JobProcessingController;
use App\Http\Controllers\Job\JobsController;
use App\Http\Controllers\Job\JobUserController;
use App\Http\Controllers\PMM\Lookup\AddressController;
use App\Http\Controllers\PMM\Lookup\GlsProfile;
use App\Http\Controllers\Resume\CertificateController;
use App\Http\Controllers\Resume\ContactController;
use App\Http\Controllers\Resume\EducationController;
use App\Http\Controllers\Resume\ExperienceController;
use App\Http\Controllers\Resume\LanguageController;
use App\Http\Controllers\Resume\ResumeController;
use App\Http\Controllers\Resume\SkillController;
use App\Http\Controllers\Resume\SummaryController;
use App\Http\Controllers\Resume\TemplateController;
use App\Models\Resume\Template;
use Illuminate\Support\Facades\Artisan;

//adasdasdassdssasd
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'postLogin']);
    Route::any('logout', [LoginController::class, 'logout']);
    Route::resource('register', RegisterController::class);
    Route::get('verify-email/{code}', [RegisterController::class, 'verify']);


    Route::get("reset-email",[WebAuthController::class,'reset_email'])->name('webAuth.resetEmail');
    Route::post("reset-email-send",[WebAuthController::class,'reset_email_send'])->name('webAuth.resetEmailSend');
    Route::get("verify-my-email/{token}",[WebAuthController::class,'verify_email'])->name('webAuth.verifyEmail');
    Route::get("verify-my-email-address/{token}",[WebAuthController::class,'verify_email_address'])->name('webAuth.verifyEmailAddressView');
    Route::post("update-my-password",[WebAuthController::class,'update_password'])->name('webAuth.updatePassword');
    Route::post("verify-email-address",[WebAuthController::class,'verifyEmailAddress'])->name('webAuth.verifyEmailAddress');
    Route::prefix('products/sell')
      ->name('pmm.product.')
     ->group(function(){
     Route::get('/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'purchase'])->name('purchase')->middleware('setLang');
    });



Route::middleware(['2FA'])->group(function(){
Route::get('pwd',function(){
    my_balance(2);
    });
Route::middleware('auth')
    ->group(function () {
         Route::post('/card',[UserController::class,'card'])->name('user.card');
        Route::resource('profile', ProfileController::class);
    });

Route::post('updateBankInfo', [ProfileController::class,'updateBankInfo'])->name('updateBankInfo');
Route::get('change-password', [ProfileController::class, 'changePassword']);
Route::post('change-password', [ProfileController::class, 'changePasswordPost'])->name('changePasswordPost');

Route::middleware('auth')->get('dashboard', [DashboardController::class, 'index']);

// Route::prefix('users')
//             ->group(function () {
//                 Route::get('/', [UserController::class,'index']);
//                 Route::post('/add', [UserController::class,'add'])->name('roles.users.add');
//                 Route::post('/update/{id}', [UserController::class,'update'])->name('roles.users.update');
//                 Route::get('/delete/{id}', [UserController::class,'delete'])->name('roles.users.delete');
//             });
Route::prefix('roles')
->middleware('auth')
->group(function () {
    Route::prefix('roles')
    ->group(function () {
        Route::get('/', [MyRoleController::class,'index'])->name('roles.roles')->middleware('basic.permission:roles.roles.view');
        Route::get('/permissions/{id}', [MyRoleController::class,'permissions'])->name('roles.roles.permissions')->middleware('basic.permission:roles.roles.permissions');
        Route::post('/permissions-add/{role_id}', [MyRoleController::class,'add_permissions'])->name('roles.roles.permissions.add')->middleware('basic.permission:roles.roles.permissions.add');
        Route::post('/add', [MyRoleController::class,'add'])->name('roles.roles.add')->middleware('basic.permission:roles.roles.add');
        Route::post('/update/{id}', [MyRoleController::class,'update'])->name('roles.roles.update')->middleware('basic.permission:roles.roles.update');
        Route::get('/delete/{id}', [MyRoleController::class,'delete'])->name('roles.roles.delete')->middleware('basic.permission:roles.roles.remove');
    });
    Route::prefix('permissions')
    ->middleware(['admin'])
    ->group(function () {
        Route::get('/', [MyPermissionController::class,'index'])->name('roles.permissions')->middleware('basic.permission:roles.permissions.view');
        Route::post('/add', [MyPermissionController::class,'add'])->name('roles.permissions.add')->middleware('basic.permission:roles.permissions.add');
        Route::post('/update/{id}', [MyPermissionController::class,'update'])->name('roles.permissions.update')->middleware('basic.permission:roles.permissions.update');
        Route::get('/delete/{id}', [MyPermissionController::class,'delete'])->name('roles.permissions.delete')->middleware('basic.permission:roles.permissions.remove');;
    });
    Route::prefix('myusers')
    ->group(function () {
        Route::get('/', [MyUserController::class,'index'])->name('roles.users')->middleware('basic.permission:roles.users.view');
        Route::post('/add', [MyUserController::class,'add'])->name('roles.users.add')->middleware('basic.permission:roles.users.add');
        Route::post('/add-bill-pay-user', [MyUserController::class,'add_bill_pay_user'])->name('roles.users.add_bill_pay_user')->middleware('basic.permission:roles.users.add_bill_pay_user');
        Route::post('/update/{id}', [MyUserController::class,'update'])->name('roles.users.update')->middleware('basic.permission:roles.users.edit');
        Route::post('/update-bill-pay-user/{id}', [MyUserController::class,'update_bill_pay_user'])->name('roles.users.update_bill_pay_user')->middleware('basic.permission:roles.users.add_bill_pay_user');
        Route::get('/delete/{id}', [MyUserController::class,'delete'])->name('roles.users.delete')->middleware('basic.permission:roles.users.remove');
        Route::get('/roles/{id}', [MyUserController::class,'roles'])->name('roles.users.roles')->middleware('basic.permission:roles.users.remove');
        Route::get('/direct-permissions/{id}', [MyUserController::class,'direct_permissions'])->name('roles.users.direct_permissions')->middleware('basic.permission:roles.users.direct_permissions');
        Route::post('/add-direct-permissions/{id}', [MyUserController::class,'add_direct_permissions'])->name('roles.users.direct_permissions.add')->middleware('basic.permission:roles.users.direct_permissions');
        Route::post('/add-roles/{id}', [MyUserController::class,'add_roles'])->name('roles.users.roles.add');
        Route::get('/settings/{id}', [MyUserController::class,'settings'])->name('roles.users.settings')->middleware('basic.permission:user.settings');
        Route::post('/settings-update/{id}', [MyUserController::class,'update_settings'])->name('roles.users.update_settings')->middleware('basic.permission:user.settings');
        Route::post('/notification-settings-update/{id}', [MyUserController::class,'update_notification_settings'])->name('roles.users.update_notification_settings')->middleware('basic.permission:user.update_notification_settings');
    });
    Route::prefix('api-keys')
    ->group(function () {
        Route::get('/{id}', [APIKeyController::class,'index'])->name('api.keys.view')->middleware('basic.permission:api.keys.view');
        Route::post('/update/{user_id}', [APIKeyController::class,'update'])->name('api.keys.refresh')->middleware('basic.permission:api.keys.refresh');
 });
});



Route::middleware('auth')
    ->prefix('security')
    ->group(function () {
     Route::get('2FA',[TwoStepVerificationController::class,'index'])->name('security.2FA');
     Route::get('email/2FA',[TwoStepVerificationController::class,'email_2FA'])->name('security.2FA');
     Route::get('disable-2FA',[SecurityController::class,'disable_2fa'])->name('security.disable2fa');
     Route::post('verify-phone-number',[SecurityController::class,'verify_phone_number'])->name('security.verifyPhoneNumber');
     Route::post('Verify2FACode',[TwoStepVerificationController::class,'Verify2FACode'])->name('security.Verify2FACode');
     Route::post('VerifyEmail2FACode',[TwoStepVerificationController::class,'VerifyEmail2FACode'])->name('security.VerifyEmail2FACode');
     Route::post('verify-phone-number-step-2',[SecurityController::class,'verify_phone_number_step_2'])->name('security.verifyPhoneNumberStep_2');
    });
// });

Route::prefix('user')
        ->middleware('auth')
        ->group(function () {
                Route::post('/settings/update', [UserController::class,'updateSetting'])->name('user.settings.update');
        });

Route::middleware('auth')
    ->prefix('security')
    ->group(function () {
     Route::get('2FA',[TwoStepVerificationController::class,'index'])->name('security.2FA');
     Route::get('email/2FA',[TwoStepVerificationController::class,'email_2FA'])->name('security.2FA');
     Route::get('disable-2FA',[SecurityController::class,'disable_2fa'])->name('security.disable2fa');
     Route::post('verify-phone-number',[SecurityController::class,'verify_phone_number'])->name('security.verifyPhoneNumber');
     Route::post('Verify2FACode',[TwoStepVerificationController::class,'Verify2FACode'])->name('security.Verify2FACode');
     Route::post('VerifyEmail2FACode',[TwoStepVerificationController::class,'VerifyEmail2FACode'])->name('security.VerifyEmail2FACode');
     Route::post('verify-phone-number-step-2',[SecurityController::class,'verify_phone_number_step_2'])->name('security.verifyPhoneNumberStep_2');
    });


    Route::prefix('alerts')
     ->middleware(['auth'])
     ->group(function(){

     Route::get('/',[AppAlertController::class,'index'])->name('app.alerts.view');
     Route::post('/read',[AppAlertController::class,'read'])->name('app.alerts.read');
     Route::post('/read-all',[AppAlertController::class,'readAll'])->name('app.alerts.read_all');

     });
     Route::prefix('payment-profiles')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'index'])->name('paymentprofile.view')->middleware('basic.permission:pmm.paymentprofile.view|pmm.paymentprofile.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'search'])->name('paymentprofile.search')->middleware('basic.permission:pmm.paymentprofile.view|pmm.paymentprofile.full_control');
     Route::get('add',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'add'])->name('paymentprofile.add')->middleware('basic.permission:pmm.paymentprofile.add|pmm.paymentprofile.full_control');
     Route::post('add',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'addPost'])->name('paymentprofile.addPost')->middleware('basic.permission:pmm.paymentprofile.add|pmm.paymentprofile.full_control');
     Route::get('update/{id}',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'update'])->name('paymentprofile.update')->middleware('basic.permission:pmm.paymentprofile.view|pmm.paymentprofile.full_control');
     Route::post('update/{id}',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'updatePost'])->name('paymentprofile.updatePost')->middleware('basic.permission:pmm.paymentprofile.update|pmm.paymentprofile.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'remove'])->name('paymentprofile.remove')->middleware('basic.permission:pmm.paymentprofile.remove|pmm.paymentprofile.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\PMM\PaymentProfile\PMMPaymentProfileController::class,'logs'])->name('paymentprofile.logs')->middleware('basic.permission:pmm.paymentprofile.logs&paymentprofile.full_control');

    });
     Route::prefix('withdrawal')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'index'])->name('withdrawal.view')->middleware('basic.permission:pmm.withdrawal.view|pmm.withdrawal.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'search'])->name('withdrawal.search')->middleware('basic.permission:pmm.withdrawal.view|pmm.withdrawal.full_control');
     Route::get('add',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'add'])->name('withdrawal.add')->middleware('basic.permission:pmm.withdrawal.add|pmm.withdrawal.full_control');
     Route::post('add',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'addPost'])->name('withdrawal.addPost')->middleware('basic.permission:pmm.withdrawal.add|pmm.withdrawal.full_control');
     Route::get('update/{id}',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'update'])->name('withdrawal.update')->middleware('basic.permission:pmm.withdrawal.view|pmm.withdrawal.full_control');
     Route::post('update/{id}',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'updatePost'])->name('withdrawal.updatePost')->middleware('basic.permission:pmm.withdrawal.update|pmm.withdrawal.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'remove'])->name('withdrawal.remove')->middleware('basic.permission:pmm.withdrawal.remove|pmm.withdrawal.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\PMM\Withdrawal\PMMWithdrawalController::class,'logs'])->name('withdrawal.logs')->middleware('basic.permission:pmm.withdrawal.logs&withdrawal.full_control');

    });
     Route::prefix('products')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\Product\PMMProductController::class,'index'])->name('products.view')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Product\PMMProductController::class,'search'])->name('products.search')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
     Route::get('add',[App\Http\Controllers\PMM\Product\PMMProductController::class,'add'])->name('products.add')->middleware('basic.permission:pmm.products.add|pmm.products.full_control');
     Route::get('request',[App\Http\Controllers\PMM\Product\PMMProductController::class,'request'])->name('products.request')->middleware('basic.permission:pmm.products.request|pmm.products.full_control');
     Route::post('request',[App\Http\Controllers\PMM\Product\PMMProductController::class,'requestPost'])->name('products.requestPost')->middleware('basic.permission:pmm.products.request|pmm.products.full_control');
     Route::post('add',[App\Http\Controllers\PMM\Product\PMMProductController::class,'addPost'])->name('products.addPost')->middleware('basic.permission:pmm.products.add|pmm.products.full_control');
     Route::get('update/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'update'])->name('products.update')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
     Route::get('view-details/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'viewDetail'])->name('products.view_detail')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
     Route::post('update/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'updatePost'])->name('products.updatePost')->middleware('basic.permission:pmm.products.update|pmm.products.full_control');
     Route::post('subscribe/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'subscribe'])->name('products.subscribe')->middleware('basic.permission:pmm.products.subscribe|pmm.products.full_control');
     Route::post('image-upload/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'image_upload'])->name('products.image_upload')->middleware('basic.permission:pmm.products.image_upload|pmm.products.full_control');
     Route::post('product-images/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'images'])->name('products.images')->middleware('basic.permission:pmm.products.view_images|pmm.products.full_control');
     Route::get('remove-image/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'removeImage'])->name('products.image_remove')->middleware('basic.permission:pmm.products.image_upload|pmm.products.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'remove'])->name('products.remove')->middleware('basic.permission:pmm.products.remove|pmm.products.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'logs'])->name('products.logs')->middleware('basic.permission:pmm.products.logs&products.full_control');
     Route::post('AddTag/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'AddTag'])->name('products.add.tag')->middleware('basic.permission:pmm.products.logs&products.full_control');
     Route::get('/AddTagJson/{id}', [App\Http\Controllers\PMM\Product\PMMProductController::class, 'getTag'])->name('products.tag');
     Route::post('/deleteTag/', [App\Http\Controllers\PMM\Product\PMMProductController::class, 'deleteTag'])->name('products.delete.tag');
     Route::post('AssignCategory/{id}', [App\Http\Controllers\PMM\Product\PMMProductController::class, 'AssignCategory'])->name('product.asain.category');
     Route::post('shopSearch', [App\Http\Controllers\PMM\Product\PMMProductController::class, 'shopSearch'])->name('shop.search.products');

    });

    Route::prefix('merchants')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'index'])->name('merchants.view')->middleware('basic.permission:pmm.merchants.view|pmm.merchants.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'search'])->name('merchants.search')->middleware('basic.permission:pmm.merchants.view|pmm.merchants.full_control');
     Route::get('add',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'add'])->name('merchants.add')->middleware('basic.permission:pmm.merchants.add|pmm.merchants.full_control');
     Route::post('add',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'addPost'])->name('merchants.addPost')->middleware('basic.permission:pmm.merchants.add|pmm.merchants.full_control');
     Route::get('update/{id}',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'update'])->name('merchants.update')->middleware('basic.permission:pmm.merchants.view|pmm.merchants.full_control');
     Route::post('update/{id}',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'updatePost'])->name('merchants.updatePost')->middleware('basic.permission:pmm.merchants.update|pmm.merchants.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'remove'])->name('merchants.remove')->middleware('basic.permission:pmm.merchants.remove|pmm.merchants.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\PMM\Merchant\PMMMerchantController::class,'logs'])->name('merchants.logs')->middleware('basic.permission:pmm.merchants.logs&merchants.full_control');

    });
    //dadasdsadasdadasd
Route::prefix('dashboard')
      ->middleware(['auth'])
      ->name('dashboard.')
     ->group(function(){
     Route::post('product-stats', [DashboardController::class, 'getMonthlyProductStats'])->name('monthly_product_states')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
     Route::post('product-clicks', [DashboardController::class, 'getMonthlyProductClicks'])->name('monthly_product_clicks')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
     Route::post('payment-stats', [DashboardController::class, 'monthlyTransactionStats'])->name('monthly_payment_states')->middleware('basic.permission:pmm.transactions.view|pmm.transactions.full_control');
     Route::post('clicks-and-leads', [DashboardController::class, 'clicksAndLeads'])->name('clicks_and_leads');
    //  ->middleware('basic.permission:pmm.clicksandleads.view|pmm.clicksandleads.full_control');
    });
Route::prefix('transactions')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/complete/{id}',[App\Http\Controllers\PMM\Transactions\PMMTransactionsController::class,'completeTransaction'])->name('transactions.complete')->middleware('basic.permission:pmm.transactions.complete|pmm.transactions.full_control');
     Route::get('/',[App\Http\Controllers\PMM\Transactions\PMMTransactionsController::class,'index'])->name('transactions.view')->middleware('basic.permission:pmm.transactions.view|pmm.transactions.full_control');
     Route::get('/detail/{id}',[App\Http\Controllers\PMM\Transactions\PMMTransactionsController::class,'detail'])->name('transactions.detail')->middleware('basic.permission:pmm.transactions.view|pmm.transactions.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Transactions\PMMTransactionsController::class,'search'])->name('transactions.search')->middleware('basic.permission:pmm.transactions.view|pmm.transactions.full_control');
     Route::post('/update-details/{id}',[App\Http\Controllers\PMM\Transactions\PMMTransactionsController::class,'updateDetails'])->name('transactions.updateDetails')->middleware('basic.permission:pmm.transactions.order_details|pmm.transactions.full_control');

    });
    Route::prefix('ledger/balance')
      ->middleware(['auth'])
      ->name('pmm.ledger.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'index'])->name('balance.view')->middleware('basic.permission:pmm.balance.view|pmm.balance.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'search'])->name('balance.search')->middleware('basic.permission:pmm.balance.view|pmm.balance.full_control');
     Route::get('add',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'add'])->name('balance.add')->middleware('basic.permission:pmm.balance.add|pmm.balance.full_control');
     Route::post('add',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'addPost'])->name('balance.addPost')->middleware('basic.permission:pmm.balance.add|pmm.balance.full_control');
     Route::get('update/{id}',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'update'])->name('balance.update')->middleware('basic.permission:pmm.balance.view|pmm.balance.full_control');
     Route::post('update/{id}',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'updatePost'])->name('balance.updatePost')->middleware('basic.permission:pmm.balance.update|pmm.balance.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'remove'])->name('balance.remove')->middleware('basic.permission:pmm.balance.remove|pmm.balance.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\PMM\Ledger\PMMBalanceController::class,'logs'])->name('balance.logs')->middleware('basic.permission:pmm.balance.logs&balance.full_control');

    });
    Route::prefix('affiliate-links')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\AffiliateLink\PMMAffiliateLinkController::class,'index'])->name('affiliate_links.view')->middleware('basic.permission:pmm.affiliate_links.view|pmm.affiliate_links.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\AffiliateLink\PMMAffiliateLinkController::class,'search'])->name('affiliate_links.search')->middleware('basic.permission:pmm.affiliate_links.view|pmm.affiliate_links.full_control');
     Route::post('generate/{id}',[App\Http\Controllers\PMM\AffiliateLink\PMMAffiliateLinkController::class,'generate'])->name('affiliate_links.generate')->middleware('basic.permission:pmm.affiliate_links.generate|pmm.affiliate_links.full_control');
     Route::post('update-attributes/{id}',[App\Http\Controllers\PMM\AffiliateLink\PMMAffiliateLinkController::class,'updateAttribute'])->name('affiliate_links.updateAttribute')->middleware('basic.permission:pmm.affiliate_links.update|pmm.affiliate_links.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\AffiliateLink\PMMAffiliateLinkController::class,'remove'])->name('affiliate_links.remove')->middleware('basic.permission:pmm.affiliate_links.remove|pmm.affiliate_links.full_control');

    });
    Route::prefix('affiliates')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'index'])->name('affiliates.view')->middleware('basic.permission:pmm.affiliates.view|pmm.affiliates.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'search'])->name('affiliates.search')->middleware('basic.permission:pmm.affiliates.view|pmm.affiliates.full_control');
     Route::get('add',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'add'])->name('affiliates.add')->middleware('basic.permission:pmm.affiliates.add|pmm.affiliates.full_control');
     Route::post('add',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'addPost'])->name('affiliates.addPost')->middleware('basic.permission:pmm.affiliates.add|pmm.affiliates.full_control');
     Route::get('update/{id}',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'update'])->name('affiliates.update')->middleware('basic.permission:pmm.affiliates.view|pmm.affiliates.full_control');
     Route::post('update/{id}',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'updatePost'])->name('affiliates.updatePost')->middleware('basic.permission:pmm.affiliates.update|pmm.affiliates.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'remove'])->name('affiliates.remove')->middleware('basic.permission:pmm.affiliates.remove|pmm.affiliates.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\PMM\Affiliate\PMMAffiliateController::class,'logs'])->name('affiliates.logs')->middleware('basic.permission:pmm.affiliates.logs&affiliates.full_control');

    });





Route::prefix('support')
      ->middleware(['auth'])
      ->name('sp.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\SP\SPController::class,'index'])->name('sp.view')->middleware('basic.permission:sp.view|sp.full_control');
     Route::get('/tickets',[App\Http\Controllers\SP\SPController::class,'tickets'])->name('tickets.view')->middleware('basic.permission:sp.view|sp.full_control');
     Route::get('chat/{id}',[App\Http\Controllers\SP\SPController::class,'chat'])->name('tickets.chat')->middleware('basic.permission:sp.tickets.chat|sp.tickets.full_control');
     Route::post('/search',[App\Http\Controllers\SP\SPController::class,'search'])->name('tickets.search')->middleware('basic.permission:sp.tickets.view|sp.tickets.full_control');
     Route::get('add',[App\Http\Controllers\SP\SPController::class,'add'])->name('tickets.add')->middleware('basic.permission:sp.tickets.add|sp.tickets.full_control');
     Route::post('add',[App\Http\Controllers\SP\SPController::class,'addPost'])->name('tickets.addPost')->middleware('basic.permission:sp.tickets.add|sp.tickets.full_control');
     Route::get('update/{id}',[App\Http\Controllers\SP\SPController::class,'update'])->name('tickets.update')->middleware('basic.permission:sp.tickets.view|sp.tickets.full_control');
     Route::post('update/{id}',[App\Http\Controllers\SP\SPController::class,'updatePost'])->name('tickets.updatePost')->middleware('basic.permission:sp.tickets.update|sp.tickets.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\SP\SPController::class,'remove'])->name('tickets.remove')->middleware('basic.permission:sp.tickets.remove|sp.tickets.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\SP\SPController::class,'logs'])->name('tickets.logs')->middleware('basic.permission:sp.tickets.logs&tickets.full_control');
    });
Route::prefix('support/ticket/chats')
      ->middleware(['auth'])
      ->name('sp.ticket.')
     ->group(function(){
     Route::post('/',[App\Http\Controllers\SP\SPTicketCommentController::class,'index'])->name('chat.comment.view')->middleware('basic.permission:sp.ticket.chat.comment.view|sp.ticket.chat.comment.full_control');
     Route::post('/Add',[App\Http\Controllers\SP\SPTicketCommentController::class,'add'])->name('chat.comment.add')->middleware('basic.permission:sp.ticket.chat.comment.add|sp.ticket.chat.comment.full_control');
    });
Route::prefix('system')
      ->middleware(['auth'])
      ->name('system.connect.')
     ->group(function(){
     Route::get('/customdomain',[App\Http\Controllers\PMM\Connect\CONCustomDomainController::class,'index'])->name('customdomain.view')->middleware('basic.permission:system.connect.customdomain.view|system.connect.customdomain.full_control');
     Route::post('/customdomain/{product_id}',[App\Http\Controllers\PMM\Connect\CONCustomDomainController::class,'update'])->name('customdomain.update')->middleware('basic.permission:system.connect.customdomain.update|system.connect.customdomain.full_control');
     Route::post('/fields/{product_id}',[App\Http\Controllers\PMM\Connect\CheckoutController::class,'updateFields'])->name('fields.update')->middleware('basic.permission:system.connect.fields.update|system.connect.fields.full_control');

     Route::get('/telegram',[App\Http\Controllers\PMM\Connect\CONTelegramController::class,'index'])->name('telegram.view')->middleware('basic.permission:system.connect.telegram.view|system.connect.telegram.full_control');
     Route::post('/telegram/reconnect',[App\Http\Controllers\PMM\Connect\CONTelegramController::class,'reconnect'])->name('telegram.reconnect')->middleware('basic.permission:system.connect.telegram.view|system.connect.telegram.full_control');
    });
Route::prefix('posts')
     ->name('blog.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\Blog\Post\BlogPostController::class,'index'])->name('posts.view')->middleware('basic.permission:blog.posts.view|blog.posts.full_control');
     Route::post('/search',[App\Http\Controllers\Blog\Post\BlogPostController::class,'search'])->name('posts.search')->middleware('basic.permission:blog.posts.view|blog.posts.full_control');
     Route::get('add',[App\Http\Controllers\Blog\Post\BlogPostController::class,'add'])->name('posts.add')->middleware('basic.permission:blog.posts.add|blog.posts.full_control');
     Route::post('add',[App\Http\Controllers\Blog\Post\BlogPostController::class,'addPost'])->name('posts.addPost')->middleware('basic.permission:blog.posts.add|blog.posts.full_control');
     Route::get('update/{id}',[App\Http\Controllers\Blog\Post\BlogPostController::class,'update'])->name('posts.update')->middleware('basic.permission:blog.posts.view|blog.posts.full_control');
     Route::post('update/{id}',[App\Http\Controllers\Blog\Post\BlogPostController::class,'updatePost'])->name('posts.updatePost')->middleware('basic.permission:blog.posts.update|blog.posts.full_control');
     Route::get('remove/{id}',[App\Http\Controllers\Blog\Post\BlogPostController::class,'remove'])->name('posts.remove')->middleware('basic.permission:blog.posts.remove|blog.posts.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\Blog\Post\BlogPostController::class,'logs'])->name('posts.logs')->middleware('basic.permission:blog.posts.logs&blog.posts.full_control');

    });
Route::prefix('system')
      ->middleware(['auth'])
      ->name('system.setting.')
     ->group(function(){


    Route::prefix('app')
      ->middleware(['auth'])
      ->name('app.')
      ->group(function(){
      Route::get('/',[SettingAppController::class,'index'])->name('view')->middleware('basic.permission:system.setting.app.view|system.setting.app.full_control');
      Route::post('/{id}',[SettingAppController::class,'updateSupportActor'])->name('update.support.actor')->middleware('basic.permission:system.setting.app.support_actor|system.setting.app.full_control');
    });
    });
});
Route::get('/',[HomeController::class,'index']);
Route::get('/please-verify-account',[HomeController::class,'pleaseVerifyAccount']);
Route::get('/shop',[FrontendController::class,'shop'])->name('frontend.shop');
Route::get('/terms',[FrontendController::class,'terms'])->name('frontend.terms');
Route::get('/privacy',[FrontendController::class,'privacy'])->name('frontend.privacy');
Route::get('/refund-policy',[FrontendController::class,'refundPolicy'])->name('frontend.refund.policy');
Route::get('/product/{id}',[FrontendController::class,'productUrl'])->name('frontend.product.url');
Route::post('/checkout/{id}',[FrontendController::class,'checkoutProcess'])->name('frontend.product.checkout')->middleware('setLang');
Route::post('/paysight/checkout/do-iframe-payment',[FrontendController::class,'paysightCheckoutProcessIframe'])->name('frontend.product.paysight.iframecheckout');
Route::post('/paysight/checkout/{id}',[FrontendController::class,'paysightCheckoutProcess'])->name('frontend.product.paysight.checkout')->middleware('setLang');
Route::post('/paysight/checkout/save-after-info/{id}',[FrontendController::class,'paysightCheckoutSaveAfterInfo'])->name('frontend.product.paysight.checkout-save-after-info')->middleware('setLang');
Route::get('/thankyou/{id}',[FrontendController::class,'thankyou'])->name('frontend.product.thankyou');
Route::get('/not-found',[FrontendController::class,'notfound'])->name('frontend.product.notfound');
Route::get('/signup',[FrontendController::class,'signup'])->name('signup');
Route::post('/signup-post',[FrontendController::class,'signupPost'])->name('signup.post');

Route::prefix('Stripe')
    ->group(function () {
        Route::post('/checkout', [App\Http\Controllers\Stripe\StripeController::class,'checkout'])->name('stripe.checkout');
        Route::post('/subscription/cancel', [App\Http\Controllers\Stripe\StripeController::class,'cancel_subscription'])->name('stripe.subscription.cancel');
        Route::get('/success-url/{id}', [App\Http\Controllers\Stripe\StripeController::class,'success_url'])->name('stripe.success_url');
        Route::get('/cancel-url/{id}', [App\Http\Controllers\Stripe\StripeController::class,'cancel_url'])->name('stripe.cancel_url');
});
//dadadasdasdas
Route::prefix('order')
    ->group(function () {
        Route::get('/track/{order_id}', [App\Http\Controllers\PMM\Order\PMMOrderController::class,'track'])->name('pmm.order.track');
});
    Route::prefix('page')
    ->middleware(['auth'])
     ->group(function(){
     Route::get('/',[App\Http\Controllers\Pages\Page\PageController::class,'index'])->name('pages.page.view')->middleware('basic.permission:pages.page.view|pages.page.full_control');
     Route::post('/search',[App\Http\Controllers\Pages\Page\PageController::class,'search'])->name('pages.page.search')->middleware('basic.permission:pages.page.view|pages.page.full_control');
     Route::get('add',[App\Http\Controllers\Pages\Page\PageController::class,'add'])->name('pages.page.add')->middleware('basic.permission:pages.page.add|pages.page.full_control');
     Route::post('add',[App\Http\Controllers\Pages\Page\PageController::class,'addPost'])->name('pages.page.addPost')->middleware('basic.permission:pages.page.add|pages.page.full_control');
     Route::get('update/{id}',[App\Http\Controllers\Pages\Page\PageController::class,'update'])->name('pages.page.update')->middleware('basic.permission:pages.page.view|pages.page.full_control');
     Route::post('update/{id}',[App\Http\Controllers\Pages\Page\PageController::class,'updatePost'])->name('pages.page.updatePost')->middleware('basic.permission:pages.page.update|pages.page.full_control');

     Route::get('remove/{id}',[App\Http\Controllers\Pages\Page\PageController::class,'remove'])->name('pages.page.remove')->middleware('basic.permission:pages.page.remove|pages.page.full_control');
     Route::get('logs/{id}',[App\Http\Controllers\Pages\Page\PageController::class,'logs'])->name('pages.page.logs')->middleware('basic.permission:pages.page.logs&pages.page.full_control');

    });
//dadadasd
 Route::get('page-view/{slug}',[App\Http\Controllers\Pages\Page\PageController::class,'pageview'])->name('pages.page.pageview');
 Route::get('shop/{id}',[App\Http\Controllers\FrontendController::class,'viewProduct'])->name('frontend.shop.product.view');
 Route::get('tutorials',[App\Http\Controllers\Blog\Post\BlogPostController::class,'tutorials'])->name('tutorial.list');
 Route::get('tutorials/{slug?}',[App\Http\Controllers\Blog\Post\BlogPostController::class,'showTutorial'])->name('tutorial.show');

Route::prefix('CallCenter')
  ->middleware(['auth'])
     ->group(function(){
Route::get('/', [Callcontroller::class, 'index'])->name('system.CallCenter.orders')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');
Route::post('order-search', [Callcontroller::class, 'search'])->name('system.CallCenter.orders.search')->middleware('basic.permission:pmm.cc.order.update|pmm.cc.order.full_control');
Route::get('CallServiceDetail/{id}', [Callcontroller::class, 'detail'])->name('Call.Service.Detail')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');
Route::post('/css-update-details/{id}',[Callcontroller::class,'updateDetails'])->name('cc.updateDetails')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');
Route::post('transactions/add-call-log', [Callcontroller::class, 'addCallLog'])->name('pmm.addCallLog')->middleware('basic.permission:pmm.cc.order.update|pmm.cc.order.update.full_control');
Route::post('/css-update-updateDelivery/{id}',[Callcontroller::class,'updateDelivery'])->name('cc.updateDelivery')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');
Route::get('/order/update-status', [Callcontroller::class, 'updateStatus'])
    ->name('order.updateStatus');
Route::get('/order/save-status', [Callcontroller::class, 'saveStatus'])->name('order.saveStatus');


Route::post('CallCenter/orders/downloadReport', [Callcontroller::class, 'downloadReport'])
    ->name('system.CallCenter.orders.downloadReport') ->middleware('basic.permission:pmm.cc.order.report.download|pmm.transactions.full_control');;
Route::get('/Dashboard', [Callcontroller::class, 'Dashboard'])->name('system.CallCenter.dashboard')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');
Route::post('/dashboard/monthly-order-stats', [Callcontroller::class, 'monthlyOrderStats'])->name('dashboard.monthly_order_stats')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');
Route::post('/dashboard/pending-completed-stats', [Callcontroller::class, 'pendingCompletedStats'])->name('dashboard.pending_completed_stats')->middleware('basic.permission:pmm.cc.order.update|sp.ticket.chat.comment.full_control');

});
Route::prefix('lookup')
     ->middleware(['auth'])
    ->group(function () {
        
        Route::get('Category', [LookupController::class,'index'])->name('system.Lookup.Category');
        Route::get('Category/list', [LookupController::class, 'list'])->name('system.Lookup.Category.list');
        Route::post('Category/add', [LookupController::class, 'add'])->name('system.Lookup.Category.add');
        Route::get('Category/delete/{id}', [LookupController::class, 'delete'])->name('system.Lookup.Category.delete');

});
Route::prefix('lookup')
     ->middleware(['auth'])
    ->group(function () {
        
        Route::get('address', [AddressController::class,'index'])->name('system.Lookup.address');
        Route::get('address/list', [AddressController::class, 'list'])->name('system.Lookup.address.list');
        Route::post('address/add', [AddressController::class, 'add'])->name('system.Lookup.address.add');
        Route::any('address/edit/{id}', [AddressController::class, 'edit'])->name('system.Lookup.address.edit');
        Route::post('address/update/{id}', [AddressController::class, 'update'])->name('system.Lookup.address.update');
        Route::get('address/delete/{id}', [AddressController::class, 'delete'])->name('system.Lookup.address.delete');

});


Route::prefix('lookup')
     ->middleware(['auth'])
    ->group(function () {
        
        Route::get('profile', [GlsProfile::class,'index'])->name('pmm.profile.gls');
        Route::get('address/gls/list', [GlsProfile::class, 'list'])->name('system.gls.profile.list');
        Route::post('address/gls', [GlsProfile::class, 'add'])->name('system.gls.profile.store');

        Route::any('gls/profile/edit/{id}', [GlsProfile::class, 'gls_pro_edit']);
        Route::post('address/update/{id}', [GlsProfile::class, 'update'])->name('system.Lookup.gls.pro.update');
        Route::get('gls/profile/delete/{id}', [GlsProfile::class, 'delete_gls_pro'])->name('delete.gls.pro');

});







Route::get('Crouncyupdate', [CruncyController::class, 'crouncyUpdate'])
    ->name('Crouncy.update');
Route::post('/test-gls', [GLSShipmentController::class, 'testAddParcel'])->name('create.shipment');
Route::get('/gls/view/{id}', [GLSShipmentController::class, 'view_gls'])->name('gls.view');
Route::get('/closeWorkDay/{id}', [GLSShipmentController::class, 'closeWorkDay'])->name('closeWorkDay.shipment');
Route::get('/closeWorkDay/Shipment/Number/{id}', [GLSShipmentController::class, 'closeWorkDay_number'])->name('closeWorkDay.shipment.number');
Route::get('/shipments/{id}/edit', [GLSShipmentController::class, 'edit']);

Route::post('/track-shipment', [GLSShipmentController::class, 'trackShipment'])->name('track.shipment');

Route::post('/gls/cancel', [GLSShipmentController::class, 'deleteByShipmentNumber'])->name('gls.cancel');
Route::get('/gls-token', [GLSShipmentController::class, 'getToken']);
Route::post('/shipment/label', [GLSShipmentController::class, 'getLabel'])->name('shipment.label');
// Route::post('/gls/cancel', [GLSShipmentController::class, 'cancelShipment'])->name('gls.cancel');
Route::post('/fetch/adresss', [GLSShipmentController::class, 'fetchadresss'])->name('gls.adresss.fetch');


Route::get('/shipment/details', [GLSShipmentController::class, 'ajaxDetails'])
    ->name('shipment.details.ajax');


     Route::prefix('parcels')
      ->middleware(['auth'])
      ->name('pmm.')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\PMM\Parcel\PMMParcelController::class,'index'])->name('parcel.view')->middleware('basic.permission:pmm.parcel.view|pmm.parcel.full_control');
     Route::post('/search',[App\Http\Controllers\PMM\Parcel\PMMParcelController::class,'search'])->name('parcel.search')->middleware('basic.permission:pmm.parcel.view|pmm.parcel.full_control');
     });
     Route::get('upsell/{id}',[App\Http\Controllers\PMM\Product\PMMProductController::class,'up_sell'])->name('upp.sell')->middleware('basic.permission:pmm.products.view|pmm.products.full_control');
Route::post('/upsell/store', [UppSellController::class, 'store'])->name('upsell.store');
Route::get('/upsell/{id}/edit', [UppSellController::class, 'edit'])->name('upsell.edit');
Route::post('/upsell/update/', [UppSellController::class, 'update'])->name('upsell.update');
Route::delete('/upsell/{id}', [UppSellController::class, 'destroy'])->name('upsell.destroy');
Route::get('/upsell/items/{id}', [UppSellController::class, 'upsell_items'])->name('upsell.items');

Route::post('/upsell/item', [UppSellController::class, 'store_item'])->name('item.store');
Route::delete('/upsell/item/{id}', [UppSellController::class, 'item_destroy'])->name('upsell.item.destroy');
Route::post('/upsell/item/update/', [UppSellController::class, 'item_update'])->name('item.upsell.update');

Route::get('/delete-upsell-custom', [UppSellController::class, 'deleteUpsell'])->name('delete.custom.upsell');

Route::get('/fetch/upsell/{id}', [UppSellController::class, 'fetchaupsell'])->name('gls.prosuct.upsell');

Route::get('/delete-custom-upsell', [UppSellController::class, 'deleteCustomUpsell'])
    ->name('delete.custom.item');



    Route::get('/parcel/upsell/{id}', [GlsProfile::class, 'getUpsell']);

Route::prefix('Call-Center/operators')
    ->group(function () {
        Route::get('/', [OperatorController::class,'index'])->name('system.CallCenter.operator.view')->middleware('basic.permission:system.CallCenter.operator.view');
        Route::post('/add', [OperatorController::class,'add'])->name('system.CallCenter.operator.add')->middleware('basic.permission:system.CallCenter.operator.add');
        Route::post('/update/{id}', [OperatorController::class,'update'])->name('system.CallCenter.operator.update')->middleware('basic.permission:system.CallCenter.operator.edit');
        Route::get('/delete/{id}', [OperatorController::class,'delete'])->name('system.CallCenter.operator.delete')->middleware('basic.permission:system.CallCenter.operator.remove');
    });
Route::prefix('v2/resume')
    ->group(function () {
        Route::get('/email-test', [ResumeController::class,'emailTest'])->name('resume.emailtest');
        Route::get('/pay-and-unlock', [ResumeController::class,'payAndUnlock'])->name('resume.pay_and_unlock');
        Route::get('/', [ResumeController::class,'create'])->name('resume.create');
        Route::get('/edit/{id}', [ResumeController::class,'edit'])->name('resume.edit');
        Route::post('/update-template', [ResumeController::class,'updateTemplate'])->name('resume.update.template');
        Route::get('/delete/{id}', [ResumeController::class,'delete'])->name('resume.delete');
        Route::get('/download-pdf/pdf/{id}', [ResumeController::class,'pdf'])->name('resume.pdf');
        Route::get('/download-pdf/preview/{id}', [ResumeController::class,'pdfPreview'])->name('resume.pdf.preview');
        Route::get('/fg/bn/{id}', [ResumeController::class,'pdfPreview2'])->name('resume.pdf.preview2');

        // experiences
        Route::get('/experience/list', [ExperienceController::class,'list'])->name('resume.experience.list');
        Route::post('/experience/save', [ExperienceController::class,'save'])->name('resume.experience.save');
        Route::post('/experience/add', [ExperienceController::class,'add'])->name('resume.experience.add');
        Route::post('/experience/delete/{id}', [ExperienceController::class,'delete'])->name('resume.experience.delete');
        
        // education
        Route::get('/education/list', [EducationController::class,'list'])->name('resume.education.list');
        Route::post('/education/save', [EducationController::class,'save'])->name('resume.education.save');
        Route::post('/education/add', [EducationController::class,'add'])->name('resume.education.add');
        Route::post('/education/delete/{id}', [EducationController::class,'delete'])->name('resume.education.delete');
     
        // certificate
        Route::get('/certificate/list', [CertificateController::class,'list'])->name('resume.certificate.list');
        Route::post('/certificate/save', [CertificateController::class,'save'])->name('resume.certificate.save');
        Route::post('/certificate/add', [CertificateController::class,'add'])->name('resume.certificate.add');
        Route::post('/certificate/delete/{id}', [CertificateController::class,'delete'])->name('resume.certificate.delete');
       
        // skill
        Route::get('/skill/list', [SkillController::class,'list'])->name('resume.skill.list');
        Route::post('/skill/save', [SkillController::class,'save'])->name('resume.skill.save');
        Route::post('/skill/delete/{id}', [SkillController::class,'delete'])->name('resume.skill.delete');

        // language
        Route::get('/language/list', [LanguageController::class,'list'])->name('resume.language.list');
        Route::post('/language/save', [LanguageController::class,'save'])->name('resume.language.save');
        Route::post('/language/delete/{id}', [LanguageController::class,'delete'])->name('resume.language.delete');

        // contact
        Route::post('/contact/save', [ContactController::class,'save'])->name('resume.contact.save');

        // summary
        Route::post('/summary/save', [SummaryController::class,'save'])->name('resume.summary.save');

        // template
        Route::post('/template/save', [TemplateController::class,'save'])->name('resume.template.save');


        Route::any('/preview', [ResumeController::class,'preview'])->name('resume.preview');
    });
Route::prefix('resume-builder')
    ->group(function () {
       Route::get('/features', [HomeController::class,'features'])->name('home.features');
       Route::get('/pricing', [HomeController::class,'pricing'])->name('home.pricing');
       Route::get('/templates', [HomeController::class,'templates'])->name('home.templates');
       Route::any('/jobs', [JobsController::class,'index'])->name('home.jobs');
       Route::any('/jobs/ajax', [JobsController::class,'indexAjax'])->name('home.jobs.ajax');
       Route::any('/user', [JobUserController::class,'index'])->name('home.user.profile');
       Route::any('/user/update', [JobUserController::class,'updateProfile'])->name('home.user.profile.update');
       Route::any('/user/resumes', [JobUserController::class,'resumes'])->name('home.user.resumes');
       Route::any('/user/myjobs', [JobsController::class,'myjobsIndex'])->name('home.user.myjobs');
       Route::any('/user/myjobs-ajax', [JobsController::class,'myJobs'])->name('home.user.myjobs.ajax');
       Route::any('/user/resume/custom/upload', [JobUserController::class,'customResumeUpload'])->name('home.user.resume.custom.upload');
       Route::get('/about', [HomeController::class,'about'])->name('home.about');
       Route::get('/contact', [HomeController::class,'contact'])->name('home.contact');
       Route::get('/post-a-job', [HomeController::class,'postAJob'])->name('home.post_a_job');
       Route::post('/contact-post', [HomeController::class,'contactPost'])->name('home.contact_post');
       Route::post('/post-a-job-process', [HomeController::class,'postAJobProcess'])->name('home.post_a_job_process');
       Route::get('/jobs/{slug}', [JobsController::class,'jobDetail'])->name('home.jobs.single');
       Route::post('/jobs/save', [JobsController::class,'saveAjax'])->name('home.jobs.save');
       Route::get('/jobs/apply/{slug}', [JobsController::class,'jobApply'])->name('home.jobs.apply');
       Route::post('/jobs/apply-process/{slug}', [JobsController::class,'jobApplyProcess'])->name('home.jobs.applyProcess');
    });

Route::group([
    'prefix' => 'mobile-app'
], function ($router) {

    Route::get('login-using-token/{token}', [MobileAppController::class,'loginUsingToken']);
    Route::get('resume/download-pdf/{token}', [MobileAppController::class,'downloadResume']);
    Route::get('resume/preview/{token}', [MobileAppController::class,'previewResume']);

});
Route::group([
    'prefix' => 'account'
], function ($router) {

    Route::get('delete', [MobileAppController::class,'deleteAccount']);

});
Route::group([
    'prefix' => 'goat'
], function ($router) {

     Route::get('/hk/p/{id}', [ResumeController::class,'rawPDF'])->name('raw.pdf.review');

});


    Route::prefix('blogs')
     ->group(function(){
     Route::get('/',[App\Http\Controllers\Pages\Page\PageController::class,'blogs'])->name('pages.page.blogs.list');
     Route::get('/{slug}',[App\Http\Controllers\Pages\Page\PageController::class,'blogDetail'])->name('pages.page.blogs.deetail');

    });

    Route::prefix('google')
     ->group(function(){
     Route::post('/',[GoogleAuthController::class,'login'])->name('auth.google');

    });


    Route::prefix('jobs')
     ->group(function(){
     Route::get('/sync/arbeitnow',[JobsController::class,'arbeitnowJobs']);
     Route::get('/sync/himalayas',[JobsController::class,'himalayasJobs']);
     Route::get('/sync/remotive',[JobsController::class,'remotiveJobs']);
     Route::get('/sync/adzuna',[JobsController::class,'adzunaJobs']);
     Route::get('/sync/remoteok',[JobsController::class,'remoteOKJobs']);
     Route::get('/sync/opeb-web-jobs',[JobsController::class,'openwebJobs']);

    });


// commands

Route::get('/generate-sitemap', function () {

    Artisan::call('app:generate-sitemap');

    return response()->json([
        'success' => true,
        'message' => 'Sitemap generated successfully.',
    ]);
});
Route::get('/privacy-policy', function () {

    return redirect(url('page-view/privacy-policy'));
});
Route::prefix('jobs')
     ->name('jobs.')
     ->middleware('auth')
     ->group(function(){
     Route::any('/my',[JobsController::class,'my'])->name('my')->middleware('basic.permission:jobs.my.view');
     Route::post('/new',[JobsController::class,'new'])->name('new')->middleware('basic.permission:jobs.my.add');
     Route::get('/edit/{id}',[JobsController::class,'edit'])->name('edit')->middleware('basic.permission:jobs.my.update');
     Route::post('/update/{id}',[JobsController::class,'update'])->name('update')->middleware('basic.permission:jobs.my.update');
     // questionair
    Route::any('/questionnaire',[JobsController::class,'my'])->name('questionnaire')->middleware('basic.permission:jobs.my.update');
     Route::get('/questionnaire',[JobsController::class,'list'])->name('questionnaire.list')->middleware('basic.permission:jobs.my.update');
     Route::post('/questionnaire',[JobsController::class,'new'])->name('questionnaire.new')->middleware('basic.permission:jobs.my.update');
     Route::get('/questionnaire/delete/{id}',[JobsController::class,'delete'])->name('questionnaire.delete')->middleware('basic.permission:jobs.my.update');
    });
Route::prefix('job/processing')
     ->group(function(){
     Route::any('/set-remote-1',[JobProcessingController::class,'setRemoteOne']);
     });
Route::prefix('google/indexing')
     ->group(function(){
     Route::any('/index',[GoogleIndexingController::class,'indexJobs']);
     Route::any('/insigts',[GoogleIndexingController::class,'indexJobsInsigts']);
     });