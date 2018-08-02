<?php

// private routes for upload data

// Route::get('upload-data',function(){
// 	return View::make('admin.upload_data');
// });
// Route::post('upload-data','UserController@uploadData');


/* Admin routes */
Route::get('/', function(){
    return View::make('login',[]);
});
Route::get('/receipt',function(){
	return View::make('admin.payment.receipt');
});	

Route::get('/capitalization','UserController@capitalization');	

Route::get('/registerStep1/{id?}', 'RegistrationController@registration_step1');
Route::post('/registerStep1/{id?}', 'RegistrationController@post_registration_step1');

// Route::post'/correctData/{document_id}','ApprovalController@correctData');
Route::get('/registerStep2/{id}', 'RegistrationController@registration_step2');
Route::post('/registerStep2', 'RegistrationController@post_registration_step2');

Route::get('/registerStep3/{id}', 'RegistrationController@registration_step3');
Route::post('/registerStep3', 'RegistrationController@post_registration_step3');

Route::get('/verify/{hash}','UserController@activeAccount');
Route::get('/reset', function(){
    return View::make('reset');
});

Route::get('/view-all-coaches','CoachController@viewAllCoaches');
// Route::get('/exportCoaches','ExcelExportController@exportCoaches');

Route::get('/correctData', function(){
    $documents = CoachDocument::select('coach_documents.id','coaches.status as coach_status')->join('coaches','coaches.id','=','coach_documents.coach_id')->get();
    foreach ($documents as $document) {
    	if($document->coach_status != 1){
    		$doc = CoachDocument::find($document->id);
    		$doc->status = 0;
    		$doc->save();
    	}
    }

    $licenses = CoachLicense::select('coach_licenses.id','coaches.status as coach_status')->join('coaches','coaches.id','=','coach_licenses.coach_id')->get();
    foreach ($licenses as $license) {
    	if($license->coach_status != 1){
    		$doc = coachLicense::find($license->id);
    		$doc->status = 0;
    		$doc->save();
    	}
    }

    $employmentDetails = EmploymentDetails::select('employment_details.id','coaches.status as coach_status')->join('coaches','coaches.id','=','employment_details.coach_id')->get();
    foreach ($employmentDetails as $emp) {
    	if($emp->coach_status != 1){
    		$doc = EmploymentDetails::find($emp->id);
    		$doc->status = 0;
    		$doc->save();
    	}
    }

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

Route::group(['before' => 'auth'], function () {
    Route::post('/approve/{entity_type}/{etity_id}','ApprovalController@postApprove');
    Route::get('/resultExport','ExcelExportController@resultExport');
});

Route::group(['before' => 'auth',"prefix"=>'pendingApprovals'], function () {
    Route::get('/pendingDocument','ApprovalController@pendingDocument');
    Route::get('/pendingLicenses','ApprovalController@pendingLicenses');
    Route::get('/pendingEmploymentDetails','ApprovalController@pendingEmploymentDetails');
    Route::get('/pendingActivities','ApprovalController@pendingActivities');
});

Route::group(['before' => 'auth',"prefix"=>'control'], function () {
    Route::get('/applications/details/{application_id}','ApplicationController@detailsApplication');
    Route::get('editAppLog/{log_id}','ApplicationController@editAppLog');
    Route::put('updateAppLog/{log_id}','ApplicationController@updateAppLog');

    Route::delete('deleteAppLog/{log_id}','ApplicationController@deleteAppLog');

    Route::post('/applications/log/{application_id}','ApplicationController@postLog');
    Route::put('/payments/{payment_id}','PaymentController@putPayment');
});

Route::group(['prefix'=>'coach','before'=>'auth'], function () {

	Route::post('/postEmployment','CoachController@postEmployment');
	Route::get('/employmentDetails','CoachController@employmentDetails');
	Route::get('/editEmployment/{id}','CoachController@editEmployment');
	Route::post('addEmployment','CoachController@addEmployment');
	Route::get('addNewEmployment','CoachController@addNewEmployment');
	Route::post('updateEmployment/{id}','CoachController@updateEmployment');
	Route::delete('/deleteEmployment/{id}','CoachController@deleteEmployment');

	Route::get('/contactInformation','CoachController@contactInformation');
	Route::post('updateContact','CoachController@updateContact');
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
		Route::get('/edit/{id}','CoachController@editDocument');
		Route::post('/update/{id}','CoachController@updateDocument');
		Route::delete('/delete/{id}','CoachController@deleteDocument');
	});
	Route::group(["prefix"=>"coachLicense"],function(){
		Route::get('/','CoachController@coachLicense');
		Route::post('/add','CoachController@addLicense');
		Route::get('/edit/{id}','CoachController@editLicense');
		Route::post('/update/{id}','CoachController@updateLicense');
		Route::delete('/delete/{coach_license_id}','CoachController@deleteLicense');
	});
	Route::get('/passportDetails','CoachController@passportDetails');
	Route::post('updatePassport','CoachController@updatePassport');

	Route::group(["prefix"=>'Payment',"before"=>['auth']],function(){
		Route::get('/{application_id}','PaymentController@Payment');
		Route::post('option/{application_id}','PaymentController@paymentOption');
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
		Route::get('/upcoming','CourseController@upcomingCourse');
		Route::get('/inactive','CourseController@inactiveCourse');
		Route::get('/details/{course_id}','ApplicationController@details');
		Route::post('/apply/{course_id}','ApplicationController@applyCourse');
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

			Route::get('/logins','AdminController@logins');
			Route::get('/logins/{user_id}','AdminController@loginByUser');

			Route::get('/changeOfficialType/{user_id}','AdminController@changeOfficialType');
			Route::put('/changeOfficialType/{user_id}','AdminController@updateOfficialType');

			Route::get('/changeEmail/{user_id}','AdminController@changeEmail');
			Route::put('/changeEmail/{user_id}','AdminController@updateEmail');

			Route::get('/reset-password/{user_id}','AdminController@resetUserPassword');
			Route::put('/reset-password/{user_id}','AdminController@changeUserPassword');
			
			Route::get('/editRemark/{approval_log_id}','AdminController@editRemark');
			Route::put('/updateRemark/{approval_log_id}','AdminController@updateRemark');

			Route::delete('/deleteRemark/{approval_log_id}','AdminController@deleteRemark');

			Route::get('/approvedCoach','AdminController@approvedCoach');
			Route::get('/pendingCoach','AdminController@pendingCoach');
			Route::delete('/deleteCoachProfile/{coach_id}','AdminController@deleteCoachProfile');

			Route::get('/inactiveCoach','AdminController@inactiveCoach');
			Route::get('viewCoach/{id}','AdminController@viewCoach');
			Route::get('checkDuplicate/{coach_id}','AdminController@checkDuplicate');
			Route::get('editCoachProfile/{coach_id}','AdminController@editCoachProfile');
			Route::post('updateCoachProfile/{coach_id}','AdminController@updateCoachProfile');
			Route::get('viewCoachDetails/{id}','AdminController@viewCoachDetails');
			Route::get('viewApproveList/{coach_license_id}','ApprovalController@viewApproveList');
			Route::get('all','AdminController@allCoach');
			Route::get('markCoachStatus/{flag}/{id}/{remarks}/{count}','AdminController@markCoachStatus');
			Route::get('/coachExport/{flag}','ExcelExportController@coachExport');
			Route::get('/exportLicence','ExcelExportController@exportLicence');
			Route::get('/coursesExport/{flag}','ExcelExportController@coursesExport');
			Route::get('applicationExport/{flag}/{course_id?}','ExcelExportController@applicationExport');
			
			
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
			
			Route::group(["prefix"=>'Courses'],function(){
				Route::get('/','CourseController@index');
				Route::get('/active','CourseController@active');
				Route::get('/inactive','CourseController@inactive');
				Route::get('/upcoming','CourseController@upcoming');
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
			Route::group(["prefix"=>'ApplicationResults',"before"=>['auth']],function(){
				Route::get('/','AdminController@ApplicationsResults');
				Route::get('/view/{application_id}','AdminController@ViewApplicationsResult');
				Route::get('/editParameterMarks/{application_id}','AdminController@editParameterMarks');
				Route::get('/uploadLicense/{application_id}','AdminController@uploadLicense');
				Route::post('/storeLicense/{coach_id}','AdminController@storeLicense');
				Route::get('/exportApplications','resultAdminController@exportExcel');
				Route::delete('/delete/{license_id}','AdminController@deleteLicense');
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
				Route::get('/all','ApplicationController@ApprovedApplications');
				Route::delete('/select/{application_id}','ApplicationController@selectApplication'); // but it is not deleting anything

				Route::delete('/not-select/{application_id}','ApplicationController@notSelectApplication'); // but it is not deleting anything
			});

			Route::get('/payment/approve/{payment_id}','PaymentController@approvePaymentStatus');
		});
	});
});

Route::group(["prefix"=>'resultAdmin','before'=>["auth","resultAdmin"]],function(){
	Route::get('/dashboard','resultAdminController@dashboard');
	Route::get('/','resultAdminController@index');
	Route::get('/exportApplications','resultAdminController@exportExcel');
	
	Route::group(["prefix"=>"result"],function(){
		Route::get('/','resultAdminController@indexResult');
		Route::post('/insert','resultAdminController@insert');
		Route::get('/details/{id}','resultAdminController@details');
		Route::get('/view/{id}','resultAdminController@view');
		Route::get('/editParameterMarks/{id}','resultAdminController@editParameterMarks');
		Route::POST('/update/{id}','resultAdminController@update');
		Route::delete('/delete/{id}','resultAdminController@delete');
		Route::post('/uploadMarks','resultAdminController@uploadMarks');
	});

	Route::group(["prefix"=>"courses"],function(){
		Route::get('/','instructorCourseController@index');
		Route::get('/viewApplications/{course_id}','instructorCourseController@courseApplications');
		Route::post('/addResult','instructorCourseController@addResult');
	
	});

	Route::group(["prefix"=>"d-license"],function(){
		Route::get('/','dLicenseController@index');
		Route::get('/add','dLicenseController@add');
		Route::post('/add','dLicenseController@addLicense');
		Route::get('/edit/{d_course_id}','dLicenseController@edit');
		Route::post('/update/{d_course_id}','dLicenseController@update');
		Route::delete('/delete/{d_course_id}','dLicenseController@delete');
		Route::get('/view/{d_course_id}','dLicenseController@view');
	
	});

});

Route::group(["prefix"=>'superAdmin','before'=>["auth","superAdmin"]],function(){
	Route::get('/dashboard','SuperAdminController@dashboard');

	Route::group(["prefix"=>'manage_logins'],function(){
		Route::get('/','SuperAdminController@manage_logins');
		Route::get('/add','SuperAdminController@addUser');
		Route::post('/store','SuperAdminController@storeUser');
		Route::get('/edit/{user_id}','SuperAdminController@editUser');
		Route::post('/update/{user_id}','SuperAdminController@updateUser');
		Route::delete('/delete/{user_id}','SuperAdminController@deleteUser');
	});
});