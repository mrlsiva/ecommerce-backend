<?php
namespace App\Http\Controllers\Ecom\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class Media extends Controller
{

	public function uploadMedia($request, $name, $model, $collection)
    {
       if ($request->hasFile($name)) {
			$model->addMediaFromRequest($name)// name of the file input
			->toMediaCollection($collection);
		}
    }

	public function uploadMultipleMedia($request, $name, $model, $collection){
		if ($request[$name]) {
			$fileAdders = $model->addMultipleMediaFromRequest([$name])
			 ->each(function ($fileAdder) use ($collection) {
				 $fileAdder->toMediaCollection($collection);
			 });   
		}
	}

	public function clearMedia($model, $collection){
		/* $mediaCount = $model->getMedia($collection)->count();
		if ($mediaCount === 0) {
			return 'No media found in the specified collection.';
		} */
		$model->clearMediaCollection($collection);
	}
}