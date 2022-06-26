<?php

namespace MichaelNabil230\LaravelQueryConditions\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MichaelNabil230\LaravelQueryConditions\Tests\TestCase;
use MichaelNabil230\LaravelQueryConditions\Support\Condition;
use MichaelNabil230\LaravelQueryConditions\LaravelQueryConditions;
use MichaelNabil230\LaravelQueryConditions\Concerns\HasQueryCondonation;
use MichaelNabil230\LaravelQueryConditions\Interfaces\QueryCondonation as InterfacesQueryCondonation;

class QueryConditionsTest extends TestCase
{
    private function baseConditions()
    {
        return [
            'logicalOperator' => 'all',
            'children' => [
                [
                    'type' => 'query-builder-rule',
                    'query' => [
                        'rule' => 'created_at',
                        'operator' => '>=',
                        'value' => '2022-06-26 00:00:00',
                    ]
                ],
                [
                    'type' => 'query-builder-rule',
                    'query' => [
                        'rule' => 'age',
                        'operator' => '=',
                        'value' => '12'
                    ]
                ]
            ]
        ];
    }

    public function test_where_conditions()
    {
        $conditions = $this->baseConditions();
        
        $query = LaravelQueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where (`created_at` >= ? and `age` = ?)', $query->toSql());
        $this->assertEquals(['2022-06-26 00:00:00', '12'], $query->getBindings());
    }

    public function test_where_condition()
    {
        $conditions = $this->baseConditions();
        unset($conditions['children'][0]);

        $query = LaravelQueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where (`age` = ?)', $query->toSql());
        $this->assertEquals(['12'], $query->getBindings());
    }

    public function test_or_where_conditions()
    {
        $conditions = $this->baseConditions();
        $conditions['logicalOperator'] = 'any';

        $query = LaravelQueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where ((((`created_at` >= ?)) or (`age` = ?)))', $query->toSql());
        $this->assertEquals(['2022-06-26 00:00:00', '12'], $query->getBindings());
    }

    public function test_or_where_condition()
    {
        $conditions = $this->baseConditions();
        unset($conditions['children'][0]);
        $conditions['logicalOperator'] = 'any';

        $query = LaravelQueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where (((`age` = ?)))', $query->toSql());
        $this->assertEquals(['12'], $query->getBindings());
    }
}

class EloquentBuilderTest extends Model implements InterfacesQueryCondonation
{
    use HasQueryCondonation;

    protected $table = 'table';

    public function scopeParseQBRule(Builder $query, Condition $condition, string $method): void
    {
        if ($condition->rule === 'age') {
            $query->{$method}('age', $condition->operator, $condition->value);
        }

        if ($condition->rule === 'created_at') {
            $query->{$method}('created_at', $condition->operator, $condition->value);
        }
    }
}
