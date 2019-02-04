<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FilesController extends Controller
{
    public function store(Request $request)
    {
    	// todo: Validate the request

    	// $this->validate($request, [

    	// ])

    	$path = $request->file('file')->store('product_covers', 'public');

    	$file = File::create([
    		'assoc' => 'cover',
    		'disk' => 'public',
    		'path' => $path,
    	]);

    	return response()->json([
    		'id' => $file->id,
    		'url' => \Storage::disk($file->disk)->url($file->path)
    	]);
    }
}
