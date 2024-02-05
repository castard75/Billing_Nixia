<?php
namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class SecurityController
{
    public function someAction(Security $security): Response
    {

        dump('logout');
        // logout the user in on the current firewall
        $response = $security->logout();
        $response = new RedirectResponse(
            $this->urlGenerator->generate('login'),
            RedirectResponse::HTTP_SEE_OTHER
        );
        // you can also disable the csrf logout
        $response = $security->logout(false);

        // ... return $response (if set) or e.g. redirect to the homepage
    }
}