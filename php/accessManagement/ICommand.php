<?php


interface ICommand
{
    public function Undo(): void;

    public function Execute(): mixed;

    public function CanExecute(AuthorizationProfile $profile): bool;
}