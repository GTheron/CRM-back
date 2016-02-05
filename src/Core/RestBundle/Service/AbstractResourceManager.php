<?php

namespace Core\RestBundle\Service;

use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Event\ResourceEvent;
use Core\RestBundle\Exception\ValidationException;
use Core\RestBundle\Model\ResourceInterface;
use Core\RestBundle\Model\RichResourceInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\Exception\ValidationFailedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
abstract class AbstractResourceManager implements ResourceManagerInterface
{
    /**
     * Renvoie un manager
     *
     * @return ObjectManager
     */
    abstract public function getManager();

    /**
     * @return EventDispatcherInterface
     */
    abstract protected function getEventDispatcher();

    /**
     * @return ValidatorInterface
     */
    abstract protected function getValidator();

    /**
     * {@inheritdoc}
     */
    public function create(ResourceInterface $resource, $flush = true)
    {
        $this->fireEvent(CoreRestEvents::RESOURCE_WILL_CREATE, $resource);

        $this->manageResource($resource, CoreRestEvents::RESOURCE_CREATED, $flush);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ResourceInterface $resource, $flush = true)
    {
        $this->fireEvent(CoreRestEvents::RESOURCE_WILL_UPDATE, $resource);

        $this->manageResource($resource, CoreRestEvents::RESOURCE_UPDATED, $flush);
    }

    /**
     * @param ResourceInterface $resource
     * @param $eventName
     * @param bool|true $flush
     * @return mixed
     */
    protected function manageResource(ResourceInterface $resource, $eventName, $flush = true)
    {
        //Si la ressource n'est pas valide, validate() soulèvera une exception
        $resource = $this->validate($resource);
        $resource = $this->save($resource, $flush);

        $this->fireEvent($eventName, $resource);

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ResourceInterface $resource, $flush = true)
    {
        $this->fireEvent(CoreRestEvents::RESOURCE_WILL_DELETE, $resource);

        if($resource instanceof RichResourceInterface)
        {
            $resource->setDeleted(true);
            $resource->setDeletedAt(new \DateTime());
            $this->persist($resource, $flush);
        }
        else{
            $this->getManager()->remove($resource);
            if($flush)
                $this->getManager()->flush();
        }

        $this->fireEvent(CoreRestEvents::RESOURCE_DELETED, $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ResourceInterface $resource)
    {
        $this->fireEvent(CoreRestEvents::BEFORE_RESOURCE_VALIDATION, $resource);

        $errors = $this->getValidator()->validate($resource);
        if(count($errors) > 0)
            throw new ValidationException($errors);

        $this->fireEvent(CoreRestEvents::RESOURCE_VALIDATION_SUCCESS, $resource);

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ResourceInterface $resource, $flush = true)
    {
        if($resource instanceof RichResourceInterface)
            $resource->updateTimestamps();

        $resource = $this->persist($resource, $flush);

        $this->fireEvent(CoreRestEvents::RESOURCE_SAVED, $resource);

        return $resource;
    }

    /**
     * @param ResourceInterface $resource
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(ResourceInterface $resource)
    {
        $className=$this->getShortClass($resource->getEntityName());

        return $this->getManager()->getRepository($className);
    }

    /**
     * Par exemple, pour Acme\DemoBundle\Entity\Post ou AcmeDemoBundle\Entity\Post,
     * le retour sera: AcmeDemoBundle:Post
     *
     * @param $class
     * @return string
     */
    public function getShortClass($class)
    {
        $aClass = explode("\\", $class);
        $shortClass = "";

        foreach($aClass as $index => $classFragment)
        {
            if($index == count($aClass) - 1)//Dernier élément
                $shortClass .= ":";
            if($classFragment != "Entity")//On ignorera Entity
                $shortClass .= $classFragment;
        }

        return $shortClass;
    }

    /**
     * Par exemple, pour AcmeDemoBundle:Post,
     * le retour sera: Acme\DemoBundle\Entity\Post
     *
     * @param $shortClass
     * @return string
     */
    public function getFullClass($shortClass)
    {
        $aClass = explode(':', $shortClass);
        $aaNamespace = array();
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $aClass[0], $aaNamespace);
        $aNamespace = $aaNamespace[0];

        $fullClass = "";
        foreach($aNamespace as $index => $namespace)
        {
            $fullClass .= $namespace;
            $trail = true;

            //On suppose que Bundle dans le namespace sera toujours collé au mot précédent
            if($index < count($aNamespace) - 1)
                if($aNamespace[$index + 1] == "Bundle")
                    $trail = false;

            if($trail)
                $fullClass .= "\\";
        }

        //On suppose que ça sera toujours dans Entity par convention
        $fullClass .= "Entity\\".$aClass[1];

        return $fullClass;
    }

    /**
     * Retourne le nom d'une resource.
     * Par exemple, pour Core\RestBundle\Entity\Resource,
     * retourne Resource
     *
     * @param $class
     * @return mixed
     */
    public function getResourceName($class)
    {
        $aClass = explode("\\", $class);
        return $aClass[count($aClass) - 1];
    }

    /**
     * Lance un événement pour une ressource.
     * Si la resource possède un nom d'événement "spécifique", lance aussi cet événement.
     *
     * @param $eventName
     * @param ResourceInterface $resource
     */
    public function fireEvent($eventName, ResourceInterface $resource)
    {
        $event = new ResourceEvent($resource);
        $this->getEventDispatcher()->dispatch($eventName, $event);

        $resourceEvents = $resource->getEvents();
        if (array_key_exists($eventName, $resourceEvents))
            $this->getEventDispatcher()->dispatch($resourceEvents[$eventName], $event);
    }

    /**
     * Sauvegarde l'état d'une ressource en base
     *
     * @param ResourceInterface $resource
     * @param bool $flush
     * @return mixed
     */
    protected function persist(ResourceInterface $resource, $flush = true)
    {
        $this->getManager()->persist($resource);
        if($flush)
            $this->getManager()->flush();

        return $resource;
    }
}