<?php


namespace Domain\Auth\Contract;


interface RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password);

}
