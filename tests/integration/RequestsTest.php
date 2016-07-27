<?php

use Asvae\ApiTester\Contracts\StorageInterface;
use Asvae\ApiTester\Storages\JsonStorage;
use Illuminate\Filesystem\Filesystem;

class RequestsTest extends TestCase
{
    public function test_requests_have_required_structure()
    {
        $this->stubStorage();
        $this->get('api-tester/requests')->seeJsonStructure([
            'data' => [
                '*' => [
                    'path',
                    'headers' => [],
                    'method',
                    'params',
                    'id',
                ],
            ],
        ]);
    }

    public function test_invalid_request_can_not_be_stored()
    {
        $this->post('api-tester/requests', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->seeStatusCode(422);
    }

    public function test_valid_request_can_be_stored()
    {
        $storage = $this->stubStorage();

        $storage->expects($this->once())->method('put');

        $this->post('api-tester/requests', [
            'path'    => 'some_path/path',
            'method'  => 'GET',
            'headers' => ['some' => 'value'],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->seeStatusCode(201)->seeJsonStructure([
            'data' => [
                'path',
                'headers' => [],
                'method',
                'params',
                'id',
            ],
        ]);
    }

    public function test_request_can_be_deleted()
    {
        $this->stubStorage();

        $this->delete('api-tester/requests/1', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->seeStatusCode(204);
    }

    public function test_request_can_be_updated()
    {
        $storage = $this->stubStorage();
        $storage->expects($this->once())->method('put');

        $this->patch('api-tester/requests/1', [
            'path'    => 'custom/path',
            'method'  => 'POST',
            'headers' => ['some' => 'value'],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->seeStatusCode(200)->seeJson([
            "data" => [
                'path'    => 'custom/path',
                'method'  => 'POST',
                "params"  => null,
                'headers' => ['some' => 'value'],
                "body"    => null,
                "id"      => 1,
            ],
        ]);
    }

    public function test_routes_have_required_structure()
    {
        $this->get('api-tester/routes');

        $this->seeJsonStructure([
            'data' => [
                '*' => ['methods', 'path', 'action'],
            ],
        ]);
    }

    private function stubStorage()
    {
        $storage = $this->getMock(JsonStorage::class, ['put', 'get'],
            [new Filesystem, '', '']);

        $storage->expects($this->once())
            ->method('get')
            ->will($this->returnValue([
                [
                    "path"    => "some/path",
                    "method"  => "GET",
                    "params"  => null,
                    "headers" => [
                        "X-SS" => "sss",
                    ],
                    "body"    => null,
                    "id"      => 1,
                ],
                [
                    "path"    => "some/path",
                    "method"  => "GET",
                    "params"  => null,
                    "headers" => [
                        "X-SS" => "sss",
                    ],
                    "body"    => null,
                    "id"      => 2,
                ],
                [
                    "path"    => "some/path",
                    "method"  => "GET",
                    "params"  => null,
                    "headers" => [
                        "X-SS" => "sss",
                    ],
                    "body"    => null,
                    "id"      => 3,
                ],
            ]));

        app()->instance(StorageInterface::class, $storage);

        return $storage;
    }
}
