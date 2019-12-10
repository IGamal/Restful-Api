<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'Identifier' => (int)$category->id,
            'Title' =>(string)$category->name,
            'Details' =>(string)$category->description,
            'Creation Date' => (string)$category->created_at,
            'Last Change' => (string)$category->updated_at,
            'Deleted Date' => isset($category->deleted_at) ? (string)$category->deleted_at : null,
            'Links' => [
                [
                    'rel' => 'Self',
                    'href' =>  route('categories.show', $category->id),
                ],
                [
                    'rel' => 'Category.Buyers',
                    'href' =>  route('categories.buyers.index', $category->id),
                ],
                [
                    'rel' => 'Category.Products',
                    'href' =>  route('categories.products.index', $category->id),
                ],
                [
                    'rel' => 'Category.Sellers',
                    'href' =>  route('categories.sellers.index', $category->id),
                ],
                [
                    'rel' => 'Category.Transactions',
                    'href' =>  route('categories.transactions.index', $category->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =
            [
                'Identifier' => 'id',
                'Title' => 'name',
                'Details' => 'description',
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
                'created_at' => 'Creation Date' ,
                'updated_at' => 'Last Change' ,
                'deleted_at' => 'Deleted Date' ,
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
