<?php

declare(strict_types=1);

namespace Application\Sonata\NewsBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;
use Sonata\NewsBundle\Permalink\PermalinkInterface;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\Form\Type\DateTimePickerType;
use Sonata\NewsBundle\Form\Type\CommentStatusType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Sonata\MediaBundle\Form\Type\MediaType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;

final class PostAdmin extends AbstractAdmin
{
    /**
     * @var PermalinkInterface
     */
    protected $permalinkGenerator;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var FormatterPool
     */
    protected $formatterPool;

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager($userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param PermalinkInterface $permalinkGenerator
     */
    public function setPermalinkGenerator(PermalinkInterface $permalinkGenerator)
    {
        $this->permalinkGenerator = $permalinkGenerator;
    }

    /**
     * @param FormatterPool $formatterPool
     */
    public function setPoolFormatter(FormatterPool $formatterPool)
    {
        $this->formatterPool = $formatterPool;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
        ->add('custom', 'string', [
            'template' => '@SonataNews/Admin/list_post_custom.html.twig',
            'label' => 'list.label_post',
            'sortable' => 'title',
        ])
        ->add('commentsEnabled', null, ['editable' => true])
        ->add('publicationDateStart')
    ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $isHorizontal = 'horizontal' === $this->getConfigurationPool()->getOption('form_type');
        $formMapper->with('group_post', [
                    'class' => 'col-md-8',
                ])
                // ->add('author', ModelListType::class)
                ->add('title')
                ->add('abstract', TextareaType::class, [
                    'attr' => ['rows' => 5],
                ])
                ->add('content', FormatterType::class, [
                    'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                    'format_field' => 'contentFormatter',
                    'source_field' => 'rawContent',
                    // 'format_field_options' => [
                    //     'choices' => [
                    //         'text' => 'Text',
                    //         'richhtml' => 'RichHTML',
                    //     ],
                    //     'data' => 'richhtml',
                    // ],
                    'source_field_options' => [
                        'horizontal_input_wrapper_class' => $isHorizontal ? 'col-lg-12' : '',
                        'attr' => ['class' => $isHorizontal ? 'span10 col-sm-10 col-md-10 ckeditor' : 'ckeditor', 'rows' => 20],
                    ],
                    'ckeditor_context' => 'news',
                    'target_field' => 'content',
                    'listener' => true,
                ])
            ->end()
            ->with('group_status', [
                    'class' => 'col-md-4',
                ])
                ->add('enabled', CheckboxType::class, ['required' => false])
                ->add('image', ModelListType::class, ['required' => false], [
                    'link_parameters' => [
                        'context' => 'news',
                        'hide_context' => true,
                    ],
                    'label' => 'Article Image',
                ])

                // ->add('image', MediaType::class, array(
                //     'required' => false,
                //     'label' => 'Image',
                //     'provider' => 'sonata.media.provider.image',
                //     'data_class'   =>  'Application\Sonata\MediaBundle\Entity\Media',
                //     'context'  => 'news'
                // ))

                // ->add('gallery', CollectionType::class, array(), array(
                //     'edit' => 'inline',
                //     'inline' => 'table',
                //     'link_parameters' => array(
                //         'context' => 'news',
                //         'provider' => 'sonata.media.provider.image'
                //     )
                // ))

                ->add('publicationDateStart', DateTimePickerType::class, [
                    'dp_side_by_side' => true,
                ])
                ->add('commentsCloseAt', DateTimePickerType::class, [
                    'dp_side_by_side' => true,
                    'required' => false,
                ])
                ->add('commentsEnabled', CheckboxType::class, [
                    'required' => false,
                ])
                ->add('commentsDefaultStatus', CommentStatusType::class, [
                    'expanded' => true,
                ])
            ->end()

            ->with('group_classification', [
                'class' => 'col-md-4',
                ])
                ->add('tags', ModelAutocompleteType::class, [
                    'property' => 'name',
                    'multiple' => 'true',
                    'required' => false,
                ])
                ->add('collection', ModelListType::class, [
                    'required' => false,
                ])
            ->end()
        ;
    }

    protected function saveImageMediaBundle($file,$context = 'default')
    {

        $mediaManager = $this->get('sonata.media.manager.media');
        $media = new Media();
        $media->setContext($context);
        $media->setProviderName('sonata.media.provider.image');
        $media->setBinaryContent($file);
        $mediaManager->save($media);

        return $media;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        // $showMapper
        //     ->add('title')
        //     ->add('abstract')
        //     ->add('content')
        //     ->add('rawContent')
        //     ->add('contentFormatter')
        //     ->add('enabled')
        //     ->add('slug')
        //     ->add('publicationDateStart')
        //     ->add('commentsEnabled')
        //     ->add('commentsCloseAt')
        //     ->add('commentsDefaultStatus')
        //     ->add('commentsCount')
        //     ->add('createdAt')
        //     ->add('updatedAt')
        //     ->add('id')
        //     ;
        $showMapper
        ->add('author')
        ->add('enabled')
        ->add('title')
        ->add('abstract')
        ->add('content', null, ['safe' => true])
        ->add('tags')
    ;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($post)
    {
        $post->setContent($this->formatterPool->transform($post->getContentFormatter(), $post->getRawContent()));
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $post->setAuthor( $user );

        // $file = $post->files->get('newsImage',null);
        // $media = $this->saveImageMediaBundle($file,'news');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($post)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $post->setAuthor( $user );
        $post->setContent($this->formatterPool->transform($post->getContentFormatter(), $post->getRawContent()));
    }

     /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $that = $this;

        $datagridMapper
            ->add('title')
            ->add('enabled')
            ->add('tags', null, ['field_options' => ['expanded' => true, 'multiple' => true]])
            // ->add('author')
            ->add('with_open_comments', CallbackFilter::class, [
//                'callback'   => array($this, 'getWithOpenCommentFilter'),
                'callback' => function ($queryBuilder, $alias, $field, $data) use ($that) {
                    if (!\is_array($data) || !$data['value']) {
                        return;
                    }

                    $queryBuilder->leftJoin(sprintf('%s.comments', $alias), 'c');
                    $queryBuilder->andWhere('c.status = :status');
                    $queryBuilder->setParameter('status', CommentInterface::STATUS_MODERATE);
                },
                'field_type' => CheckboxType::class,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !\in_array($action, ['edit'], true)) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('sidemenu.link_edit_post'),
            ['uri' => $admin->generateUrl('edit', ['id' => $id])]
        );

        $menu->addChild(
            $this->trans('sidemenu.link_view_comments'),
            ['uri' => $admin->generateUrl('sonata.news.admin.comment.list', ['id' => $id])]
        );

        if ($this->hasSubject() && null !== $this->getSubject()->getId()) {
            $menu->addChild(
                'sidemenu.link_view_post',
                ['uri' => $admin->getRouteGenerator()->generate(
                    'sonata_news_view',
                    ['permalink' => $this->permalinkGenerator->generate($this->getSubject())]
                )]
            );
        }
    }
}
