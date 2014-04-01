<?php

namespace IBM\MTMBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerServiceTest extends WebTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	protected $adminUserConfig = array('HTTP_HOST' => 'mtmcontest.cat',
			'HTTPS' => true,
			'PHP_AUTH_USER' => 'Mort',
			'PHP_AUTH_PW' => 'f4r0l4d8');
	
	/**
	 * {@inheritDoc}
	 */
	public function setUp()
	{
		static::$kernel = static::createKernel();
		static::$kernel->boot();
		$this->em = static::$kernel->getContainer()
			->get('doctrine')
			->getManager();
		
		$this->client = $this->createClient();
	}

	/**
	 * Unit test: Toggle customer status
	 */
    public function testSetCustomerStatus()
    {
    	$client = static::createClient(array(), $this->adminUserConfig);
    	     	 
    	$customer = $this->em->getRepository('IBMMTMBundle:Customer')
    		->createQueryBuilder('c')->setMaxResults(1)
    		->getQuery()->getResult();
    	
    	$customer = array_shift($customer);
    	$account = $customer->getAccount();
    	$curStatus = $customer->getStatus();
    	$crawler = $client->request('GET', '/customer/'.$account.'/setstatus' );    	
    	$this->em->refresh($customer);

    	$this->assertTrue($curStatus != $customer->getStatus());
    }
    
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
    	parent::tearDown();
    	$this->em->close();
    }
}
