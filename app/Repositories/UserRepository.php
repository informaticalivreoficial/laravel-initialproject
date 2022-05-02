<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    public function getUsersAll()
    {
        return $this->entity
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('status', 'ASC')
                    ->where('client', '1')
                    ->paginate(25);
    }

    public function getUser(int $id)
    {
        return $this->entity->where('id', $id)->first();
    }

    public function getUsersTeam()
    {
        return $this->entity
                    ->where('admin', true)
                    ->orWhere('editor', true)
                    ->paginate(12);
    }

    public function userSetStatus($data)
    {        
        $user = $this->entity->find($data['id']);
        $user->status = $data['status'];
        $user->save();        
    }
}