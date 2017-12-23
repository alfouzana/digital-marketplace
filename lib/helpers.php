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