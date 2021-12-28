<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $session;
    private $router;

    public function __construct (SessionInterface $sessionInterface, RouterInterface $routerInterface) {
        $this->session = $sessionInterface;
        $this->router = $routerInterface;
    }

    public function handle (Request $request, AccessDeniedException $exception) {
        //show an error message
        $this->session->getFlashBag()->add('Warning', 'Login with admin account to use these features');

        //redirect to "Login" page
        return new RedirectResponse($this->router->generate('app_login'));
    }
}
?>