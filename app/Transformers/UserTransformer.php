<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user) 
    {
        return [
            'identifier'   => (int) $user->id,
            'name'         => (string) $user->name,
            'email'        => (string) $user->email,
            'isVerified'   => (int) $user->verified,
            'isAdmin'      => ($user->admin === 'true'),
            'creationDate' => (string) date('d/m/Y H:i', strtotime($user->created_at)),
            'lastChanged'  => (string) date('d/m/Y H:i', strtotime($user->updated_at)),
            'deletedDate'  => isset($user->deleted_at) ? (string) $user->deleted_at : null,

            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('users.show', $user->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index) 
    {
        $attributes = [
            'identifier'   => 'id',
            'name'         => 'name',
            'email'        => 'email',
            'isVerified'   => 'verified',
            'isAdmin'      => 'admin',
            'creationDate' => 'creted_at',
            'lastChanged'  => 'updated_at',
            'deletedDate'  => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) 
    {
        $attributes = [
            'id'         => 'identifier',
            'name'       => 'name',
            'email'      => 'email',
            'verified'   => 'isVerified',
            'admin'      => 'isAdmin',
            'creted_at'  => 'creationDate',
            'updated_at' => 'lastChanged',
            'deleted_at' => 'deletedDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
