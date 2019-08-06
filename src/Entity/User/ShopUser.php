<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\ShopUser as BaseShopUser;
use Sonata\UserBundle\Model\UserInterface;

/**
 * @Entity
 * @Table(name="sylius_shop_user")
 */
class ShopUser extends BaseShopUser
{
    /**
     * Returns the gender list.
     *
     * @return array
     */
    public static function getGenderList()
    {
        return [
            'gender_unknown' =>UserInterface::GENDER_UNKNOWN,
            'gender_female' => UserInterface::GENDER_FEMALE,
            'gender_male' => UserInterface::GENDER_MALE,
        ];
    }

    protected $groups;
}
