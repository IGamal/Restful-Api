<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'Identifier' => (int)$seller->id,
            'Name' => (string)$seller->name,
            'Email' => (string)$seller->email,
            'Verified' => (int)$seller->verified,
            'Creation Date' => (string)$seller->created_at,
            'Last Change' => (string)$seller->updated_at,
            'Deleted Date' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null,
            'Links' => [
                [
                    'rel' => 'Self',
                    'href' =>  route('sellers.show', $seller->id),
                ],
                [
                    'rel' => 'Seller.Buyers',
                    'href' =>  route('sellers.buyers.index', $seller->id),
                ],
                [
                    'rel' => 'Seller.Categories',
                    'href' =>  route('sellers.categories.index', $seller->id),
                ],
                [
                    'rel' => 'Seller.Products',
                    'href' =>  route('sellers.products.index', $seller->id),
                ],
                [
                    'rel' => 'Seller.Transactions',
                    'href' =>  route('sellers.transactions.index', $seller->id),
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
