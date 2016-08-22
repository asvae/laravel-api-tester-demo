<?php

use Asvae\ApiTester\Contracts\StorageInterface;
use Asvae\ApiTester\Storages\JsonStorage;
use Illuminate\Filesystem\Filesystem;
use Mockery as m;

class RequestsTest extends TestCase
{
    public function test_invalid_request_can_not_be_stored()
    {
        $this->post('api-tester/requests', [])->seeStatusCode(422);
    }

    public function test_valid_request_can_be_stored()
    {
        $request = $this->getSomeRequest();

        $this->post('api-tester/requests', $request)
            ->seeStatusCode(201)
            ->seeJsonStructure($request);

        $this->delete('api-tester/requests/' . $request['id'])
            ->seeStatusCode(204);
    }

    public function test_request_can_be_updated()
    {
        $storage = $this->stubStorage();
        $storage->expects($this->once())->method('put');

        $r = $this->patch('api-tester/requests/sdfsdfswerwer3wer2we2rsdfs', [
            'path'    => 'custom/path',
            'method'  => 'POST',
            'headers' => ['some' => 'value'],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->seeStatusCode(200)->seeJsonStructure([
            'data' => [
                'path',
                'headers' => [],
                'method',
                'id',
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
                    "id"      => 'sdfsdfswerwer3wer2we2rsdfs',
                ],
                [
                    "path"    => "some/path",
                    "method"  => "GET",
                    "params"  => null,
                    "headers" => [
                        "X-SS" => "sss",
                    ],
                    "body"    => null,
                    "id"      => 'sdfsdfs12354werwer3wer2w',
                ],
                [
                    "path"    => "some/path",
                    "method"  => "GET",
                    "params"  => null,
                    "headers" => [
                        "X-SS" => "sss",
                    ],
                    "body"    => null,
                    "id"      => 'sdfsdfs12354werwer38we7r2',
                ],
            ]));

        app()->instance(StorageInterface::class, $storage);

        return $storage;
    }

    private function getSomeRequest()
    {
        $faker = Faker\Factory::create();

        return [
            "path"    => $faker->url,
            "method"  => $faker->randomElement(['GET', 'get', 'post',]),
            "params"  => null,
            "headers" => ["X-SS" => $faker->numerify('#####'),],
            "body"    => ['id' => $faker->randomNumber(5)],
            "id"      => $faker->md5,
        ];
    }
}
