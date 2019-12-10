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
            'Links' => [
                [
                    'rel' => 'Self',
                    'href' =>  route('users.show', $user->id),
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
                'Admin' => 'admin',
                'Password' => 'password',
                'password_confirmation' => 'password_confirmation',
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
                'admin' => 'Admin',
                'password' => 'Password',
                'password_confirmation' => 'password_confirmation',
                'created_at' => 'Creation Date' ,
                'updated_at' => 'Last Change' ,
                'deleted_at' => 'Deleted Date' ,
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
