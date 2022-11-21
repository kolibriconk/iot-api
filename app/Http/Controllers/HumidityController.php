<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HumidityRequest;
use App\Http\Resources\HumidityResource;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Humidity;

class HumidityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HumidityResource::collection(Humidity::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HumidityRequest $request)
    {
        try {
            $humidity = new Humidity;
            $humidity->fill($request->validated())->save();
            return new HumidityResource($humidity);

        } catch(\Exception $exception) {
            throw new HttpException(400, "Invalid data - {$exception}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $humidity = Humidity::findOrfail($id);

        return new HumidityResource($humidity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HumidityRequest $request, $id)
    {
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }

        try {
           $humidity = Humidity::find($id);
           $humidity->fill($request->validated())->save();

           return new HumidityResource($humidity);

        } catch(\Exception $exception) {
           throw new HttpException(400, "Invalid data - {$exception->getMessage}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $humidity = Humidity::findOrfail($id);
        $humidity->delete();

        return response()->json(null, 204);
    }
}
