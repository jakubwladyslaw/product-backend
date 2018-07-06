<?php

namespace Jakub\ProductBackend\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Item extends Resource
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->amount
        ];
    }
}
