<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'Identifier' => (int)$transaction->id,
            'Quantity' => (int)$transaction->quantity,
            'Buyer' => (int)$transaction->buyer_id,
            'Product' => (int)$transaction->product_id,
            'Creation Date' => (string)$transaction->created_at,
            'Last Change' => (string)$transaction->updated_at,
            'Deleted Date' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =
            [
                'Identifier' => 'id',
                'Quantity' => 'quantity',
                'Buyer' => 'buyer_id',
                'Product' => 'product_id',
                'Creation Date' => 'created_at',
                'Last Change' => 'updated_at',
                'Deleted Date' => 'deleted_at',
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
