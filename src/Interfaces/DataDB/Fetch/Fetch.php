<?php

namespace src\interfaces\DataDB\Fetch;

interface Fetch
{
  public function fetchAllConfiguration(int $fetch_style = null, int $fetch_argument = null, array $ctor_args = array()): void;
}
