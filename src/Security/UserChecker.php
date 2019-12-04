<?php
namespace App\Security;
use App\Entity\User as AppUser;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    }
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
        // user account is expired, the user may be notified
        if (!$user->getIsActive()) {

            throw new AccountExpiredException('ce membre n\'est pas actif.');
        //  throw new \Exception("ce membre n'est pas actif");

           // throw new HttpException(403, 'ce membre n\'est pas actif.');

           //$content = (throw new HttpException(403, 'ce membre n\'est pas actif.'))->getMessage();
           // return new Response($content, 403);




        }
      
       
    }
}