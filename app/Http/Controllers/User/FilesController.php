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

    	$path = $request->file('file')
    		->store(
    			$this->storePath($request['assoc']),
    			$this->storeDisk($request['assoc'])
    		);

    	$file = File::create([
    		'assoc' => $request['assoc'],
    		'disk' => $this->storeDisk($request['assoc']),
    		'path' => $path,
    		'original_name' => $request->file('file')->getClientOriginalName(),
    		'size' => $request->file('file')->getSize(),
    	]);

    	return response()->json([
    		'id' => $file->id,
    		'url' => \Storage::disk($file->disk)->url($file->path),
    	]);
    }

    protected function storeDisk($assoc) 
    {
    	if ($assoc == File::ASSOC_COVER || $assoc == File::ASSOC_SAMPLE)
    	{
    		return 'public';
    	}

    	if ($assoc == File::ASSOC_PRODUCT)
    	{
    		return 'local';
    	}
    }

    protected function storePath($assoc)
    {
    	if ($assoc == File::ASSOC_COVER) {
    		return 'product_covers';
    	} 

    	if ($assoc == File::ASSOC_SAMPLE) {
    		return 'product_samples';
    	}

    	if ($assoc = File::ASSOC_PRODUCT) {
    		return 'product_files';
    	}
    }
}
