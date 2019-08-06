<?php

declare(strict_types=1);

namespace Application\Sonata\NewsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class MediaAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('providerName')
            ->add('providerStatus')
            ->add('providerReference')
            ->add('providerMetadata')
            ->add('width')
            ->add('height')
            ->add('length')
            ->add('contentType')
            ->add('size')
            ->add('copyright')
            ->add('authorName')
            ->add('context')
            ->add('cdnIsFlushable')
            ->add('cdnFlushIdentifier')
            ->add('cdnFlushAt')
            ->add('cdnStatus')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('id')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('providerName')
            ->add('providerStatus')
            ->add('providerReference')
            ->add('providerMetadata')
            ->add('width')
            ->add('height')
            ->add('length')
            ->add('contentType')
            ->add('size')
            ->add('copyright')
            ->add('authorName')
            ->add('context')
            ->add('cdnIsFlushable')
            ->add('cdnFlushIdentifier')
            ->add('cdnFlushAt')
            ->add('cdnStatus')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('id')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('providerName')
            ->add('providerStatus')
            ->add('providerReference')
            ->add('providerMetadata')
            ->add('width')
            ->add('height')
            ->add('length')
            ->add('contentType')
            ->add('size')
            ->add('copyright')
            ->add('authorName')
            ->add('context')
            ->add('cdnIsFlushable')
            ->add('cdnFlushIdentifier')
            ->add('cdnFlushAt')
            ->add('cdnStatus')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('id')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('providerName')
            ->add('providerStatus')
            ->add('providerReference')
            ->add('providerMetadata')
            ->add('width')
            ->add('height')
            ->add('length')
            ->add('contentType')
            ->add('size')
            ->add('copyright')
            ->add('authorName')
            ->add('context')
            ->add('cdnIsFlushable')
            ->add('cdnFlushIdentifier')
            ->add('cdnFlushAt')
            ->add('cdnStatus')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('id')
            ;
    }
}
