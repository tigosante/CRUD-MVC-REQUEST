<?php

namespace core\OBJECT_CRUD\HANDLED_DB;

use core\OBJECT_CRUD\HANDLED_DB\HandledDbData;
use core\OBJECT_CRUD\INTERFACES\HandledDBInterface;

class HandledDB extends HandledDbData implements HandledDBInterface
{
    public function executeQuery(): bool
    {
        return $this->getConnection()
            ->prepare($this->getQuery())
            ->execute($this->getData());
    }

    public function getDataQuery(int $fetchStyle = \PDO::FETCH_ASSOC): array
    {
        $stmt = $this->getConnection()->prepare($this->getQuery());
        $stmt->execute($this->getData());

        return $stmt->fetchAll($fetchStyle);
    }
}
