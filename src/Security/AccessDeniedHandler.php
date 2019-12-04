<?php
/**
 * Created by PhpStorm.
 * User: Mourad
 * Date: 26/09/2019
 * Time: 21:28
 */

namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        // ...
        $content = $accessDeniedException->getMessage();
        return new Response($content, 403);
    }
}