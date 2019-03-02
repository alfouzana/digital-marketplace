<?php

namespace Tests\Feature\Admin\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Product;
use Mtvs\EloquentApproval\ApprovalStatuses;
use Carbon\Carbon;

class ApprovalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_admin_can_change_the_approval_status_of_a_product()
    {
    	$admin = factory(User::class)->states('admin')->create();

    	$product = factory(Product::class)->create();

    	$this->actingAs($admin);

    	$approvalStatuses = [
    		ApprovalStatuses::APPROVED,
    		ApprovalStatuses::REJECTED,
    		ApprovalStatuses::PENDING,
    	];

    	foreach($approvalStatuses as $status) {
    		$this->postJson('/admin/product/'.$product->id.'/approval', [
	    		'status' => $status
	    	])->assertJson([
                'approval_status' => approval_lang($status),
                'approval_at' => Carbon::now()->diffForHumans(),
                'updated_at' => Carbon::now()->diffForHumans(),
                'approval_context' => approval_context($status)
            ]);

	    	$this->assertDatabaseHas('products', [
	    		'id' => $product->id,
	    		'approval_status' => $status,
	    		'approval_at' => now(),
	    	]);
    	}
    }
}
