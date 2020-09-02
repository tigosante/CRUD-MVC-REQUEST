<?php

namespace core\OBJECT_CRUD\QUERYS;

class QueryCrudPaginate
{
    /**
     * @var int $numberPages
     */
    private $numberPages = 15;

    /**
     * @var int $start
     */
    private $start = null;

    /**
     * @var int $end
     */
    private $end = null;

    /**
     * @var int $finalLimit
     */
    private $finalLimit = 2147483645;

    private const AADATA = "aaData";

    public function getNumberPages(): int
    {
        return $this->numberPages;
    }

    public function setNumberPages(int $numberPages): void
    {
        $this->numberPages = $numberPages;
    }

    public function getStart(): int
    {
        if (empty($this->start)) {
            $this->start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        }

        return $this->start;
    }

    public function setStart(int $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): int
    {
        return empty($this->end) ? $this->loadEnd() : $this->end;
    }

    public function setEnd(int $end): void
    {
        $this->end = $end;
    }

    public function getSelectPaginate(string $query): string
    {
        return
            "SELECT * FROM (
                SELECT ROWNUM AS NR_LINHA_PAGINATION,TEMP.* FROM ({$query}) TEMP
            ) WHERE NR_LINHA_PAGINATION BETWEEN :DATA_START_PAGINATION AND :DATA_END_PAGINATION AND ROWNUM <= :QUANTIDADE_PAGINATION";
    }

    private function loadEnd(): int
    {
        $length = intval($_REQUEST['length']);
        $startPage = intval($_REQUEST['inicio']);
        $displayFinal = null;
        $subFinalLimit = $this->finalLimit - $startPage;

        if (isset($length) && $length != '-1') {
            $displayFinal = ($length > $subFinalLimit) ? $this->finalLimit : $startPage + $length;
        } else {
            $displayFinal = $this->finalLimit;
        }

        return $displayFinal;
    }

    public function getbindsWithPagination(array $data = null): array
    {
        return array_merge($data ?? [], array(
            ":DATA_START_PAGINATION" => $this->getStart(),
            ":DATA_END_PAGINATION" => $this->getEnd(),
            ":QUANTIDADE_PAGINATION" => intval($_REQUEST['draw']),
        ));
    }

    public function adjustData(array $data, string $method = null): array
    {
        $total = count($data);

        $output = array(
            "draw" => intval($_REQUEST['draw']),
            self::AADATA => array(),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total
        );

        if ($method !== null) {
            $data = [$data];
        }

        foreach ($data as $line) {
            array_push($output[self::AADATA], $this->getDataArray($line));
        }

        return $output;
    }

    private function getDataArray(array $data): array
    {
        $lineData = [];

        foreach ($data as $key => $value) {
            if ($key != "NR_LINHA_PAGINATION") {
                $lineData[$key] = $value;
            }
        }

        return $lineData;
    }
}
