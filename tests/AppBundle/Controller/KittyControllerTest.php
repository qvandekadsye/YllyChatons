<?php

namespace Tests\AppBundle\Controller;

use GuzzleHttp\Client as GuzzleClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KittyControllerTest extends WebTestCase
{

    private function getAPIToken($user, $password)
    {
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->post('login_check',array('json' => array('username' => $user, 'password' => $password)));
        return json_decode($response->getBody()->getContents())->token;
    }


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

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 401
     */
    public function testDeleteKittyAnon()
    {
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->delete('kitties/0');
    }


    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 404
     */
    public function testDeleteKittyNotFound()
    {

        $token = $this->getAPIToken('unit',"unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        );
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->delete('kitties/0', array('headers' => $headers));


    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 404
     */
    public function testDeleteKitty()
    {
        $token = $this->getAPIToken('unit',"unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        );
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->delete('kitties/3',array('headers' => $headers));
        $this->assertEquals(204,$response->getStatusCode(),"La réponse doit être 204 no content");
        $guzzle->get('kitties/3',array('headers' => $headers));
    }


}
