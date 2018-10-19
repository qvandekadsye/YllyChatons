<?php

namespace Tests\AppBundle\Controller;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KittyControllerTest extends WebTestCase
{
    private function getAPIToken($user, $password)
    {
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->post('login_check', array('json' => array('username' => $user, 'password' => $password)));
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
        $token = $this->getAPIToken('unit', "unit");
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
        $token = $this->getAPIToken('unit', "unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        );
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->delete('kitties/8', array('headers' => $headers));
        $this->assertEquals(204, $response->getStatusCode(), "La réponse doit être 204 no content");
        $guzzle->get('kitties/8', array('headers' => $headers));
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 401
     */
    public function testPostKittyAnon()
    {
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->post('kitties');
    }

    public function testPostKitty()
    {
        $multipartData =  [
            ['name' => 'name', 'contents' => 'testPost'], ['name' => 'birthday[year]', 'contents' => '2018'],
            ['name' => 'birthday[month]', 'contents' => '2'], ['name' => 'birthday[day]', 'contents' => '1'],
            ['name' => 'race', 'contents' =>10], ['name' => 'isSterilized', 'contents' =>true],
            ['name' => 'specialSign', 'contents' =>"Une tache rayé sur la tête"],

        ];

        $token = $this->getAPIToken('unit', "unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json'
        );

        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->post('kitties', array('multipart' => $multipartData,'headers' => $headers));
        $kitty = json_decode($response, true);
        $id = $kitty->id;
        $response  = $guzzle->get('kitties/'.$id, array('headers' => $headers));
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 405
     */
    public function TestPupKittyMethodNotAllowed()
    {
        $token = $this->getAPIToken('unit', "unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json'
        );
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->put('kitties', array('headers' => $headers));
    }


    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 401
     */
    public function testPutKittyAnon()
    {
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->put('kitties/10');
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionCode 404
     */
    public function testPutKittyNotFound()
    {
        $token = $this->getAPIToken('unit', "unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        );
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->put('kitties/0', array('headers' => $headers));
    }

    public function testPutKitty()
    {
        $formparamdata = array(
                'name' => 'testRéussi',
                'birthday' => array('year' => 2018, 'month' => 12, 'day' => 25),
                'race' => 61,
                'isSterilized' => true,
                'specialSign' => "dispose d'une clochette bleue"
            );

        $token = $this->getAPIToken('unit', "unit");
        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json'
        );
        $guzzle = new GuzzleClient(array('base_uri' => 'http://ylly.local/app_test.php/api/'));
        $response = $guzzle->put('kitties/20', array('form_params' => $formparamdata,'headers' => $headers));
        $response  = $guzzle->get('kitties/20', array('headers' => $headers));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
