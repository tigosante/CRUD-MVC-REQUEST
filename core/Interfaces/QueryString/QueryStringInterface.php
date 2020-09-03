<?php

namespace core\Interfaces\QueryString;

interface QueryStringInterface
{
  public function insert(): string;
  public function select(): string;
  public function update(): string;
  public function delete(): string;
  public function join(): string;
  public function where(): string;
  public function groupBy(): string;
  public function orderBy(): string;
}
