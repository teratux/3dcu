<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AdminMenuListener
{
    /*
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct( TokenStorageInterface $tokenStorage )
    {
        $this->tokenStorage = $tokenStorage;
    }

    private function isRole( $role_check )
    {
        $r = false;

        $token = $this->tokenStorage->getToken();

        if ( $token )
        {
            foreach ($token->getRoles() as $role)
            {
                if ( $role->getRole() == $role_check  )
                    $r = true;
            }
        }

        return $r;
    }

    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $obj = new \ArrayObject( $menu->getChildren() );
        $it = $obj->getIterator();

        if ( !$this->isRole( "ROLE_SUPER ") )
        {
            $menu->removeChild( 'catalog');
            $menu->removeChild( 'sales');
            $menu->removeChild( 'marketing');
            $menu->removeChild( 'configuration');
            $menu->removeChild( 'customers');
        }

        if ( !$this->isRole( "ROLE_BLOG ") )
        {
            $blog = $menu
            ->addChild('blog')
            ->setLabel('creart3d.menu.blog')
            ;   
            $blog
            ->addChild('blog_post_list', ['route' => 'admin_sonata_news_post_list'])
            ->setLabel('creart3d.blog.post.list')
            ;
        }




    }
}