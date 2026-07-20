<?php

class AuthorizationProfile
{
    public int $AuthenticationId = -1;
    public string $SessionToken = '';
    public array $Roles = [];
    public array $Tasks = [];
}