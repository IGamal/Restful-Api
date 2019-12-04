<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'Identifier' => (int)$product->id,
            'Title' => (string)$product->name,
            'Details' => (string)$product->description,
            'Stock' => (int)$product->quantity,
            'Situation' => (string)$product->status,
            'Picture' => url("images/{$product->image}"),
            'Seller' => (int)$product->seller_id,
            'Creation Date' => (string)$product->created_at,
            'Last Change' => (string)$product->updated_at,
            'Deleted Date' => isset($product->deleted_at) ? (string)$product->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =
            [
                'Identifier' => 'id',
                'Title' => 'name',
                'Details' => 'description',
                'Stock' => 'quantity',
                'Situation' => 'status',
                'Picture' => 'image',
                'Seller' => 'seller_id',
                'Creation Date' => 'created_at',
                'Last Change' => 'updated_at',
                'Deleted Date' => 'deleted_at',
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
