<?php


namespace Syllabus\Database;


class MySqlQueryBuilder
{
    private array $fields = [];
    private array $from = [];
    private array $innerJoin = [];
    private array $insert = [];
    private array $where = [];
    private int $limit;

    public function select(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function from(string $from): self
    {
        $this->from[] = $from;
        return $this;
    }

    public function innerJoin(string $table, string $field1, string $operator, string $field2): self
    {
        $this->innerJoin[] = "INNER JOIN $table On $field1 $operator $field2";
        return $this;
    }

    public function where(string $where): self
    {
        $this->where[] = $where;
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function __toString(): string
    {
        $selectString = sprintf(
            'SELECT %s FROM %s',
            join(', ', $this->fields),
            join(', ', $this->from),
        );

        if (!empty($this->innerJoin)) {
            $innerJoinString = $this->innerJoin;
            $selectString .= $innerJoinString;
        }

        if (!empty($this->where)) {
            $whereString = sprintf(' WHERE %s', join(' AND', $this->where));
            $selectString .= $whereString;
        }

        if(!empty($this->limit)){
            $selectString .= sprintf(' LIMIT %d' , $this->limit);
        }

        return $selectString;
    }
}