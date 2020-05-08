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

    public function getProducers()
    {
        return Producer::all();
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($request->logo) {
            $name = time() . '.' . explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];

            Image::make($request->logo)->save(public_path('img/producers/') . $name);
            $request->merge(['logo' => $name]);
        }
        $producer = Producer::create($request->all());

        return response([
            'producer' => $producer
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
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);
        $currentLogo = Producer::where('id', $id)->value('logo');

        if ($request->logo != $currentLogo) {
            $name = time() . '.' . explode('/',
                    explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];

            Image::make($request->logo)->save(public_path('img/producers/') . $name);
            $request->merge(['logo' => $name]);
        }
        Producer::where('id', $id)->update($request->all());

        return response([
            'message' => 'Updated Info Successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy($id)
    {
        $producer = Producer::findOrFail($id);
        $producer->delete();

        return ['message' => 'Producer deleted successfully!'];
    }
}
