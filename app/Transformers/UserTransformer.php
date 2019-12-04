<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return
        [
            'Identifier' => (int)$user->id,
            'Name' => (string)$user->name,
            'Email' => (String)$user->email,
            'Verified' => (int)$user->verified,
            'Admin' => ($user->admin === 'true'),
            'Creation Date' => (string)$user->created_at,
            'Last Change' => (string)$user->updated_at,
            'Deleted Date' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
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
                'Admin' => 'admin',
                'Creation Date' => 'created_at',
                'Last Change' => 'updated_at',
                'Deleted Date' => 'deleted_at',
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
