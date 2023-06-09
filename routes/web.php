<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions Controller
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/index', 'PermissionsController@index');
    Route::post('permissions/addPermission', 'PermissionsController@addPermission');
    Route::post('permissions/addPermissionData', 'PermissionsController@addPermissionData');
    Route::resource('permissions', 'PermissionsController');

    // Roles Controller
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users Controller
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/index', 'UsersController@index')->name('users.index');
    Route::post('users/addUser', 'UsersController@addUser');
    Route::post('users/addUserData', 'UsersController@addUserData');
    Route::put('users/editUser', 'UsersController@editUser');
    Route::resource('users', 'UsersController');

    // services Controller
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('ser')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles Controller
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // services Controller
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::post('services/index', 'ServicesController@index');
    Route::post('services/addService', 'ServicesController@addService');
    Route::post('services/addServiceData', 'ServicesController@addServiceData');
    Route::post('services/editService', 'ServicesController@editService');
    Route::resource('services', 'ServicesController');

    // Clients Controller
    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');
    Route::post('clients/index', 'ClientsController@index');
    Route::post('clients/addClient', 'ClientsController@addClient');
    Route::post('clients/addClientData', 'ClientsController@addClientData');
    Route::post('clients/editClient', 'ClientsController@editClient');
    Route::resource('clients', 'ClientsController');

    // Appointments Controller
    Route::delete('appointments/destroy', 'AppointmentsController@massDestroy')->name('appointments.massDestroy');
    Route::post('appointments/addAppointment', 'AppointmentsController@addAppointment');
    Route::post('appointments/addAppointmentData', 'AppointmentsController@addAppointmentData');
    Route::post('appointments/editAppointment', 'AppointmentsController@editAppointment');
    Route::resource('appointments', 'AppointmentsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
});
