<?php

require_once __DIR__ . "/../vendor/autoload.php";

$token = new \Symfony\Component\Security\Core\Authentication\Token\NullToken();

$accessDecisionManager = new \Symfony\Component\Security\Core\Authorization\AccessDecisionManager(
    [
        new \Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter(
            new \Symfony\Component\Security\Core\Role\RoleHierarchy([
                "ROLE_MANAGER" => [
                    "ROLE_SUPERVISOR",
                ],
                "ROLE_SUPERVISOR" => [
                    "ROLE_KEY_HOLDER",
                ],
                "ROLE_KEY_HOLDER" => [
                    "ROLE_USER",
                    "ROLE_NOSALE",
                    "ROLE_REFUND",
                    "ROLE_CASHUP",
                ]
            ]),
        ),
    ],
    new \Symfony\Component\Security\Core\Authorization\Strategy\AffirmativeStrategy(true),
);

if (!$accessDecisionManager->decide($token, ["ROLE_USER"])) {
    print "UNAUTHORISED";
    exit;
}

print "AUTHORISED";
