<?php

namespace App\Services;

interface ApiRepositoryInterface
{
    public function execute($action, $data);
    public function loginExecute($action, $data);
    public function appAuth($userName, $password,$mrchtIp);
    public function getAllMerchants($data);
}
