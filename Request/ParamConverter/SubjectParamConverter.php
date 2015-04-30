<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Uneak\AdminBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Uneak\AdminBundle\Admin\AdminChain;

/**
 * DoctrineParamConverter.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SubjectParamConverter implements ParamConverterInterface {

    private $adminChain;

    public function __construct(AdminChain $adminChain) {
        $this->adminChain = $adminChain;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException       When unable to guess how to get a Doctrine instance from the request information
     * @throws NotFoundHttpException When object not found
     */
    public function apply(Request $request, ParamConverter $configuration) {

        $name = $configuration->getName();
        $class = $configuration->getClass();

//        $pathInfo = $request->getPathInfo();
//        $re = "/\\/([\\d\\w-]+)\\/([\\d\\w-]+)/";
//        preg_match_all($re, $pathInfo, $matches);
//        foreach ($matches as $match) {            
//        }
//        $slug = $matches[1];
//        $value = $matches[2];
//        ldd($matches);

        if (null === $request->attributes->get($name, false)) {
            $configuration->setIsOptional(true);
        }

        $admin = $this->adminChain->getAdminBySlug($configuration->getName());


        if ($request->attributes->has($name)) {
            $object = $admin->getRepository()->find($request->attributes->get($name));
            if (null === $object) {
                throw new NotFoundHttpException(sprintf('%s object not found.', $class));
            }
            $admin->setSubject($object);
        }

        $request->attributes->set($name, $admin);

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration) {

        if (null === $this->adminChain || !count($this->adminChain->getAdmins())) {
            return false;
        }

        if ($configuration->getClass() === null || $configuration->getClass() != "Uneak\AdminBundle\Admin\Admin" ) {
            return false;
        }

        return ($this->adminChain->getAdminBySlug($configuration->getName()));
    }

}
