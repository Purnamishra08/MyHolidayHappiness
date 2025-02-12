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

// Route::get('/','App\Http\Controllers\PageController@index');
// Route::get('/about-us','App\Http\Controllers\PageController@aboutUs');
// Route::get('/referrals','App\Http\Controllers\PageController@referrals');
// Route::get('/contact','App\Http\Controllers\PageController@contactUs');
// Route::get('/services','App\Http\Controllers\PageController@services');
// Route::get('/testimonial','App\Http\Controllers\PageController@testimonial');
Route::post('/submit-contact-us','App\Http\Controllers\PageController@submitContactUs');
Route::post('/submit-referrals','App\Http\Controllers\PageController@submitReferrals');

/*Route::get('/blogs-by-category/{slug}','App\Http\Controllers\PageController@blogByCategory');
Route::get('/blogs-by-subcategory/{slug}','App\Http\Controllers\PageController@blogBySubCategory');
Route::get('/blogs','App\Http\Controllers\PageController@blogs');
Route::get('/blog/{slug}','App\Http\Controllers\PageController@blogDetails');*/


Route::prefix('api')->group(function () {
    
   // Route::post('getUserDetails', [UserController::class, 'getUserDetails']);
    Route::post('getUsers', [App\Http\Controllers\UserController::class, 'getUsers']);
    Route::post('/crm/admin/removeUser', [App\Http\Controllers\UserController::class, 'removeUsers']);
    Route::post('getUserDetailsForEdit', [App\Http\Controllers\UserController::class, 'getUserDetailsForEdit']);
    Route::post('updateUserDetails', [App\Http\Controllers\UserController::class, 'updateUserDetails']);
        
    Route::post('getSearchResults', [App\Http\Controllers\UserController::class, 'getSearchResults']);
     Route::post('saveUserDetails', [App\Http\Controllers\UserController::class, 'saveUserDetails']);
    Route::post('getUserDetailsForEdit', [App\Http\Controllers\UserController::class, 'getUserDetailsForEdit']);
    
    Route::post('getStatuses', [App\Http\Controllers\StatusController::class, 'getStatuses']);
    Route::post('updateStatusDetails', [App\Http\Controllers\StatusController::class, 'updateStatusDetails']);
    Route::post('saveStatusDetails', [App\Http\Controllers\StatusController::class, 'saveStatusDetails']);
    Route::post('removeStatus', [App\Http\Controllers\StatusController::class, 'removeStatus']);
    Route::post('getStatusDetails', [App\Http\Controllers\StatusController::class, 'getStatusDetails']);
    
    Route::post('getSources', [App\Http\Controllers\SourceController::class, 'getSources']);
    Route::post('saveSourceDetails', [App\Http\Controllers\SourceController::class, 'saveSourceDetails']);
    Route::post('updateSourceDetails', [App\Http\Controllers\SourceController::class, 'updateSourceDetails']);
    Route::post('removeSource', [App\Http\Controllers\SourceController::class, 'removeSource']);
    Route::post('getSourceDetails', [App\Http\Controllers\SourceController::class, 'getSourceDetails']);
    
     Route::post('getCustomers', [App\Http\Controllers\CustomerController::class, 'getCustomers']);
    Route::post('updateCustomerDetails', [App\Http\Controllers\CustomerController::class, 'updateCustomerDetails']);
    Route::post('saveCustomerDetails', [App\Http\Controllers\CustomerController::class, 'saveCustomerDetails']);
    Route::post('removeCustomer', [App\Http\Controllers\CustomerController::class, 'removeCustomer']);
    Route::post('getCustomerDetails', [App\Http\Controllers\CustomerController::class, 'getCustomerDetails']);
    
     Route::post('searchCustomerByName', [App\Http\Controllers\CustomerController::class, 'searchCustomerByName']);
    Route::post('getInquiries', [App\Http\Controllers\InquiryController::class, 'getInquiries']);
     Route::post('updateInquiryDetails', [App\Http\Controllers\InquiryController::class, 'updateInquiryDetails']);
     Route::post('saveInquiryDetails', [App\Http\Controllers\InquiryController::class, 'saveInquiryDetails']);
     Route::post('getMetadataForInquiryForm', [App\Http\Controllers\InquiryController::class, 'getMetadataForInquiryForm']);
     Route::post('getInquiryDetailsForEdit', [App\Http\Controllers\InquiryController::class, 'getInquiryDetailsForEdit']);
    Route::post('removeInquiry', [App\Http\Controllers\InquiryController::class, 'removeInquiry']);
     Route::post('getReportsByFollowupDate', [App\Http\Controllers\InquiryController::class, 'getReportsByFollowupDate']);
     Route::post('searchInquiries', [App\Http\Controllers\InquiryController::class, 'searchInquiries']);
    
    
    
    /*Route::post('getBlogs','App\Http\Controllers\APIController@getBlogs');
    Route::post('getBlogDetailsForEdit','App\Http\Controllers\APIController@getBlogDetailsForEdit');
    Route::post('uploadTempBlogImage','App\Http\Controllers\APIController@uploadTempBlogImage');
    Route::post('updateBlogImage','App\Http\Controllers\APIController@updateBlogImage');
    
    Route::post('saveBlog','App\Http\Controllers\APIController@saveBlog');
    Route::post('updateBlog','App\Http\Controllers\APIController@updateBlog');
    Route::post('removeBlog','App\Http\Controllers\APIController@removeBlog');
    Route::post('enableBlog','App\Http\Controllers\APIController@enableBlog');
    Route::post('disableBlog','App\Http\Controllers\APIController@disableBlog');*/

/*    Route::post('highlightBlog','App\Http\Controllers\APIController@highlightBlog');
    Route::post('unHighlightBlog','App\Http\Controllers\APIController@unHighlightBlog');*/


    Route::post('tryLogin','App\Http\Controllers\APIController@tryLogin');
    Route::post('tryLogout','App\Http\Controllers\APIController@tryLogout');
    Route::post('getUserDetails','App\Http\Controllers\APIController@getUserDetails');

/*
    Route::post('getCategories','App\Http\Controllers\APIController@getCategories');
    Route::post('getCategoryDetailsForEdit','App\Http\Controllers\APIController@getCategoryDetailsForEdit');
    Route::post('removeCategory','App\Http\Controllers\APIController@removeCategory');
    Route::post('updateCategory','App\Http\Controllers\APIController@updateCategory');
    Route::post('saveCategory','App\Http\Controllers\APIController@saveCategory');
    Route::post('getCategoriesOrderByName','App\Http\Controllers\APIController@getCategoriesOrderByName');*/
    
});

Route::get('/admin/{url}', function () {
    $userDetails=['id'=>1, 'name'=>'Biki Mallik','isAdmin'=>true];
    return view('admin',compact('userDetails'));
});
Route::get('/admin/{url1}/{url2}', function () {
    $userDetails=['id'=>1, 'name'=>'Biki Mallik','isAdmin'=>true];
    return view('admin',compact('userDetails'));
});
Route::get('/admin', function () {
     $userDetails=['id'=>1, 'name'=>'Biki Mallik','isAdmin'=>true];
    return view('admin',compact('userDetails'));
});

Route::get('/insert', function () {
    $user= new App\Models\User;
    $user->email="Admin";
    $user->name="bkmallik18@gmail.com";
    $user->password=Hash::make(11111111);
    $user->phone="";
    $user->userType="";
    $user->save();
});
