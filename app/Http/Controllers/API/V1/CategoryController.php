<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    protected $category = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->middleware('auth:api');
        $this->category = $category;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->latest()->paginate(10);

        return $this->sendResponse($categories, 'Category list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $categories = $this->category->pluck('name', 'id');

        return $this->sendResponse($categories, 'Category list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tag = $this->category->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->sendResponse($tag, 'Category Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $tag = $this->category->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Category Information has been updated');
    }

    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $category = $this->category->findOrFail($id);

        $category->delete();

        return $this->sendResponse($category, 'Product has been Deleted');
    }
    public function search($date)
    {
        $daten = $this->category->where('name','like','%'.$date.'%')
        ->orWhere('description','like','%'.$date.'%')
        ->latest()->paginate(10);
        return response()->json($daten);

    }
}
