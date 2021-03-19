<?php

namespace Kodewbit\Booklets\Contracts;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use SimpleXMLElement;

interface LibriVox
{
    /**
     * Search authors.
     *
     * @return $this
     */
    public function authors();

    /**
     * Search audio books.
     *
     * @return $this
     */
    public function audiobooks();

    /**
     * Fields to return.
     *
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields);

    /**
     * Resource where you will search.
     *
     * @param string $format
     * @return $this
     */
    public function format(string $format);

    /**
     * Query offset.
     *
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset);

    /**
     * Query limit.
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit);

    /**
     * Return the full set of data about the project.
     *
     * @param bool $extended
     * @return $this
     */
    public function extended(bool $extended);

    /**
     * Fetch RSS.
     *
     * @param $book
     * @return array|SimpleXMLElement|string
     * @throws GuzzleException
     */
    public function fetchRSS($book);

    /**
     * Fetch data.
     *
     * @return Collection|null
     * @throws GuzzleException
     */
    public function fetchData();
}
