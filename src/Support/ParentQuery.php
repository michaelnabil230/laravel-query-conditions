<?php

namespace MichaelNabil230\QueryConditions\Support;

class ParentQuery
{
    public string $method;

    /** @var Children[] */
    public array $children = [];

    /**
     * @param  string  $method
     * @param  Children[]  $children
     * @return void
     */
    public function __construct(string $method, array $children)
    {
        $this->method = $method;
        $this->children = $this->formatChildren($children);
    }

    public static function create(string $method, array $children): self
    {
        return new self($method, $children);
    }

    private function formatChildren(array $children): array
    {
        return collect($children)
            ->map(function (array $child) {
                $query = Query::create(data_get($child, 'query'));

                return Children::create(data_get($child, 'type'), $query);
            })
            ->toArray();
    }
}
