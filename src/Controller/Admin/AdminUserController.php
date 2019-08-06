<?php


declare(strict_types=1);

namespace App\Controller\Admin;

use Sylius\Bundle\UserBundle\Controller\UserController as BaseType;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sylius\Bundle\UserBundle\Form\Model\ChangePassword;
use Sylius\Bundle\UserBundle\Form\Model\PasswordReset;
use Sylius\Bundle\UserBundle\Form\Model\PasswordResetRequest;
use Sylius\Bundle\UserBundle\Form\Type\UserChangePasswordType;
use Sylius\Bundle\UserBundle\Form\Type\UserRequestPasswordResetType;
use Sylius\Bundle\UserBundle\Form\Type\UserResetPasswordType;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Webmozart\Assert\Assert;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminUserController extends BaseType
{
    public function updateAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        $resource = $this->findOr404($configuration);

        $form = $this->resourceFormFactory->create($configuration, $resource);

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true) && $form->handleRequest($request)->isValid()) 
        {
            $resource = $form->getData();
            $logo = $resource->getLogo();

            if ( $resource->getLogo() )
            {
                $this->get('main_service')->setUserLogo( $resource->getId(), 'admins', $request, $resource );
            }

        }
        else
        {
            $logo = $this->get('main_service')->getUserLogo( $resource->getId(), 'admins' );

            if ( $logo != '' )
            {
                $resource->setLogo( new UploadedFile( $logo, 'logo' ) );
                $form = $this->resourceFormFactory->create($configuration, $resource);
            }
        }

        return parent::updateAction( $request );
    }
}
