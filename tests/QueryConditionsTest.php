<?php

namespace MichaelNabil230\QueryConditions\Tests;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MichaelNabil230\QueryConditions\Concerns\HasQueryCondonation;
use MichaelNabil230\QueryConditions\Interfaces\QueryCondonation as InterfacesQueryCondonation;
use MichaelNabil230\QueryConditions\QueryConditions;
use MichaelNabil230\QueryConditions\Support\Condition;

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
                    ],
                ],
                [
                    'type' => 'query-builder-rule',
                    'query' => [
                        'rule' => 'age',
                        'operator' => '=',
                        'value' => '12',
                    ],
                ],
            ],
        ];
    }

    public function test_where_conditions()
    {
        $conditions = $this->baseConditions();

        $query = QueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where (`created_at` >= ? and `age` = ?)', $query->toSql());
        $this->assertEquals(['2022-06-26 00:00:00', '12'], $query->getBindings());
    }

    public function test_where_condition()
    {
        $conditions = $this->baseConditions();
        unset($conditions['children'][0]);

        $query = QueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where (`age` = ?)', $query->toSql());
        $this->assertEquals(['12'], $query->getBindings());
    }

    public function test_or_where_conditions()
    {
        $conditions = $this->baseConditions();
        $conditions['logicalOperator'] = 'any';

        $query = QueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where ((((`created_at` >= ?)) or (`age` = ?)))', $query->toSql());
        $this->assertEquals(['2022-06-26 00:00:00', '12'], $query->getBindings());
    }

    public function test_or_where_condition()
    {
        $conditions = $this->baseConditions();
        unset($conditions['children'][0]);
        $conditions['logicalOperator'] = 'any';

        $query = QueryConditions::for(EloquentBuilderTest::class, $conditions);

        $this->assertSame('select * from `table` where (((`age` = ?)))', $query->toSql());
        $this->assertEquals(['12'], $query->getBindings());
    }
}

class EloquentBuilderTest extends Model implements InterfacesQueryCondonation
{
    use HasQueryCondonation;

    protected $table = 'table';

    public function parseQBRule(Builder $query, Condition $condition, string $method): void
    {
        if ($condition->rule === 'age') {
            $query->{$method}('age', $condition->operator, $condition->value);
        }

        if ($condition->rule === 'created_at') {
            $query->{$method}('created_at', $condition->operator, $condition->value);
        }
    }
}
