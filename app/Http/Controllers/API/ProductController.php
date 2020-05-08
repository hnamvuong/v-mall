<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Product::with('category', 'producer')->latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'producer_id' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'price' => 'required'
        ]);
        if ($request->image) {
            $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];

            Image::make($request->image)->save(public_path('img/products/') . $name);
            $request->merge(['image' => $name]);
        }
        $product = Product::create($request->all());

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'producer_id' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'price' => 'required'
        ]);
        $currentImage = Product::where('id', $id)->value('image');

        if ($request->image != $currentImage) {
            $name = time() . '.' . explode('/',
                    explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];

            Image::make($request->image)->save(public_path('img/products/') . $name);
            $request->merge(['image' => $name]);
        }

        Product::where('id', $id)->update($request->all());

        return response()->json([
            'message' => "Update product 's info successfully!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
