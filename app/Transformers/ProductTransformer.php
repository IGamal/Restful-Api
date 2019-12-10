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
            'Links' => [
                [
                    'rel' => 'Self',
                    'href' =>  route('products.show', $product->id),
                ],
                [
                    'rel' => 'Product.Buyers',
                    'href' =>  route('products.buyers.index', $product->id),
                ],
                [
                    'rel' => 'Product.Categories',
                    'href' =>  route('products.categories.index', $product->id),
                ],
                [
                    'rel' => 'Seller',
                    'href' =>  route('sellers.show', $product->seller_id),
                ],
                [
                    'rel' => 'Product.Transactions',
                    'href' =>  route('products.transactions.index', $product->id),
                ],
            ],
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

    public static function transformedAttribute($index)
    {
        $attributes =
            [
                'id' => 'Identifier',
                'name' => 'Title' ,
                'description' => 'Details' ,
                'quantity' =>  'Stock',
                'status' => 'Situation',
                'image'  => 'Picture',
                'seller_id'  => 'Seller',
                'created_at' => 'Creation Date' ,
                'updated_at' => 'Last Change' ,
                'deleted_at' => 'Deleted Date' ,
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
