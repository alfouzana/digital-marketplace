<?php

namespace Tests\Feature\User\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Product;
use Mtvs\EloquentApproval\ApprovalStatuses;
use Illuminate\Support\Str;

class CreateTest extends TestCase
{
	use WithFaker;
	use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_create_a_product()
    {
    	$user = factory(User::class)->create();

    	$data = array_only(factory(Product::class)->raw(), [
    		'cover_id', 'sample_id', 'file_id',
    		'category_id', 'title', 'body', 'price',
    	]);

    	$this->actingAs($user);

    	$this->post('/user/products', $data)
    		->assertRedirect('/user/products');

    	$this->assertDatabaseHas('products', array_merge($data, [
    		'slug' => Str::slug($data['title']),
    		'user_id' => $user->id,
    		'created_at' => now(),
    		'updated_at' => now(),
    		'approval_status' => ApprovalStatuses::PENDING,
    		'approval_at' => null,
    		'deleted_at' => null,
    	]));
    }
}
