<?php

Route::group([
     'middleware' => ['web', 'is:super'],
     'prefix'     => 'manage/notifier',
     'namespace'  => 'Modules\Notifier\Http\Controllers',
],
     function () {
         Route::get('/', 'NotifierController@index');
         Route::post('save', 'NotifierController@save')->name('notifier.save');
         Route::get('channel/addUI', "ChannelController@addUI")->name('notifier.channel.addUI');
         Route::post('channel/add', "ChannelController@add")->name('notifier.channel.add');
         Route::post('save/info', 'ChannelController@saveDriverInfo')->name('notifier.driver.save.info');
         Route::get('editUI/driver/{id}', "ChannelController@editDriverUI")->name('notifier.driver.editUI');
         Route::post('edit/driver', "ChannelController@editDriver")->name('notifier.driver.edit');
         Route::get('editUI/channel/{channel_name}', "ChannelController@editChannelUI")
              ->name('notifier.channel.editUI')
         ;
         Route::post('edit/channel', "ChannelController@editChannel")->name('notifier.channel.edit');
         Route::get('deleteUI/driver/{id}', "ChannelController@deleteDriverUI")->name('notifier.driver.deleteUI');
         Route::post('delete/driver', "ChannelController@deleteDriver")->name('notifier.driver.delete');
         Route::get('deleteUI/channel/{channel_name}', "ChannelController@deleteChannelUI")
              ->name('notifier.channel.deleteUI')
         ;
         Route::post('delete/channel', "ChannelController@deleteChannel")->name('notifier.channel.delete');
     });
