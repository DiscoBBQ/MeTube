<?php

class MediaController extends BaseController {
	public function upload() {
		$file = Input::file('file');
        $extension = $file->getClientOriginalExtension();

		DB::table('media')->insert(array('title' => Input::get('title'),
										 'description' => Input::get('description'),
										 'extension' => $extension));

		$destinationPath = 'uploaded_media/';

		//$id = DB::table('media')->where('')

		$filename = Input::get('title').'.'.$extension;
		$uploadSuccess = Input::file('file')->move($destinationPath, $filename);

        return "done";
	} 
}