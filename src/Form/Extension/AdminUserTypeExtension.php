<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class AdminUserTypeExtension extends UserType
{
    function __construct( string $dataClass = 'App\Entity\User\AdminUser' )
    {
        parent::__construct( $dataClass );
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'sylius.form.user.first_name',
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'sylius.form.user.last_name',
            ])
            ->add('localeCode', LocaleType::class, [
                'label' => 'sylius.ui.locale',
                'placeholder' => null,
            ])
            ->add('logo', FileType::class, array(
                'required' => false,
                'attr' => array(
                    'style' => "display:none;"
                )

                )

            )
            ->add('title', TextType::class, [
                'required' => false,
                'label' => '3dcu.title',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_admin_user';
    }
}
