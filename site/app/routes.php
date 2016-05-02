<?php

/* Admin routes */
Route::get('/', function(){
	$date = [''=>'date'];
	for ($i=1; $i <=31 ; $i++) { 
		$date[$i] = $i;
	}

	$month = [''=>'month',"jan"=>"jan","feb"=>"feb","Mar"=>"Mar","Apr"=>"Apr","May"=>"May","Jun"=>"Jun","Jul"=>"Jul","Aug"=>"Aug","Sep"=>"Sep","Oct"=>"Oct","Nov"=>"Nov","Dec"=>"Dec"];
	$year = [''=>'year'];
	for ($i=1950; $i <=2000 ; $i++) { 
		$year[$i] = $i;
	}
	$ex_year = [''=>'year'];
	for ($i=2012; $i <=2030 ; $i++) { 
		$ex_year[$i] = $i;
	}
	$state = State::states();
    return View::make('login',['date'=>$date,'month'=>$month,'year'=>$year,'ex_year'=>$ex_year,'state'=>$state]);
});
Route::get('/reset', function(){
    return View::make('reset');
});
Route::post('/tm_admin', 'UserController@postLogin');
Route::post('/reset', 'UserController@postReset');


Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/');
});

Route::post('/register', 'CoachController@register');

Route::group(['prefix'=>'coach','before'=>['auth','coach']], function () {
	Route::get('/','CoachController@index');
	Route::post('/postEmployment','CoachController@postEmployment');
	Route::post('updateProfile','CoachController@updateProfile');
	Route::post('updatePassport','CoachController@updatePassport');
	Route::post('updateContact','CoachController@updateContact');
	Route::get('/employmentDetails','CoachController@employmentDetails');
	Route::get('/editEmployment/{id}','CoachController@editEmployment');
	Route::post('addEmployment','CoachController@addEmployment');
	Route::get('addNewEmployment','CoachController@addNewEmployment');
	Route::post('updateEmployment/{id}','CoachController@updateEmployment');
	Route::delete('/deleteEmployment/{id}','CoachController@deleteEmployment');

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
		Route::get('/apply/{course_id}','ApplicationController@applyCourse');
	});
	Route::group(["prefix"=>'applications'],function(){
		Route::get('/','ApplicationController@allApplications');
		Route::get('/applied','ApplicationController@applied');
		Route::get('/active','ApplicationController@active');
		Route::get('/inactive','ApplicationController@inactive');
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
			Route::get('markCoachStatus/{id}','AdminController@markCoachStatus');
			
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
				Route::get('/markApplication/{id}','ApplicationController@markApplication');
				
			});
		});
	});
});