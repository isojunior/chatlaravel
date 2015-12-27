<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $primaryKey = ['ID_USER','ID_UNIVERSITY','ID_FACULTY','EMAIL'];

    protected $table = 'MERCURY_USER';

    protected $fillable = ['EMAIL', 'PASSWORD'];

    protected $hidden = array('PASSWORD');

    public function getAuthPassword() {
        return $this->PASSWORD;
    }

    public function getAuthIdentifier() {
        return $this->getKey();
    }
}
