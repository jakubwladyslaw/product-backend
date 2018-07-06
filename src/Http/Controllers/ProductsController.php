<?php

namespace Jakub\ProductBackend\Http\Controllers;

use App\Http\Requests;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jakub\ProductBackend\Models\Item;
use Jakub\ProductBackend\Http\Resources\Item as ItemResource;
class ProductsController extends Controller
{
    const VALIDATION_ERROR_CODE = 1;
    const UNRECOGNIZED_ERROR_CODE = 2;

    protected $symbols = [
        'equal' => '=',
        'greaterThen' => '>',
        'greaterThenOrEqual' => '>=',
        'lessThen' => '<',
        'lessThenOrEqual' => '<='
    ];

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function productsGet(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'integer',
            'conditional' => [
                function ($attribute, $value, $fail) {
                    if (!isset($this->symbols[$value])) {
                        return $fail('Wrong conditional');
                    }
                }
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorMessage' => 'Request validation problem.',
                'errorCode' => self::VALIDATION_ERROR_CODE,
                'errors' => $validator->messages()
            ], 400);
        }


        try {
            $conditional = $request->get('conditional', null);

            if ($conditional === null) {
                $items = Item::all();
            } else {
                $amount = (int)$request->get('amount', 0);

                $symbol = $this->symbols[$conditional];

                $items = Item::where('amount', $symbol, $amount)->get();
            }
        } catch (\Exception $e) {

            \Log::error($e->getMessage());
            return response()->json([
                'errorMessage' => 'Somethings wents wrong.',
                'errorCode' => self::UNRECOGNIZED_ERROR_CODE
            ], 500);
        }
        return ItemResource::collection($items);
    }


}