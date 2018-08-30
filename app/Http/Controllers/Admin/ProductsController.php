<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return Product::anyApprovalStatus()
            ->when(\request()->filled('approval_status'), function (Builder $query) {
                $query->where('approval_status', \request()->input('approval_status'));
            })
            ->paginate();
    }
}
