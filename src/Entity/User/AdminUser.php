<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Entity
 * @Table(name="sylius_admin_user")
 */
class AdminUser extends BaseAdminUser
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

    /**
     * @var string
     *
     * @Assert\Image(maxSize = "1000k")
     */

     protected $logo;

    /**
     * @var title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */

    private $title;

    /**
     * @param UploadedFile $logo
     */
    public function setLogo(UploadedFile $logo = null)
    {
        $this->logo = $logo;
    }
    /**
     * @return UploadedFile
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return AdminUser
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
}
