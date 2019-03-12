<?php
/**
 * SunNY Creative Technologies
 *
 *   #####                                ##     ##    ##      ##
 * ##     ##                              ###    ##    ##      ##
 * ##                                     ####   ##     ##    ##
 * ##           ##     ##    ## #####     ## ##  ##      ##  ##
 *   #####      ##     ##    ###    ##    ##  ## ##       ####
 *        ##    ##     ##    ##     ##    ##   ####        ##
 *        ##    ##     ##    ##     ##    ##    ###        ##
 * ##     ##    ##     ##    ##     ##    ##     ##        ##
 *   #####        #######    ##     ##    ##     ##        ##
 *
 * C  R  E  A  T  I  V  E     T  E  C  H  N  O  L  O  G  I  E  S
 */

namespace SunNYCT\NovaPoshta;

use SunNYCT\NovaPoshta\Exception;
use SunNYCT\CURL\Request;

/**
 * Nova poshta v2 API client
 */
class Client
{
    /**
     * Endpoint base url
     */
    const URL = 'http://testapi.novaposhta.ua/v2.0';

    /**
     * Available formats (now only xml supported)
     *
     * @var array
     */
    protected static $availableFormats = ['json'];

    /**
     * Access key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Body format
     *
     * @var string
     */
    protected $format = 'json';

    /**
     * Client constructor.
     *
     * @param string $apiKey
     * @param string $format
     */
    public function __construct($apiKey, $format = 'json')
    {
        $this->apiKey = $apiKey;
        $this->format = $format;
    }

    /**
     * Execute request
     *
     * @param string $method
     * @param string $path
     * @param array  $params
     *
     * @return Response
     */
    public function execute($method, $path, array $params = [])
    {
        list($class, $method) = explode('::', $method);

        $modelName = substr($class, strrpos($class, '\\') + 1);

        $params = array_replace($params, [
            'apiKey'       => $this->apiKey,
            'modelName'    => $modelName,
            'calledMethod' => $method,
        ]);

        $request = new Request(static::URL . '/' . str_replace('{format}', $this->format, $path));
        $request->setOption(CURLOPT_CUSTOMREQUEST, 'POST');
        $request->setOption(CURLOPT_POSTFIELDS, $this->serialize($params));

        $response = $request->execute();

        list($raw, $success, $data, $errors, $warnings, $info) = $this->deserialize($response->getBody(), null);

        if (!$success) {
            throw new Exception\NovaPoshtaException(count($errors) ? implode("\n", $errors) : 'Request unknown error');
        }

        return new Response($data, $warnings, $info, $raw);
    }

    /**
     * Serialize data for request
     *
     * @param mixed       $data
     * @param null|string $format
     *
     * @return string
     */
    public function serialize($data, $format = null)
    {
        $format = $format ?: $this->format;
        if (!in_array($format, static::$availableFormats)) {
            throw new Exception\InvalidArgumentException('Invalid format');
        }

        $serialized = '';

        switch ($format) {
            case 'json':
                $serialized = json_encode($data, JSON_PRETTY_PRINT);
                break;
        }

        return $serialized;
    }

    /**
     * Deserialize data from response
     *
     * @param string      $data
     * @param null|string $format
     *
     * @return array
     */
    public function deserialize($data, $format = null)
    {
        $format = $format ?: $this->format;
        if (!in_array($format, static::$availableFormats)) {
            throw new Exception\InvalidArgumentException('Invalid format');
        }

        $deserialized = [];

        switch ($format) {
            case 'json':
                $deserialized = json_decode($data);
                break;
        }

        $success  = isset($deserialized->success) && $deserialized->success == 'true';
        $data     = [];
        $errors   = [];
        $warnings = [];
        $info     = [];

        if (is_array($deserialized->data)) {
            foreach ($deserialized->data as $item) {
                $data[] = $item;
            }
        }

        if (is_array($deserialized->errors)) {
            foreach ($deserialized->errors as $item) {
                $errors[] = (string)$item;
            }
        }

        if (is_array($deserialized->warnings)) {
            foreach ($deserialized->warnings as $item) {
                $warnings[] = (string)$item;
            }
        }

        if (is_array($deserialized->info)) {
            foreach ($deserialized->info as $item) {
                $info[] = (string)$item;
            }
        }

        return [$deserialized, $success, $data, $errors, $warnings, $info];
    }
}