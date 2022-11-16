<?php


namespace Domain\Auth\Contract;


use Domain\Auth\DataTransferObjects\NewUserDTO;

interface RegisterNewUserContract
{
    //Метод __invoke() позволяет определить логику работы объекта, при попытке обратиться к нему как к обычной функции.
    // Этот метод может использоваться для передачи класса, который может действовать как замыкание, или просто как функция.
    //Метод __invoke - это способ, которым PHP может поддерживать функции псевдо-первого класса.
    public function __invoke(NewUserDTO $data);

}
