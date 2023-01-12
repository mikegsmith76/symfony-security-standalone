<?php

require_once __DIR__ . "/../vendor/autoload.php";

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
$tokenStorage = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage();

$authenticatorManager = new \Symfony\Component\Security\Http\Authentication\AuthenticatorManager(
    [],
    $tokenStorage,
    $eventDispatcher,
    "main",
);

if ($authenticatorManager->supports($request)) {
    $response = $authenticatorManager->authenticateRequest($request);

    if (null !== $response) {
        $response->send();
        return;
    }
}

$token = $tokenStorage->getToken();

if (null === $token) {
    $token = new \Symfony\Component\Security\Core\Authentication\Token\NullToken();
}
