<?php

Route::get('/', function () {
    return redirect('/api-tester');
});

Route::get('redirect/{times}',
    ['as' => 'redirect-test', 'uses' => 'DemoController@redirect']);
Route::get('json','DemoController@json');
Route::get('var_dump','DemoController@varDump');
Route::get('json','DemoController@json');
Route::get('string','DemoController@string');
Route::get('abort','DemoController@abort');
Route::get('i-dont-have-controller','MissingController@action');
Route::get('i-dont-have-action','DemoController@action');