<?php

namespace Jakub\ProductBackend\Http\Controllers;

use App\Http\Requests;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jakub\ProductBackend\Models\Item;
use Jakub\ProductBackend\Http\Resources\Item as ItemResource;

class ProductController extends Controller
{
    const VALIDATION_ERROR_CODE = 1;
    const UNRECOGNIZED_ERROR_CODE = 2;
    const DOESNT_EXIST_ERROR_CODE = 3;

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|ItemResource
     */
    public function productGet(Request $request, $id)
    {
        $validator = $validator = Validator::make(['id' => $id], [
            'id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorMessage' => 'Product id must be integer.',
                'errorCode' => self::VALIDATION_ERROR_CODE,
            ], 400);
        }

        try {
            $item = Item::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'errorMessage' => 'Product doesn\'t exists.',
                'errorCode' => self::DOESNT_EXIST_ERROR_CODE
            ], 404);
        }
        return new ItemResource($item);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function productDelete(Request $request, $id)
    {
        $validator = $validator = Validator::make(['id' => $id], [
            'id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorMessage' => 'Product id must be integer.',
                'errorCode' => self::VALIDATION_ERROR_CODE,
            ], 400);
        }

        try {
            $item = Item::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'errorMessage' => 'Product doesn\'t exists.',
                'errorCode' => self::DOESNT_EXIST_ERROR_CODE
            ], 404);
        }

        $item->delete();
        return response()->json(true);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|ItemResource
     */
    public function productAdd(Request $request)
    {
        $validator = $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'amount' => 'required|integer|min:0|'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorMessage' => 'Validation problem.',
                'errorCode' => self::VALIDATION_ERROR_CODE,
                'errors' => $validator->messages()
            ], 400);
        }

        try {
            $item = Item::create($validator->getData());
            return new ItemResource($item);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errorMessage' => 'Somethings wents wrong.',
                'errorCode' => self::UNRECOGNIZED_ERROR_CODE
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|ItemResource
     */
    public function productEdit(Request $request, $id)
    {

        try {
            $item = Item::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'errorMessage' => 'Product doesnt exists.',
                'errorCode' => self::DOESNT_EXIST_ERROR_CODE
            ], 404);
        }

        $validator = $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'amount' => 'integer|min:0|'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorMessage' => 'Validation problem.',
                'errorCode' => self::VALIDATION_ERROR_CODE,
                'errors' => $validator->messages()
            ], 400);
        }

        try {
            $item->fill($validator->getData());
            $item->save();
            return new ItemResource($item);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errorMessage' => 'Somethings went\'s wrong.',
                'errorCode' => self::UNRECOGNIZED_ERROR_CODE
            ], 500);
        }
    }

}