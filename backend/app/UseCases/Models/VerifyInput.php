<?php

namespace App\UseCases\Models;

use App\UseCases\Entity;

class VerifyInput extends Entity
{
    /** @var string メールアドレス */
    public string $email;

    /** @var string パスワード */
    public string $password;
}