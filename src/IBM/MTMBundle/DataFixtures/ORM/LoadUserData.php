<?php
namespace IBM\MTMBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use IBM\MTMBundle\Entity\Users;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$user = new Users();
		$user->setEmail('test@gmail.com');
		$user->setUsername('Test');
		$user->setRole('ROLE_ADMIN');
		$encoder = $this->container
			->get('security.encoder_factory')
			->getEncoder($user);
		
		mt_srand(microtime(true)*100000 + memory_get_usage(true));
		$user->setSalt(md5(uniqid(mt_rand(), true)));		
		$user->setPassword($encoder->encodePassword('test123', $user->getSalt()));
		
		$customer = $manager->getRepository('IBMMTMBundle:Customer')->findOneByAccount('111111111111');
		$user->setCustomer($customer);
		
		$manager->persist($user);
		$manager->flush();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 2;
	}
}
