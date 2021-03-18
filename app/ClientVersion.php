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
