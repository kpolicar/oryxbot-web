<?php namespace App\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        return false;
    }

    public function view()
    {
        return false;
    }
}
