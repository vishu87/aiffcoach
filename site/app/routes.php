<?php

/* Admin routes */
Route::get('/', function(){
    return View::make('login',[]);
});

Route::get('/registerStep1/{id?}', 'RegistrationController@registration_step1');
Route::post('/registerStep1/{id?}', 'RegistrationController@post_registration_step1');

Route::get('/registerStep2/{id}', 'RegistrationController@registration_step2');
Route::post('/registerStep2', 'RegistrationController@post_registration_step2');

Route::get('/registerStep3/{id}', 'RegistrationController@registration_step3');
Route::post('/registerStep3', 'RegistrationController@post_registration_step3');

Route::get('/verify/{hash}','UserController@activeAccount');
Route::get('/reset', function(){
    return View::make('reset');
});


Route::post('/tm_admin', 'UserController@postLogin');
Route::post('/reset', 'UserController@postReset');

Route::get('/changePassword','UserController@changePassword');
Route::post('/updatePassword','UserController@updatePassword');
Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/');
});

Route::post('/register', 'CoachController@register');

Route::group(['prefix'=>'coach','before'=>['auth','coach']], function () {
	Route::get('/contactInformation','CoachController@contactInformation');
	Route::post('updateContact','CoachController@updateContact');

	Route::post('/postEmployment','CoachController@postEmployment');
	Route::post('updateProfile','CoachController@updateProfile');

	Route::get('/personalInformation','CoachController@personalInformation');
	Route::post('/updatePersonalInformation','CoachController@updatePersonalInformation');

	Route::group(["prefix"=>"measurements"],function(){
		Route::get('/','CoachController@measurements');
		Route::post('/update','CoachController@updateMeasurements');
	});

	Route::group(["prefix"=>"addDocument"],function(){
		Route::get('/','CoachController@documents');
		Route::post('/add','CoachController@addDocument');
		Route::delete('/delete/{id}','CoachController@deleteDocument');
	});

	Route::get('/passportDetails','CoachController@passportDetails');
	Route::post('updatePassport','CoachController@updatePassport');
	
	Route::get('/employmentDetails','CoachController@employmentDetails');
	Route::get('/editEmployment/{id}','CoachController@editEmployment');
	Route::post('addEmployment','CoachController@addEmployment');
	Route::get('addNewEmployment','CoachController@addNewEmployment');
	Route::post('updateEmployment/{id}','CoachController@updateEmployment');
	Route::get('/deleteEmployment/{id}','CoachController@deleteEmployment');

	Route::group(["prefix"=>'Payment',"before"=>['auth']],function(){
		Route::get('/{id}','PaymentController@Payment');
		Route::post('option/{id}','PaymentController@paymentOption');
		
	});

	Route::group(['prefix'=>'dashboard','before'=>'auth'],function(){
		Route::get('/','CoachController@dashboard');
		
	});

	Route::group(['prefix'=>'activity','before'=>'auth'],function(){
		Route::get('/','CoachActivityController@index');
		Route::get('/add','CoachActivityController@add');
		Route::post('/insert','CoachActivityController@insert');
		Route::get('/edit/{id}','CoachActivityController@edit');
		Route::put('/update/{id}','CoachActivityController@update');
		Route::delete('/delete/{id}','CoachActivityController@delete');
	});
	Route::group(["prefix"=>'courses'],function(){
		Route::get('/','CourseController@allCourses');
		Route::get('/active','CourseController@activeCourse');
		Route::get('/inactive','CourseController@inactiveCourse');
		Route::get('/details/{course_id}/{tab_type}','ApplicationController@details');
		Route::get('/apply/{course_id}','ApplicationController@applyCourse');
	});
	Route::group(["prefix"=>'applications'],function(){
		Route::get('/','ApplicationController@allApplications');
		Route::get('/applied','ApplicationController@applied');
		// Route::get('/active','ApplicationController@active');
		// Route::get('/inactive','ApplicationController@inactive');
		Route::get('/viewMarks/{application_id}','ApplicationController@viewMarks');
		Route::delete('/delete/{id}','ApplicationController@deleteCoachApplication');
	});

});


Route::group(["before"=>['auth']],function(){
	Route::group(["before"=>['admin']],function(){
		Route::group(["prefix"=>'admin'],function(){
			Route::get('/','AdminController@index');
			Route::get('/approvedCoach','AdminController@approvedCoach');
			Route::get('/pendingCoach','AdminController@pendingCoach');
			Route::get('/inactiveCoach','AdminController@inactiveCoach');
			Route::get('viewCoach/{id}','AdminController@viewCoach');
			Route::get('viewCoachDetails/{id}','AdminController@viewCoachDetails');
			Route::get('all','AdminController@allCoach');
			Route::get('markCoachStatus/{flag}/{id}/{remarks}/{count}','AdminController@markCoachStatus');
			Route::get('/coachExport/{flag}','ExcelExportController@coachExport');
			Route::get('/exportLicence','ExcelExportController@exportLicence');
			Route::get('/coursesExport/{flag}','ExcelExportController@coursesExport');
			Route::get('applicationExport/{flag}/{course_id?}','ExcelExportController@applicationExport');
			Route::get('paymentExport/{flag}/{course_id?}','ExcelExportController@paymentExport');

			Route::group(["prefix"=>'Courses'],function(){
				Route::get('/','CourseController@index');
				Route::get('/active','CourseController@active');
				Route::get('/inactive','CourseController@inactive');
				Route::get('/add','CourseController@add');
				Route::post('/insert','CourseController@insert');
				Route::get('/edit/{id}','CourseController@edit');
				Route::put('/update/{id}','CourseController@update');
				Route::delete('/delete/{id}','CourseController@delete');
			});

			Route::group(["prefix"=>'Payment',"before"=>['auth']],function(){
				Route::get('/','PaymentController@index');
				Route::get('/pending','PaymentController@pendingPayments');
				Route::get('/disapprovePaymentStatus/{id}/{remarks?}/{count?}','PaymentController@disapprovePaymentStatus');
				Route::get('/approvePaymentStatus/{id}/{remarks?}/{count?}','PaymentController@approvePaymentStatus');
				
			});

			Route::group(["prefix"=>'License'],function(){
				Route::get('/','LicenseController@index');
				Route::get('/add','LicenseController@add');
				Route::post('/insert','LicenseController@insert');
				Route::get('/edit/{id}','LicenseController@edit');
				Route::put('/update/{id}','LicenseController@update');
				Route::delete('/delete/{id}','LicenseController@delete');
			});

			Route::group(["prefix"=>'Applications'],function(){
				Route::get('/','ApplicationController@ApprovedApplications');
				Route::get('/approved','ApplicationController@ApprovedApplications');
				Route::get('/pending','ApplicationController@PendingApplications');
				Route::get('/markApplication/{id}/{count}','ApplicationController@markApplication');
				
			});
			
		});
	});
});

Route::group(["prefix"=>'resultAdmin','before'=>["auth","resultAdmin"]],function(){
	Route::get('/dashboard','resultAdminController@dashboard');
	Route::get('/','resultAdminController@index');
	Route::get('/exportApplications/{course_id}','resultAdminController@exportExcel');

	Route::group(["prefix"=>"Parameter"],function(){
		Route::get('/','ParameterController@index');
		Route::post('/insert','ParameterController@insert');
		Route::get('/edit/{id}','ParameterController@edit');
		Route::put('/update/{id}','ParameterController@update');
		Route::delete('/delete/{id}','ParameterController@delete');
		Route::get('/exportExcel','ParameterController@exportExcel');


	});
	Route::group(["prefix"=>"coursesParameter"],function(){
		Route::get('/','CoursesParameterController@index');
		Route::post('/insert','CoursesParameterController@insert');
		Route::get('/edit/{id}','CoursesParameterController@edit');
		Route::put('/update/{id}','CoursesParameterController@update');
		Route::delete('/delete/{id}','CoursesParameterController@delete');
		Route::get('/exportExcel','CoursesParameterController@exportExcel');

	});
	Route::group(["prefix"=>"result"],function(){
		Route::get('/','resultAdminController@indexResult');
		Route::post('/insert','resultAdminController@insert');
		Route::get('/details/{id}','resultAdminController@details');
		Route::get('/view/{id}','resultAdminController@view');
		Route::get('/editParameterMarks/{id}','resultAdminController@editParameterMarks');
		Route::put('/update/{id}','resultAdminController@update');
		Route::delete('/delete/{id}','resultAdminController@delete');

	});
});