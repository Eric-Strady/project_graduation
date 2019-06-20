<?php

namespace App\Listener;

use App\Entity\Contract;
use App\Entity\Post;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class MediaCacheSubscriber implements EventSubscriber
{
	private $cacheManager;
	private $uploaderHelper;

	public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper) {
		$this->cacheManager = $cacheManager;
		$this->uploaderHelper = $uploaderHelper;
	}

	public function getSubscribedEvents() {
		return [
			Events::preUpdate,
			Events::preRemove
		];
	}

	public function preUpdate(PreUpdateEventArgs $event) {
		$entity = $event->getEntity();
		if ($entity instanceof Contract || $entity instanceof Post) {
			if ($entity->getImageFile() instanceof UploadedFile) {
				$this->cacheManager->remove($this->uploaderHelper->asset($entity, 'image_file'));
			}
		}
		else {
			return;
		}
	}

	public function preRemove(LifecycleEventArgs $event) {
		$entity = $event->getEntity();
		if ($entity instanceof Contract || $entity instanceof Post) {
			$this->cacheManager->remove($this->uploaderHelper->asset($entity, 'image_file'));
		}
		else {
			return;
		}
	}
}