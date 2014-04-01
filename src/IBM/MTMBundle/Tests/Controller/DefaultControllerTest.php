<?php

namespace IBM\MTMBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

	protected $adminUserConfig = array('HTTP_HOST' => 'mtmcontest.cat',
	    		'HTTPS' => true,
	    		'PHP_AUTH_USER' => 'Mort',
	    		'PHP_AUTH_PW' => 'f4r0l4d8');
	
    public function testIndex()
    {
    		$client = static::createClient(array(), $this->adminUserConfig);
    		
    		$crawler = $client->request('GET', '/');
    		
    		$this->assertTrue($crawler->filter('html:contains("Backend")')->count() > 0);
    }
    
    public function testLogin()
    {
    	$client = static::createClient(array(), $this->adminUserConfig);
    	
    	$crawler = $client->request('GET', '/');
    	
    	$this->assertTrue($client->getContainer()->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'));
    }
    
    /*
    public function loginTest()
    {
    	$client = static::createClient();
    	
    	$crawler = $client->request('GET', 'https://mtmcontest.cat/login');
    	
    	$this->assertTrue($crawler->filter('#login')->count() > 0);
    	$this->assertTrue($crawler->filter('#username')->count() > 0);
    	$this->assertTrue($crawler->filter('#password')->count() > 0);
    	
    	$form = $crawler->selectButton('loginbut')->form();
    	
    	// set some values
    	$form['_username'] = 'Mort';
    	$form['_password'] = 'f4r0l4d8';
    	
    	// submit the form
    	$crawler = $client->submit($form);
    	
    	exit(var_dump($crawler->html()));
    }*/
}
