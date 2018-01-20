<?php

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

        $this->cleanResourceDirectories();

        create_approved_product([], 20);

        $this->createDemoVendor();
    }

    protected function cleanDatabase()
    {
        \App\Product::truncate();
        \App\User::truncate();
        \App\Category::truncate();
    }

    protected function cleanResourceDirectories()
    {
        clean_resource_directory(product_covers_path());
        clean_resource_directory(product_samples_path());
        clean_resource_directory(product_files_path());
    }

    protected function createDemoVendor()
    {
        $vendor = factory(\App\Vendor::class)->create([
            'name' => 'Demo Vendor',
            'email' => 'vendor@example.com',
            'password' => bcrypt('123')
        ]);

        create_pending_product([
            'user_id' => $vendor->id,
        ]);

        create_approved_product([
            'user_id' => $vendor->id,
        ]);

        create_rejected_product([
            'user_id'  =>$vendor->id,
        ]);
    }
}
