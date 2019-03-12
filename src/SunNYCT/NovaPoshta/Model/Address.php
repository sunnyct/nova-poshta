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

namespace SunNYCT\NovaPoshta\Model;

use SunNYCT\NovaPoshta\Client;

/**
 * Address model methods
 */
class Address implements ModelInterface
{
    /**
     * Get cities
     *
     * @param Client $client
     * @param null|string $ref
     * @param null|string $page
     * @param null|string $findByString
     *
     * @return \SunNYCT\NovaPoshta\Response
     */
    public static function getCities(Client $client, $ref = null, $page = null, $findByString = null)
    {
        $params = [];

        if (isset($ref)) {
            $params['Ref'] = $ref;
        }

        if (isset($page)) {
            $params['Page'] = $page;
        }

        if (isset($findByString)) {
            $params['FindByString'] = $findByString;
        }

        return $client->execute(__METHOD__, 'address/getCities/{format}');
    }

    /**
     * Get settlements
     *
     * @param Client      $client
     * @param null|string $areaRef
     * @param null|string $ref
     * @param null|string $mainCitiesOnly
     * @param null|string $hideMainCities
     * @param null|string $regionRef
     * @param null|string $findByString
     *
     * @return \SunNYCT\NovaPoshta\Response
     */
    public static function getSettlements(
        Client $client,
        $areaRef = null,
        $ref = null,
        $mainCitiesOnly = null,
        $hideMainCities = null,
        $regionRef = null,
        $findByString = null
    ) {
        $params = [];

        if (isset($areaRef)) {
            $params['AreaRef'] = $areaRef;
        }

        if (isset($ref)) {
            $params['Ref'] = $ref;
        }

        if (isset($mainCitiesOnly)) {
            $params['MainCitiesOnly'] = $mainCitiesOnly;
        }

        if (isset($hideMainCities)) {
            $params['HideMainCities'] = $hideMainCities;
        }

        if (isset($regionRef)) {
            $params['RegionRef'] = $regionRef;
        }

        if (isset($findByString)) {
            $params['FindByString'] = $findByString;
        }

        return $client->execute(__METHOD__, 'address/getSettlements/{format}', $params);
    }

    /**
     * Get areas
     *
     * @param Client $client
     * @return \SunNYCT\NovaPoshta\Response
     */
    public static function getAreas(Client $client)
    {
        return $client->execute(__METHOD__, 'address/getAreas/{format}');
    }

    /**
     * Get warehouses
     *
     * @param Client $client
     * @param null|string $cityName
     * @param null|string $cityRef
     *
     * @return \SunNYCT\NovaPoshta\Response
     */
    public static function getWarehouses(Client $client, $cityName = null, $cityRef = null)
    {
        $params = [];

        if (isset($cityName)) {
            $params['CityName'] = $cityName;
        }

        if (isset($cityRef)) {
            $params['CityRef'] = $cityRef;
        }

        return $client->execute(__METHOD__, 'address/{format}/getWarehouses', $params);
    }

    /**
     * Get street
     *
     * @param Client $client
     * @param null|string $cityName
     * @param null|string $cityRef
     *
     * @return \SunNYCT\NovaPoshta\Response
     */
    public function getStreet(Client $client, $cityName = null, $cityRef = null)
    {
        $params = [];

        if (isset($cityName)) {
            $params['CityName'] = $cityName;
        }

        if (isset($cityRef)) {
            $params['CityRef'] = $cityRef;
        }

        return $client->execute(__METHOD__, 'address/getStreet/{format}', $params);
    }
}