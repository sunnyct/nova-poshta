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

/**
 * Response
 */
class Response
{
    /**
     * Deserialized data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Warning messages
     *
     * @var array
     */
    protected $warnings = [];

    /**
     * Information messages
     *
     * @var array
     */
    protected $info = [];

    /**
     * Raw deserialized response body
     *
     * @var mixed
     */
    protected $raw;

    /**
     * Response constructor.
     *
     * @param array $data
     * @param array $warnings
     * @param array $info
     * @param mixed $raw
     */
    public function __construct(array $data = [], array $warnings = [], array $info = [], $raw = null)
    {
        $this->data     = $data;
        $this->warnings = $warnings;
        $this->info     = $info;
        $this->raw      = $raw;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get warning messages
     *
     * @return array
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * Get information messages
     *
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Get raw response body
     *
     * @return mixed
     */
    public function getRAW()
    {
        return $this->raw;
    }
}