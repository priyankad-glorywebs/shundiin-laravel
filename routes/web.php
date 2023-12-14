<?php

use App\Http\Controllers\Admin\AjaxDataController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\LoadDataController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ModulesController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\MemberLoginController;
use App\Http\Controllers\Front\FontendController;
use App\Http\Controllers\Admin\MailSettingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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


Route::get('/', [FontendController::class, 'index'])->name('home');
Auth::routes();

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function (){
    // Dashboard
    Route::get('/', [FontendController::class, 'adminHome'])->name('admin.home');

    /* START POSTS */
    Route::resource('/posts', PostsController::class, [
        'names' => ['index' => 'admin.posts'],
    ]);

    /* post lock & unlock */
    Route::post('/post-type/lockunlockposts/', [PostsController::class, 'postlockUnlockData'])->name('post-lock-unlock');
    /* post clone */
    Route::post('/post-type/cloneposts/', [PostsController::class, 'postcloneData'])->name('post-clone');

    Route::get('/post-type/posts', [PostsController::class, 'create'])->name('post-type.posts');
    Route::post('/post-type/create-posts', [PostsController::class, 'createPage'])->name('post-type.create-posts');
    Route::get('/post-type/posts/{id}/edit', [PostsController::class, 'updatePage'])->name('post-type.edit-posts');
    Route::post('/post-type/update-posts/{id}', [PostsController::class, 'updatePagedata'])->name('post-type.update-posts');
    Route::delete('/post-type/posts/{id}/del', [PostsController::class, 'destroy'])->name('post-type.delete-posts');
    Route::post('/post-type/posts/bulk-action', [PostsController::class, 'bulkActionPage'])->name('post-type.post.bulk-action');
   
    /* Posts tags*/
    Route::get('/taxonomy/posts/tags', [TaxonomyController::class, 'indexTags'])->name('posts.tags');
    Route::get('/taxonomy/posts/tags/{id}/edit', [TaxonomyController::class, 'tagsupdatePage'])->name('tax.edit-tags');
    Route::get('/taxonomy/posts/tags/{id}', [TaxonomyController::class, 'tagsgetPage'])->name('tax.get-tags');
    /* Posts categories*/
    Route::get('/taxonomy/posts/categories', [TaxonomyController::class, 'indexTaxs'])->name('posts.categories');
    Route::post('/taxonomy/posts/categories', [TaxonomyController::class, 'createTaxs'])->name('posts.create.categories');
    Route::post('/post-taxonomy/posts/taxonomy/{type}', [TaxonomyController::class, 'createPostTaxs'])->name('posts.createpost.categories');
    Route::get('/taxonomy/posts/load-categories', [TaxonomyController::class, 'loadTaxonomies'])->name('posts.load-categories');
    Route::post('/taxonomy/posts/tax-bulk-action', [TaxonomyController::class, 'taxBulkActionPage'])->name('tax-bulk-action');
    Route::get('/taxonomy/posts/categories/{id}/edit', [TaxonomyController::class, 'taxupdatePage'])->name('tax.edit-categories');
    Route::post('/taxonomy/posts/categories/{id}', [TaxonomyController::class, 'updateTaxdata'])->name('admin.taxonomy.update-taxonomys');
    Route::delete('/taxonomy/posts/{id}/del', [TaxonomyController::class, 'destroy'])->name('post-type.tax.delete-posts');
    /* END POSTS */

    /* START PAGES */
    Route::resource('/pages', PagesController::class, [
        'names' => ['index' => 'admin.pages'],
    ]);
    Route::get('/post-type/pages', [PagesController::class, 'create'])->name('post-type.pages');
    Route::post('/post-type/create-pages', [PagesController::class, 'createPage'])->name('post-type.create-pages');
    Route::get('/post-type/pages/{id}/edit', [PagesController::class, 'updatePage'])->name('post-type.edit-pages');
    Route::post('/post-type/update-pages/{id}', [PagesController::class, 'updatePagedata'])->name('post-type.update-pages');
    Route::delete('/post-type/pages/{id}/del', [PagesController::class, 'destroy'])->name('post-type.delete-pages');
    Route::post('/post-type/pages/bulk-action', [PagesController::class, 'bulkActionPage'])->name('post-type.page.bulk-action');
    /* END PAGES */

    /* START SERVICES */
    Route::resource('/services', ServiceController::class, [
        'names' => ['index' => 'admin.services'],
    ]);
    Route::get('/post-type/services', [ServiceController::class, 'create'])->name('post-type.services');
    Route::post('/post-type/create-services', [ServiceController::class, 'createPage'])->name('post-type.create-services');
    Route::get('/post-type/services/{id}/edit', [ServiceController::class, 'updatePage'])->name('post-type.edit-services');
    Route::post('/post-type/update-services/{id}', [ServiceController::class, 'updatePagedata'])->name('post-type.update-services');
    Route::delete('/post-type/services/{id}/del', [ServiceController::class, 'destroy'])->name('post-type.delete-services');
    Route::post('/post-type/services/bulk-action', [ServiceController::class, 'bulkActionPage'])->name('post-type.bulk-action-services');
    /* END SERVICES */
   
    /* START EVENTS */
    Route::resource('/events', EventsController::class, [
        'names' => ['index' => 'admin.events'],
    ]);
    Route::get('/post-type/events', [EventsController::class, 'create'])->name('post-type.events');
    Route::post('/post-type/create-events', [EventsController::class, 'createPage'])->name('post-type.create-events');
    Route::get('/post-type/events/{id}/edit', [EventsController::class, 'updatePage'])->name('post-type.edit-events');
    Route::post('/post-type/update-events/{id}', [EventsController::class, 'updatePagedata'])->name('post-type.update-events');
    Route::delete('/post-type/events/{id}/del', [EventsController::class, 'destroy'])->name('post-type.delete-events');
    Route::post('/post-type/events/bulk-action', [EventsController::class, 'bulkActionPage'])->name('post-type.bulk-action-events');
    /* END EVENTS */

    Route::get('/load-data/{func}', [LoadDataController::class, 'loadData'])->name('admin.load_data');
    Route::post('/ajax/{func}', [AjaxDataController::class, 'getStringRaw'])->name('admin.getStringRaw');

    // User Module
    Route::resource('user', UserController::class, [
        'names' => ['index' => 'user.index'],
    ]);
    Route::get('userimage/{filename}', [UserController::class, 'displayUserImage'])->name('adminimage.displayUserImage');
    Route::post('/user/active-deactive', [UserController::class, 'ActiveDeactiveStatus'])->name('admin.user.active-deactive');

    // Media Manager
    Route::group(
        ['prefix' => 'media'],
        function (): void {
            Route::get('/', [MediaController::class, 'index'])->name('admin.media.index');
            Route::post('/store-upload', [MediaController::class, 'storeFile'])->name('admin.media.store_file');
            Route::post('/add-folder', [MediaController::class, 'addFolder'])->name('admin.media.add-folder');
            Route::delete('/delete-image', [MediaController::class, 'destroy'])->name('admin.media.destroy');
            Route::get(
                '/folder/{folder}',
                [MediaController::class, 'index']
            )
            ->name('admin.media.folder')
            ->where('folder', '[0-9]+');
            Route::post('file-upload', [MediaController::class, 'dropzoneStore'])->name('admin.dropzone.upload');
            Route::post('store', [MediaController::class,'store'])->name('store');
            Route::post('uploads', [MediaController::class,'uploads'])->name('uploads');
            Route::post('getfiledata', [MediaController::class,'getfiledata'])->name('getfiledata');
        }
    );
    // File Manager
    Route::group(['prefix' => 'file-manager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    // Error Handler
    Route::get('/error-logs', [UserController::class, 'getErrorLogs'])->name('admin.user.error_log');

    // Navigation - Menu Module
    Route::get('manage-menus/{id?}', [MenuController::class, 'index']);
    Route::post('/create-menu', [MenuController::class, 'store']);
    Route::get('/add-categories-to-menu', [MenuController::class, 'addCatToMenu']);
    Route::get('/add-post-to-menu', [MenuController::class, 'addPostToMenu']);
    Route::get('/add-custom-link', [MenuController::class, 'addCustomLink']);
    Route::get('/update-menu', [MenuController::class, 'updateMenu']);
    Route::post('/update-menuitem/{id}', [MenuController::class, 'updateMenuItem']);
    Route::get('/delete-menuitem/{id}/{key}/{in?}', [MenuController::class, 'deleteMenuItem']);
    Route::get('/delete-menu/{id}', [MenuController::class, 'destroy']);

    // User Profile  
    Route::get('/profile',[ProfileController::class,'index'])->name('admin.profile');
    Route::post('/update-profile-info',[ProfileController::class,'updateInfo'])->name('adminUpdateInfo');
    Route::post('/change-password',[ProfileController::class,'changePassword'])->name('adminChangePassword');
    Route::post('/profile', [ProfileController::class,'update_avatar'])->name('updateavatar');

    Route::get('/setting', [SettingController::class, 'index']);
    Route::post('/settingupdate', [SettingController::class, 'updateSettings'])->name('settings-update');
    
    Route::get('/mailsetting', [MailSettingController::class, 'index']);
    Route::post('/mailsettingupdate', [MailSettingController::class, 'updateMailSettings'])->name('mail-settings-update');

    Route::post('/mail/send', [MailSettingController::class, 'sendMail'])->name('mail.send')->middleware('mail_config');

    // Membership Module
    Route::resource('membership', MembershipController::class, [
        'names' => ['index' => 'membership.index'],
    ]);

    /* START CONTACTS */
    Route::resource('/contacts', ContactController::class, [
        'names' => ['index' => 'admin.contacts'],
    ]);
    /* delete contact */
    Route::delete('/post-type/contacts/{id}/del', [ContactController::class, 'destroy'])->name('post-type.delete-contacts');
    /* page bulk action */
    Route::post('/post-type/contacts/bulk-action', [ContactController::class, 'bulkActionContact'])->name('post-type.bulk-action-contacts');
    /* END MODULES */

     /* START MODULES */
     Route::resource('/modules', ModulesController::class, [
        'names' => ['index' => 'admin.modules'],
    ]);
    Route::post('/post-type/clonemodule/', [ModulesController::class, 'modulecloneData'])->name('module-clone');
    Route::get('/post-type/modules', [ModulesController::class, 'create'])->name('post-type.modules');
    /* create post */
    Route::post('/post-type/create-modules', [ModulesController::class, 'createmodule'])->name('post-type.create-modules');
    /* edit post */
    Route::get('/post-type/modules/{id}/edit', [ModulesController::class, 'updatePage'])->name('post-type.edit-modules');
    Route::any('/post-type/update-modules/{id}', [ModulesController::class, 'updatePagedata'])->name('post-type.update-modules');
    /* delete post */
    Route::delete('/post-type/modules/{id}/del', [ModulesController::class, 'destroy'])->name('post-type.delete-modules');
    /* page bulk action */
    Route::post('/post-type/modules/bulk-action', [ModulesController::class, 'bulkActionModule'])->name('post-type.bulk-action-modules');
    /* END MODULES */
});

Route::get('/clear-cache', function() {
    Artisan::call('optimize:clear');
    //Artisan::call('route:clear');
    //Artisan::call('config:clear');
    echo Artisan::output();
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
    
    //Artisan::call('vendor:publish --tag=lfm_config');
   // Artisan::call('vendor:publish --tag=lfm_public');
    echo Artisan::output();
});

/* create post */
Route::any('/post-type/create-contact', [ContactController::class,'createcontact'])->name('post-type.create-contacts');
// ->middleware('mail_config');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('mail_config');

/* START FRONTEND */
Route::get('/account-login', [MemberLoginController::class, 'index'])->name('front.member.login');
Route::post('/member-login', [MemberLoginController::class, 'login'])->name('member-login');

Route::get('{slug}', [FontendController::class, 'index'])
->name('user.front.view');
Route::get('/services/{slug}', [FontendController::class, 'index'])
->name('user.front.view');
Route::get('/events/{slug}', [FontendController::class, 'index'])
->name('user.front.view');
Route::get('404-page', [FontendController::class, 'error-page'])
->name('front.error-page');
// Route::post('categoryslug',[PostsController::class,'getCategorywisepost'])->name('categoryslug');
Route::get('/blog/{slug}',[PostsController::class,'details'])->name('blog.show');

// Route::get('/blog/{slug}', [PostsController::class, 'show'])->name('blog.show');

/* END FRONTEND */