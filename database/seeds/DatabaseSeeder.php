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

        $this->createDemoUser();
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

    protected function createDemoUser()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'John Doe',
            'email' => 'jdoe@example.com',
            'password' => bcrypt('123')
        ]);

        $products[] = create_pending_product([
            'user_id' => $user->id,
        ]);

        $products[] = create_approved_product([
            'user_id' => $user->id,
        ]);

        $products[] = create_rejected_product([
            'user_id' => $user->id,
        ]);

        // add an archived product
        $products[] = tap(create_approved_product([
            'user_id' => $user->id
        ]), function ($product) {
            $product->delete();
        });

        collect($products)->each(function ($product) {
            create_product_files($product->id);
        });
    }

    protected function createDemoAdmin()
    {
        factory(App\User::class)->states('admin')->create([
            'name' => 'Richard Roe',
            'email' => 'rroe@example.com',
            'password' => bcrypt('123'),
        ]);
    }
}
