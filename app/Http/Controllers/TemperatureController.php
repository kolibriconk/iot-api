<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TemperatureRequest;
use App\Http\Resources\TemperatureResource;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Temperature;

class TemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TemperatureResource::collection(Temperature::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemperatureRequest $request)
    {
        try {
            $temperature = new Temperature;
            $temperature->fill($request->validated())->save();
            return new TemperatureResource($temperature);

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
        $temperature = Temperature::findOrfail($id);

        return new TemperatureResource($temperature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TemperatureRequest $request, $id)
    {
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }

        try {
           $temperature = Temperature::find($id);
           $temperature->fill($request->validated())->save();

           return new TemperatureResource($temperature);

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
        $temperature = Temperature::findOrfail($id);
        $temperature->delete();

        return response()->json(null, 204);
    }
}
