<?php

namespace Kodewbit\Booklets\Contracts;

use GuzzleHttp\Exception\GuzzleException;

interface InternetArchive
{
    /**
     * Get book thumbnail.
     *
     * @return mixed
     */
    public function thumbnail();

    /**
     * Fetch book details.
     *
     * @param $book
     * @return $this|array
     * @throws GuzzleException
     */
    public function fetchDetails($book);
}
