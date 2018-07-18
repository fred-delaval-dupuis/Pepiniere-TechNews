<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 18/07/2018
 * Time: 12:50
 */

namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
    {
        return new Response(
            '<h1>Ooops, Your access have been denied,</h1> <h3>Please contact your administrator.</h3>'
        );
    }

}