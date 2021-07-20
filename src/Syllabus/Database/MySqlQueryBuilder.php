<?php


namespace Syllabus\Database;


class MySqlQueryBuilder
{
    private array $fields = [];
    private array $from = [];
    private array $where = [];

    public function select(array $fields): MySqlQueryBuilder
    {
        $this->fields = $fields;
        return $this;
    }

    public function from(string $from): MySqlQueryBuilder
    {
        $this->from[] = $from;
        return $this;
    }

    public function where(string $where): MySqlQueryBuilder
    {
        $this->where[] = $where;
        return $this;
    }

    public function __toString(): string
    {
        $selectString = sprintf('SELECT %s FROM %s',
            join(', ', $this->fields),
            join(', ', $this->from),
        );

        if (!empty($this->where)) {
            $whereString = sprintf(' WHERE %s',
                join(' AND', $this->where)
            );
            $selectString .= $whereString;
        }

        return $selectString;
    }
}