<?php

function public_uploads_path($path = '')
{
    return public_path('uploads'.($path ? DIRECTORY_SEPARATOR.$path : $path));
}

function product_covers_path()
{
    return public_uploads_path(app('product_covers_dir'));
}

function product_samples_path()
{
    return public_uploads_path(app('product_samples_dir'));
}

function protected_uploads_path($path = '')
{
    return resource_path('uploads'.($path ? DIRECTORY_SEPARATOR.$path : ''));
}

function product_files_path()
{
    return protected_uploads_path(app('product_files_dir'));
}

// TODO: Move factory helpers to database/factories/helpers.php

/**
 * @param string $directory
 * @return bool
 */
function clean_resource_directory($directory)
{
    if (! app('files')->isDirectory($directory))
    {
        throw new InvalidArgumentException("$directory is not a directory.");
    }

    $files = app('files')->files($directory);

    $paths = array_map(function (SplFileInfo $file) {
            return $file->getRealPath();
    }, $files);

    return app('files')->delete($paths);
}

function create_approved_product($overrides = [], $times = 1)
{
    $products = factory(\App\Product::class, $times)->create($overrides);

    $products->each(function (\App\Product $product) {
        $product->approve();
    });

    return $times == 1 ? $products[0] : $products;
}

function create_rejected_product($overrides = [], $times = 1)
{
    $products = factory(\App\Product::class, $times)->create($overrides);

    $products->each(function (\App\Product $product) {
        $product->reject();
    });

    return $times == 1 ? $products[0] : $products;
}

function create_pending_product($overrides = [], $times = 1)
{
    $products = factory(\App\Product::class, $times)->create($overrides);

    return $times == 1 ? $products[0] : $products;
}

function create_product_files($product_id)
{
    factory(App\File::class)->states('cover')->create([
        'product_id' => $product_id
    ]);

    factory(App\File::class)->states('sample')->create([
        'product_id' => $product_id
    ]);

//    factory(App\File::class)->states('main')->create([
//        'product_id' => $product_id
//    ]);
}

function random_user_class()
{
    return array_random(\App\User::getSingleTableTypeMap());
}