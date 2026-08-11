<?php

namespace ReportKit\Laravel\Source;

use ReportKit\Core\Contracts\RowSource;
use ReportKit\Core\Date\DateRangeChunker;

/**
 * RowSource backed by an Illuminate DB connection + query callback.
 *
 * Callback signature: function ($query, array $filters) { return $query->...; }
 * The callback should return a query builder (or array of rows).
 */
class ConnectionRowSource implements RowSource
{
    /** @var string */
    private $connection;

    /** @var callable */
    private $callback;

    /** @var DateRangeChunker */
    private $chunker;

    /** @var string|null */
    private $label;

    /**
     * @param string $connection
     * @param callable $callback
     * @param DateRangeChunker|null $chunker
     * @param string|null $label
     */
    public function __construct($connection, $callback, $chunker = null, $label = null)
    {
        $this->connection = (string) $connection;
        $this->callback = $callback;
        $this->chunker = $chunker instanceof DateRangeChunker ? $chunker : new DateRangeChunker();
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label !== null ? $this->label : $this->connection;
    }

    /**
     * @param array $filters
     * @return array
     */
    public function getWeeks(array $filters)
    {
        $start = isset($filters['start_date']) ? $filters['start_date'] : null;
        $end = isset($filters['end_date']) ? $filters['end_date'] : null;

        if (!$start || !$end) {
            return [];
        }

        return $this->chunker->getWeeklyRanges($start, $end);
    }

    /**
     * @param array $filters
     * @return array
     */
    public function getRows(array $filters)
    {
        if (!function_exists('app')) {
            return [];
        }

        $db = app('db')->connection($this->connection);
        $query = $db->query();
        $result = call_user_func($this->callback, $query, $filters);

        if (is_array($result)) {
            return $result;
        }

        if (is_object($result) && method_exists($result, 'get')) {
            return array_map(function ($row) {
                return (array) $row;
            }, $result->get());
        }

        return [];
    }

    /**
     * @param array $rows
     * @return array
     */
    public function getSummary(array $rows)
    {
        return [
            'total_rows' => count($rows),
            'source' => $this->getLabel(),
        ];
    }
}
