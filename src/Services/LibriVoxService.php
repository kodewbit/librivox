<?php

namespace Kodewbit\Booklets\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Kodewbit\Booklets\Contracts\LibriVox;
use Kodewbit\Booklets\Traits\Helpers;
use SimpleXMLElement;

class LibriVoxService implements LibriVox
{
    use Helpers;

    /**
     * Resource where you will search.
     *
     * @var string
     */
    protected static $resource = null;

    /**
     * Fields to return.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Resource where you will search.
     *
     * @var string
     */
    protected $format = 'json';

    /**
     * Query offset.
     *
     * @var int
     */
    protected $offset = 0;

    /**
     * Query limit.
     *
     * @var int
     */
    protected $limit = 0;

    /**
     * Return the full set of data.
     *
     * @var bool
     */
    protected $extended = false;

    /**
     * @inheritdoc
     *
     * @return $this
     */
    public function authors()
    {
        self::$resource = 'authors';

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return $this
     */
    public function audiobooks()
    {
        self::$resource = 'audiobooks';

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param string $format
     * @return $this
     */
    public function format(string $format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param int $offset
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param bool $extended
     * @return $this
     */
    public function extended(bool $extended)
    {
        $this->extended = $extended;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param $book
     * @return array|SimpleXMLElement|string|null
     * @throws GuzzleException
     */
    public function fetchRSS($book)
    {
        $client = new Client();

        try {
            $request = $client->get($book->url_rss);

            // Replace some text strings to avoid problems when converting the XML
            $response = str_replace('itunes:', '', $request->getBody()->getContents());

            return simplexml_load_string($response, null, LIBXML_NOCDATA);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @inheritdoc
     *
     * @param array $excludeKeys
     * @return Collection|null
     * @throws GuzzleException
     */
    public function fetchData(array $excludeKeys)
    {
        $client = new Client();

        try {
            $request = $client->get('https://librivox.org/api/feed/' . self::$resource, [
                'query' => http_build_query(get_object_vars($this))
            ]);

            // Decode the JSON returned by the server and convert it to an associative array
            $response = json_decode($request->getBody()->getContents(), true);

            // Keys that will be removed from the response returned by the server
            $excludeKeys = array_merge($excludeKeys, ['id', 'reader_id']);
        } catch (Exception $exception) {
            return null;
        }

        return collect($this->recursiveUnset($response, $excludeKeys))->collapse();
    }
}
