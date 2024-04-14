<?php namespace App;


use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
class InfrastructureVersion
{
    public $versions;

    public function __construct()
    {
        $this->versions = new Collection([
            1 => [
                'name' => 'v1.0',
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
