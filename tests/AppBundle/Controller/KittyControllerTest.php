<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KittyControllerTest extends WebTestCase
{
    public function testPerPageParameter()
    {
        $client = static::createClient();
        $client->request('GET', "/api/kitties");
        $headers = $client->getResponse()->headers;
        $this->assertTrue($headers->contains(
            'Content-Type',
            'application/json'
        ));
        $this->assertTrue($client->getResponse()->isSuccessful());

        $responseData = json_decode($client->getResponse()->getContent());
        $this->assertTrue(property_exists($responseData, "meta"));
        $this->assertEquals('2', $responseData->meta->perPage, "Teste le nombre de chats par page par défaut dans les meta");
        $this->assertEquals(2, count($responseData->data));

        $client->request('GET', "/api/kitties", array('perPage'=> 10));
        $headers = $client->getResponse()->headers;
        $this->assertTrue($headers->contains(
            'Content-Type',
            'application/json'
        ));
        $this->assertTrue($client->getResponse()->isSuccessful());

        $responseData = json_decode($client->getResponse()->getContent());
        $this->assertTrue(property_exists($responseData, "meta"));
        $this->assertEquals('10', $responseData->meta->perPage, "Teste si il y a bien 10 chats par page dans les méta");
    }

    public function testAnonymousGetKitties()
    {
        $client = static::createClient();
        $client->request('GET', "/api/kitties");
        $headers = $client->getResponse()->headers;
        $this->assertTrue($headers->contains(
            'Content-Type',
            'application/json'
        ));
        $this->assertTrue($client->getResponse()->isSuccessful());

        $responseData = json_decode($client->getResponse()->getContent());
        $this->assertTrue(property_exists($responseData, "data"));
        foreach ($responseData->data as $kitty) {
            $this->assertTrue(property_exists($kitty, 'id'));
            $this->assertTrue(property_exists($kitty, 'name'));
            $this->assertFalse(property_exists($kitty, 'birthday'));
            $this->assertFalse(property_exists($kitty, 'image'));
            $this->assertFalse(property_exists($kitty, 'race'));
            $this->assertFalse(property_exists($kitty, 'isSterilized'));
            $this->assertFalse(property_exists($kitty, 'specialSign'));
        }
    }
}
