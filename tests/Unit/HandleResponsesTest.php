<?php
/**
 * Created by PhpStorm.
 * User: dtulp
 * Date: 13-2-2018
 * Time: 16:16.
 */

namespace Tests\Unit;

use Swis\JsonApi\Server\Traits\HandleResponses;
use Tests\TestCase;
use Tests\TestClasses\TestModel;

class HandleResponsesTest extends TestCase
{
    /** @var HandleResponses $mock */
    private $mock;

    protected function setUp()
    {
        $this->mock = $this->getMockForTrait(HandleResponses::class);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /** @test */
    public function test_respond_with_forbidden()
    {
        $response = $this->mock->respondWithForbidden('FORBIDDEN');

        $this->assertEquals('FORBIDDEN', json_decode($response->getContent())->errors[0]->detail);
        $this->assertEquals(403, $response->getStatusCode());
    }

    /** @test */
    public function test_respond_with_bad_request()
    {
        $response = $this->mock->respondWithBadRequest('BAD REQUEST');

        $this->assertEquals('BAD REQUEST', json_decode($response->getContent())->errors[0]->detail);
        $this->assertEquals(400, $response->getStatusCode());
    }

    /** @test */
    public function test_respond_with_not_found()
    {
        $response = $this->mock->respondWithNotFound('NOT FOUND');

        $this->assertEquals('NOT FOUND', json_decode($response->getContent())->errors[0]->detail);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    public function test_respond_with_collection_model()
    {
        $model = new TestModel();
        $model->body = 'TEST';
        $response = $this->mock->respondWithCollection($model);
        $responseBody = json_decode($response->getContent())->data;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('TEST', $responseBody->attributes->body);
    }
}
