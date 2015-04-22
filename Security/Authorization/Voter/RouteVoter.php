<?php

namespace Uneak\AdminBundle\Security\Authorization\Voter;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 *
 *
 * @author marc
 */
class RouteVoter extends AbstractVoter {

	const ROUTE_GRANTED = "ROUTE_GRANTED";

	protected function getSupportedAttributes() {
		return array(self::ROUTE_GRANTED);
	}

	protected function getSupportedClasses() {
		return array('Uneak\AdminBundle\Route\FlattenRoute');
	}


	protected function isGranted($attribute, $flattenRoute, $user = null) {

		if (!$user instanceof UserInterface) {
			return false;
		}

		return $flattenRoute->isGranted($attribute, $user);

	}


}
