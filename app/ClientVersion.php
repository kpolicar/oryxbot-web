<?php namespace App;


use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
class ClientVersion
{
    public $versions;

    public function __construct()
    {
        $this->versions = new Collection([
            1 => [
                'number' => 1,
                'code' => 'v0.1beta',
                'name' => 'v0.1 Beta',
            ],
            2 => [
                'number' => 2,
                'code' => 'v0.2beta',
                'name' => 'v0.2 Beta',
            ],
            3 => [
                'number' => 3,
                'code' => 'v0.3beta',
                'name' => 'v0.3 Beta',
            ],
            4 => [
                'number' => 4,
                'code' => 'v0.4beta',
                'name' => 'v0.4 Beta',
            ],
            5 => [
                'number' => 5,
                'code' => 'v0.5beta',
                'name' => 'v0.5 Beta',
            ],
            6 => [
                'number' => 6,
                'code' => 'v0.6beta',
                'name' => 'v0.6 Beta',
            ],
            7 => [
                'number' => 7,
                'code' => 'v1',
                'name' => 'v1.0',
            ],
            8 => [
                'number' => 7,
                'code' => 'v2',
                'name' => 'v2.0',
            ],
        ]);
    }

    public function latest()
    {
        return $this->last();
    }

    public function __call($name, $arguments)
    {
        return $this->versions->$name(...$arguments);
    }
}
