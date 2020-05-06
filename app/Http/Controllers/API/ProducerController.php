<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Producer;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Producer::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
//        dd($request);
        $this->validate($request, [
           'name' => 'required' ,
            'description' => 'required'
        ]);

        if ($request->logo) {
            $name = time() . '.' . explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];

            Image::make($request->logo)->save(public_path('img/products/') . $name);
        }
        $producer = Producer::create([
            'name' => $request->input('name'),
            'logo' => $request->logo,
            'description' => $request->input('description')
        ]);

        return response([
            'producer' => $producer
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $producer = Producer::findOrFail($id);
        $producer->delete();

        return ['message' => 'Producer deleted successfully!'];
    }
}
