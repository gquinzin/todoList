<?php

namespace TodoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**@var \Symfony\Bundle\FrameworkBundle\Client client */
    protected $client;

    private function getClient()
    {
        $this->client = static::createClient();
    }

    public function testEmptyList()
    {
        $this -> getClient();
        $this->client->request('GET','/task/list');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('task.empty_list', $this->client->getResponse()->getContent());
    }

    public  function testNewTaskForm()
    {
        $this -> getClient();
        $this->client->request('GET', '/task/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('task.form.save', $this->client->getResponse()->getContent());
    }

    public function testNewTaskSuccess()
    {
        $this -> getClient();

        $crawler = $this->client->request('GET', '/task/create');
        $form = $crawler->filter('button[type=submit]')->form();

        $data = array(
            'task[label]' => 'task 1',
            'task[description]' => 'go to the mall',
            'task[status]' => '1',
        );

        $this->client->submit($form, $data);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Task added with succes', $this->client->getResponse()->getContent());
    }

    public function testNewTaskFail()
    {
        $this -> getClient();

        $crawler = $this->client->request('GET', '/task/create');
        $form = $crawler->filter('button[type=submit]')->form();

        $data = array(
            'task[label]' => 'task 1',
            'task[description]' => 'go to the mall',
            'task[status]' => 'TEST',
        );

        $this->client->submit($form, $data);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('This value is not valid', $this->client->getResponse()->getContent());
    }

    public function testNewTaskServerError()
    {
        $this -> getClient();

        $crawler = $this->client->request('GET', '/task/create');
        $form = $crawler->filter('button[type=submit]')->form();

        $crawler = $this->client->submit($form);
        $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
    }

    public function testNonEmptyList()
    {
        $this->getClient();

        $crawler = $this->client->request('GET','/task/list');

    }

}
