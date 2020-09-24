<?php

namespace App\DoctrineListeners;

use App\Entity\Tag;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SlugListener implements  EventSubscriberInterface
{
    /**
     * @var SlugifyInterface
     */
    private $slugify;

    /**
     * SlugListener constructor.
     * @param SlugifyInterface $slugify
     */
    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (! ($entity instanceof Tag)){
            return;
        }

        $slug = $this->slugify->slugify($entity->getName());

        $entity->setSlug($slug);
    }
}