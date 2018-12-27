<?php

use App\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->cleanDatabase();

        $this->cleanStorage();

        $products = create_approved_product([], 20);

        $products->each(function ($product) {
           create_product_files($product->id);
        });

        $this->createDemoVendor();
        $this->createDemoAdmin();
    }

    protected function cleanDatabase()
    {
        \App\Product::truncate();
        \App\File::truncate();
        \App\User::truncate();
        \App\Category::truncate();
    }

    protected function cleanStorage()
    {
        \Illuminate\Support\Facades\Storage::disk('public')
            ->deleteDirectory('product_covers');

        \Illuminate\Support\Facades\Storage::disk('public')
            ->deleteDirectory('product_samples');

        \Illuminate\Support\Facades\Storage::disk('local')
        ->deleteDirectory('product_files');
    }

    protected function createDemoVendor()
    {
        $vendor = factory(\App\Vendor::class)->create([
            'name' => 'Demo Vendor',
            'email' => 'vendor@example.com',
            'password' => bcrypt('123')
        ]);

        $vendorProducts[] = create_pending_product([
            'user_id' => $vendor->id,
        ]);

        $vendorProducts[] = create_approved_product([
            'user_id' => $vendor->id,
        ]);

        $vendorProducts[] = create_rejected_product([
            'user_id'  =>$vendor->id,
        ]);

        collect($vendorProducts)->each(function ($product) {
            create_product_files($product->id);
        });
    }

    protected function createDemoAdmin()
    {
        factory(Admin::class)->create([
            'name' => 'Demo Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123'),
        ]);
    }
}
