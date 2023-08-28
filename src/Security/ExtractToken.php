<?php

declare(strict_types=1);

namespace App\Security;

use Kreait\Firebase\Factory;
use Lcobucci\JWT\Token\DataSet;

final readonly class ExtractToken
{
    public function __construct(private Factory $factory, private string $firebaseAuthCredentials)
    {
    }

    public function verifyUserFromToken(string $token): DataSet
    {
        $firebase = $this->factory->withServiceAccount(sprintf('../%s', $this->firebaseAuthCredentials));
        $auth = $firebase->createAuth();

        return $auth->verifyIdToken($token)->claims();
    }
}
