<?php

namespace Core\RestBundle\ParamConverter;

use Core\RestBundle\Model\ResourceInterface;
use Core\RestBundle\Service\ResourceManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class ResourceConverter extends DoctrineParamConverter implements ParamConverterInterface
{
    /**
     * @var ResourceManagerInterface
     */
    protected $rm;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct(
        ResourceManagerInterface $rm,
        SerializerInterface $serializer,
        ManagerRegistry $registry = null
    )
    {
        $this->rm = $rm;
        $this->serializer = $serializer;
        parent::__construct($registry);
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     * @return bool True if the object has been successfully set, else false
     * @throws NotFoundHttpException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $fullClass = $this->rm->getFullClass($configuration->getClass());
        $name = $configuration->getName();
        $resourceData = json_encode($request->request->all());

        try{
            parent::apply($request, $configuration);

            $this->deserializeResource($request, $fullClass, $resourceData, $name);

            return true;
        }
        catch(\LogicException $e)
        {
            return $this->treatDoctrineException($request, $fullClass, $resourceData, $name);
        }
        catch(NotFoundHttpException $e)
        {
            return $this->treatDoctrineException($request, $fullClass, $resourceData, $name);
        }
    }

    /**
     * Traite les cas d'exceptions du parent (DoctrineParamConverter)
     * Permet de créer un nouvel objet en cas de POST, sinon relance une exception
     *
     * @param Request $request
     * @param $fullClass
     * @param $resourceData
     * @param $name
     * @return bool
     */
    protected function treatDoctrineException(Request $request, $fullClass, $resourceData, $name)
    {
        //On veut seulement créer un nouvel objet si on est en POST
        if($request->getMethod() !== Request::METHOD_POST)
            throw new NotFoundHttpException();

        $resource = new $fullClass();
        $request->attributes->set($name, $resource);
        return $this->deserializeResource($request, $fullClass, $resourceData, $name);
    }

    /**
     * On deserialise le contenu de la requête dans la ressource
     *
     * @param Request $request
     * @param $fullClass
     * @param $resourceData
     * @param $name
     * @return bool
     */
    protected function deserializeResource(Request $request, $fullClass, $resourceData, $name)
    {
        $resource = $request->get($name);
        $context = new DeserializationContext();

        $context->attributes->set('target', $resource);
        $resource = $this->serializer->deserialize($resourceData, $fullClass, 'json', $context);

        $request->attributes->set($name, $resource);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        //return true;

        return parent::supports($configuration);
    }
}