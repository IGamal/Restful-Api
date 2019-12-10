<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'Identifier' => (int)$buyer->id,
            'Name' => (string)$buyer->name,
            'Email' => (String)$buyer->email,
            'Verified' => (int)$buyer->verified,
            'Creation Date' => (string)$buyer->created_at,
            'Last Change' => (string)$buyer->updated_at,
            'Deleted Date' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
            'Links' => [
                [
                    'rel' => 'Self',
                    'href' =>  route('buyers.show', $buyer->id),
                ],
                [
                    'rel' => 'Buyer.Categories',
                    'href' =>  route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel' => 'Buyer.Products',
                    'href' =>  route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel' => 'Buyer.Sellers',
                    'href' =>  route('buyers.sellers.index', $buyer->id),
                ],
                [
                    'rel' => 'Buyer.Transactions',
                    'href' =>  route('buyers.transactions.index', $buyer->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =
            [
                'Identifier' => 'id',
                'Name' => 'name',
                'Email' => 'email',
                'Verified' => 'verified',
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
                'name' => 'Name',
                'email' => 'Email',
                'verified' => 'Verified',
                'created_at' => 'Creation Date' ,
                'updated_at' => 'Last Change' ,
                'deleted_at' => 'Deleted Date' ,
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
