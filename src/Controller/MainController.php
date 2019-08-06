<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MainController extends Controller
{
    public function get_available_locales( Request $request ): Response
    {
        $locales = $this->get('sylius.repository.locale')->findAll();
        return $this->render('@SyliusShop/Common/available_locales.html.twig', [
            'locales' => $locales
        ] );
    }

    public function get_available_admins( Request $request ): Response
    {
        $admins = $this->get('sylius.repository.admin_user')->findAll();
        $final_admins = array();

        foreach ( $admins as $a )
        {
            if ( !$a->hasRole("ROLE_API_ACCESS") )
            {
                $logo = $this->get('main_service')->getUserLogo( $a->getId(), 'admins' );

                if ( $logo != '' )
                {
                    $a->setLogo( new UploadedFile( $logo, 'logo' ) );
                }

                $final_admins[] = $a;
            }
        }

        return $this->render('@SyliusShop/Common/available_admins.html.twig', [
            'admins' => $final_admins
        ] );
    }

    public function support_channels( Request $request ): Response
    {
        return $this->render('@SyliusShop/General/support_channels.html.twig' );
    }
}
