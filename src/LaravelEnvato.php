<?php

namespace InfyOmLabs\LaravelEnvato;

use InfyOmLabs\LaravelEnvato\Managers\AuthManager;
use InfyOmLabs\LaravelEnvato\Managers\ItemsManager;
use InfyOmLabs\LaravelEnvato\Managers\SalesManager;
use InfyOmLabs\LaravelEnvato\Managers\UserManager;

class LaravelEnvato
{
    /**
     * @return AuthManager
     */
    public function auth()
    {
        /** @var AuthManager $authManager */
        $authManager = app(AuthManager::class);
        return $authManager;
    }

    /**
     * @return ItemsManager
     */
    public function items()
    {
        /** @var ItemsManager $itemsManager */
        $itemsManager = app(ItemsManager::class);
        return $itemsManager;
    }

    /**
     * @return SalesManager
     */
    public function sales()
    {
        /** @var SalesManager $salesManager */
        $salesManager = app(SalesManager::class);
        return $salesManager;
    }

    /**
     * @return UserManager
     */
    public function user()
    {
        /** @var UserManager $userManager */
        $userManager = app(UserManager::class);
        return $userManager;
    }
}
