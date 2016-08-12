<?php

use Illuminate\Support\Facades\Route;

/**
 * Temporary solution for middleware in routes
 * TODO: remove in favor of setting the config for middleware outside of the routes file
 */
$middleware_array = array('DDPro\Admin\Http\Middleware\ValidateAdmin');
if (is_array(config('administrator.middleware'))) {
    $middleware_array = array_merge(config('administrator.middleware'), $middleware_array);
}

/**
 * Routes
 */
Route::group(
    array(
        'domain'     => config('administrator.domain'),
        'prefix'     => config('administrator.uri'),
        'middleware' => $middleware_array
    ), function () {
    //Admin Dashboard
    Route::get('/', array(
        'as'   => 'admin_dashboard',
        'uses' => 'DDPro\Admin\Http\Controllers\AdminController@dashboard',
    ));

    //File Downloads
    Route::get('file_download', array(
        'as'   => 'admin_file_download',
        'uses' => 'DDPro\Admin\Http\Controllers\AdminController@fileDownload'
    ));

    //Custom Pages
    Route::get('page/{page}', array(
        'as'   => 'admin_page',
        'uses' => 'DDPro\Admin\Http\Controllers\AdminController@page'
    ));

    Route::group(
        array(
            'middleware' => [
                'DDPro\Admin\Http\Middleware\ValidateSettings',
                'DDPro\Admin\Http\Middleware\PostValidate']
        ), function () {
        //Settings Pages
        Route::get('settings/{settings}', array(
            'as'   => 'admin_settings',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@settings'
        ));

        //Display a settings file
        Route::get('settings/{settings}/file', array(
            'as'   => 'admin_settings_display_file',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@displayFile'
        ));

        //Save Item
        Route::post('settings/{settings}/save', array(
            'as'   => 'admin_settings_save',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@settingsSave'
        ));

        //Custom Action
        Route::post('settings/{settings}/custom_action', array(
            'as'   => 'admin_settings_custom_action',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@settingsCustomAction'
        ));

        //Settings file upload
        Route::post('settings/{settings}/{field}/file_upload', array(
            'as'   => 'admin_settings_file_upload',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@fileUpload'
        ));
    });

    //Switch locales
    Route::get('switch_locale/{locale}', array(
        'as'   => 'admin_switch_locale',
        'uses' => 'DDPro\Admin\Http\Controllers\AdminController@switchLocale'
    ));

    //The route group for all other requests needs to validate admin, model, and add assets
    Route::group(
        array(
            'middleware' => [
                'DDPro\Admin\Http\Middleware\ValidateModel',
                'DDPro\Admin\Http\Middleware\PostValidate']
        ), function () {
        //Model Index
        Route::get('{model}', array(
            'as'   => 'admin_index',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@index'
        ));

        //New Item
        Route::get('{model}/new', array(
            'as'   => 'admin_new_item',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@item'
        ));

        //Update a relationship's items with constraints
        Route::post('{model}/update_options', array(
            'as'   => 'admin_update_options',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@updateOptions'
        ));

        //Display an image or file field's image or file
        Route::get('{model}/file', array(
            'as'   => 'admin_display_file',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@displayFile'
        ));

        //Updating Rows Per Page
        Route::post('{model}/rows_per_page', array(
            'as'   => 'admin_rows_per_page',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@rowsPerPage'
        ));

        //Get results
        Route::post('{model}/results', array(
            'as'   => 'admin_get_results',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@results'
        ));

        //Custom Model Action
        Route::post('{model}/custom_action', array(
            'as'   => 'admin_custom_model_action',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@customModelAction'
        ));

        //Get Item
        Route::get('{model}/{id}', array(
            'as'   => 'admin_get_item',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@item'
        ));

        //File Uploads
        Route::post('{model}/{field}/file_upload', array(
            'as'   => 'admin_file_upload',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@fileUpload'
        ));

        //Save Item
        Route::post('{model}/{id?}/save', array(
            'as'   => 'admin_save_item',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@save'
        ));

        //Delete Item
        Route::post('{model}/{id}/delete', array(
            'as'   => 'admin_delete_item',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@delete'
        ));

        //Custom Item Action
        Route::post('{model}/{id}/custom_action', array(
            'as'   => 'admin_custom_model_item_action',
            'uses' => 'DDPro\Admin\Http\Controllers\AdminController@customModelItemAction'
        ));
    });
});
