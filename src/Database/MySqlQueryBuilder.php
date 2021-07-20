<?php


namespace Database;


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

    public function from(array $from): MySqlQueryBuilder
    {
        $this->from = $from;
        return $this;
    }

    public function where(array $where): MySqlQueryBuilder
    {
        $this->where = $where;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf("SELECT %s FROM %s WHERE %s",
            join(', ', $this->fields),
            join(', ', $this->from),
            join('AND ', $this->where));
    }
}