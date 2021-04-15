<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\CountryModel;
use Validator;
class CountryController extends Controller
{
    /**
     * get all countries
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(CountryModel::all(),200);

    }

    /**
     * get one country
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message" => "Record not found!"],404);
        }
        return response()->json($country,200);
    }

    /**
     * validate and store a new country in storage
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules=[
            'name' => 'required|min:3',
            'iso'  => 'required|min:2|max:2'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
      $country = CountryModel::create($request->all());
      return response()->json($country,201);

    }

    /**
     * update an existing country
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( Request $request ,$id): \Illuminate\Http\JsonResponse
    {
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message" => "Record not found!"],404);
        }
        $country->update($request->all());
        return response()->json($country,200);
    }

    /**
     * delete a country
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request,$id): \Illuminate\Http\JsonResponse
    {
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message" => "Record not found!"],404);
        }
        $country->delete($request->all());
        return response()->json(null,204);
    }

}
