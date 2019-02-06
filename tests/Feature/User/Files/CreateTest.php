<?php

namespace Tests\Feature\User\Files;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Http\UploadedFile;
use \Storage;
use DB;

class CreateTest extends TestCase
{
	use WithFaker;
	use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_create_a_cover_file()
    {
    	Storage::fake('public');
    	
    	$user = factory(User::class)->create();

    	$this->actingAs($user);

    	$response = $this->postJson('/user/files', [
    		'assoc' => 'cover',
    		'file' => UploadedFile::fake()->image($this->faker->word)
    	]);

 	   	$this->assertDatabaseHas('files', [
    		'id' => 1,
    		'assoc' => 'cover',
    		'disk' => 'public',
    		'created_at' => now(),
    	]);

    	$file = DB::table('files')->find(1);

    	$this->assertTrue(strpos($file->path, 'product_covers') === 0);

    	Storage::disk('public')->assertExists($file->path);

    	$response->assertJson([
    		'id' => 1,
    		'url' => Storage::disk('public')->url($file->path)
    	]);
    }

    /**
     * @test
     */
    public function a_user_can_create_a_sample_file()
    {
    	Storage::fake('public');
    	
    	$user = factory(User::class)->create();

    	$this->actingAs($user);

    	$response = $this->postJson('/user/files', [
    		'assoc' => 'sample',
    		'file' => $uploadFile = UploadedFile::fake()
    			->create($this->faker->word.'.'.$this->faker->fileExtension,
    				$this->faker->randomNumber()
				)
    	]);

    	$this->assertDatabaseHas('files', [
    		'id' => 1,
    		'assoc' => 'sample',
    		'disk' => 'public',
    		'created_at' => now(),
    		'original_name' => $uploadFile->getClientOriginalName(),
    		'size' => $uploadFile->getSize()
    	]);

    	$file = DB::table('files')->find(1);

    	$this->assertTrue(strpos($file->path, 'product_samples') === 0);

    	Storage::disk('public')->assertExists($file->path);

    	$response->assertJson([
    		'id' => 1,
    		'url' => Storage::disk('public')->url($file->path),
    	]);
    }

    /**
     * @test
     */
    public function a_user_can_create_a_product_file()
    {
    	Storage::fake('local');

    	$user = factory(User::class)->create();

    	$this->actingAs($user);

    	$response = $this->postJson('/user/files', [
    		'assoc' => 'product',
    		'file' => $uploadFile = UploadedFile::fake()
    			->create($this->faker->word.'.'.$this->faker->fileExtension,
    				$this->faker->randomNumber()
				)
    	]);

    	$this->assertDatabaseHas('files', [
    		'id' => 1,
    		'assoc' => 'product',
    		'disk' => 'local',
    		'created_at' => now(),
    		'original_name' => $uploadFile->getClientOriginalName(),
    		'size' => $uploadFile->getSize()
    	]);

    	$file = DB::table('files')->find(1);

    	$this->assertTrue(strpos($file->path, 'product_files') === 0);

    	Storage::disk('local')->assertExists($file->path);

    	$response->assertJson([
    		'id' => 1,
    	]);
    }	
}
