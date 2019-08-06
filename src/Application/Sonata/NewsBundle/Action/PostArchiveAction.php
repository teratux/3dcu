<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\NewsBundle\Action\AbstractPostArchiveAction;

class PostArchiveAction extends AbstractPostArchiveAction
{
    /**
     * @return Response
     */
    public function __invoke(Request $request)
    {
        if ($seoPage = $this->getSeoPage()) {
            $seoPage
                ->addTitle($this->trans('archive.meta_title', [
                    '%title%' => $this->getBlog()->getTitle(),
                ]))
                ->addMeta('property', 'og:title', $this->trans('archive.meta_title', [
                    '%title%' => $this->getBlog()->getTitle(),
                ]))
                ->addMeta('name', 'description', $this->trans('archive.meta_description', [
                    '%title%' => $this->getBlog()->getTitle(),
                    '%description%' => $this->getBlog()->getDescription(),
                ]))
                ->addMeta('property', 'og:description', $this->trans('archive.meta_description', [
                    '%title%' => $this->getBlog()->getTitle(),
                    '%description%' => $this->getBlog()->getDescription(),
                ]));
        }

        return $this->renderArchiveExtended($request);
    }

    /**
     * @internal
     *
     * NEXT_MAJOR: make this method protected
     *
     * @return Response
     */
    public function renderArchiveExtended(Request $request, array $criteria = [], array $parameters = [])
    {
        $pager = $this->getPostManager()->getPager(
            $criteria,
            $request->get('page', 1)
        );

        $parameters = array_merge([
            'pager' => $pager,
            'blog' => $this->getBlog(),
            'tag' => false,
            'collection' => false,
            'route' => $request->get('_route'),
            'route_parameters' => $request->get('_route_params'),
        ], $parameters);

        $response = $this->render(
            sprintf('@ApplicationSonataNews/Post/archive.%s.twig', $request->getRequestFormat()),
            $parameters
        );

        if ('rss' === $request->getRequestFormat()) {
            $response->headers->set('Content-Type', 'application/rss+xml');
        }

        return $response;
    }
}
