<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
// use Sylius\Bundle\ThemeBundle\Repository\InMemoryThemeRepository;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sylius\Bundle\ThemeBundle\Configuration\ThemeConfiguration;
class MainService
{
    /*
     * @var EntityManagerInterface
     */
    public $em;

    /**
     * @var ThemeRepositoryInterface
     */
    private $themeRepository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct( 
                        ContainerInterface $container,
                        EntityManagerInterface $entityManager,
                        ThemeRepositoryInterface $themeRepository,
                        TokenStorageInterface $tokenStorage
                    )
    {
        $this->em = $entityManager;
        $this->themeRepository = $themeRepository;
        $this->tokenStorage = $tokenStorage;
        $this->container = $container;
    }

    public function getCurrentTheme()
    {
        // $this->container->get('sylius.theme.configuration')
    }

    public function setUserLogo( $id, $user_type, $request, $user )
    {
        $logo_dir = '';

        if ( $this->container->getParameter('kernel.environment') == 'dev' )
        {
            $logo_dir = $this->container->get('kernel')->getRootDir() . '/..' . $request->getBasePath() .
                '/public/uploads/media/'.$user_type.'/' . $id . '/';
        }

        $logo = $this->getUserLogo( $id, 'admins' );

        if ( $logo != '' )
            unlink($logo);

        $file = $user->getLogo();

        $extension = $file->guessExtension();
        $extension = strtolower( $extension );
        $extension_permitted = false;

        $allowed_extensions = array('png', 'jpeg', 'jpg');

        if ( in_array( $extension, $allowed_extensions ) ) {

            $random = rand (0,99999999);
            $dir = "uploads/media/".$user_type."/".$id."/";
            $file->move($dir, "logo_".$random.".".$extension);
        }
    }

    public function getUserLogo( $id, $user_type )
    {
        $logo = '';

        $logo_dir = '';

        $logo_dir = $this->container->get('kernel')->getRootDir() . '/..' .'/public/uploads/media/'.$user_type.'/' . $id . '/';

        if ( file_exists($logo_dir) )
        {
            foreach (new \DirectoryIterator($logo_dir) as $fileInfo) 
            {
                if( $fileInfo->isDot() ) continue;

                if ( substr( $fileInfo->getFilename(), 0, 4) == "logo" )
                    $logo = $fileInfo->getFilename();
            }
        }

        if ( $logo == '' )
            return '';

        return $logo_dir.$logo;
    }
}