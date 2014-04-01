<?php
namespace IBM\MTMBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use IBM\MTMBundle\Entity\Customer;
use IBM\MTMBundle\Entity\Balance;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCustomerData extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		for($c = 0; $c<10; ++$c) {
			srand($c*23);
			$customer = new Customer();
			$customer->setAccount(str_repeat((string)$c,12));
			$customer->setCity('New York');
			$customer->setFirstName('Test');
			$customer->setLastName('Test');
			$customer->setStatus('A');
			$customer->setState('New York');
			$customer->setAddress('1234 Madison Avenue');
	
			$manager->persist($customer);
			
			$balance = new Balance();
			$balance->setAccount($customer->getAccount());
			$balance->setBalance((string)rand(1,150000));
			$balance->setCustomer($customer);
			$customer->setBalance($balance);
			$manager->persist($balance);
			$manager->flush();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 1;
	}
}