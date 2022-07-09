<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    protected $product = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->middleware('auth:api');
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products['tage_count']=Tag::count();
        $products['category_count']=Category::count();
        $products['products_count']=Product::count();
        $products['users_count']=User::count();
        $products['products'] = $this->product->latest()->with('category', 'tags')->paginate(5);

        return $this->sendResponse($products, 'Product list');
    }
}
