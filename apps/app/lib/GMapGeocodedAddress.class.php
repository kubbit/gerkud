<?php

/**
 * A class to geocode addresses
 * @author Fabrice Bernhard
 */

class GMapGeocodedAddress
{
  protected $raw_address           = null;
  protected $lat                   = null;
  protected $lng                   = null;
  protected $accuracy              = null;
  protected $geocoded_city         = null;
  protected $geocoded_country_code = null;
  protected $geocoded_country      = null;
  protected $geocoded_address      = null;
  protected $geocoded_street       = null;
  protected $geocoded_postal_code  = null;


  /**
   * Constructs a gMapGeocodedAddress object from a given $raw_address String
   *
   * @param string $raw_address
   * @author Fabrice Bernhard
   */
  public function __construct($raw_address)
  {
    $this->raw_address = $raw_address;
  }

  /**
   *
   * @return string $raw_address
   * @author fabriceb
   * @since 2009-06-17
   */
  public function getRawAddress()
  {

    return $this->raw_address;
  }



  /**
   * Geocodes the address using the Google Maps CSV webservice
   *
   * @param GMapClient $gmap_client
   * @return integer $accuracy
   * @author Fabrice Bernhard
   */
  public function geocode($gmap_client)
  {
    $raw_data = $gmap_client->getGeocodingInfo($this->getRawAddress());
    $geocoded_array = explode(',',$raw_data);
    if ($geocoded_array[0]!=200)
    {

      return false;
    }
    $this->lat      = $geocoded_array[2];
    $this->lng      = $geocoded_array[3];
    $this->accuracy = $geocoded_array[1];

    return $this->accuracy;
  }

  /**
   * Geocodes the address using the Google Maps XML webservice, which has more information.
   * Unknown values will be set to NULL.
   * @param GMapClient $gmap_client
   * @return integer $accuracy
   * @author Fabrice Bernhard
   */
  public function geocodeXml($gmap_client)
  {
    $raw_data = $gmap_client->getGeocodingInfo($this->getRawAddress(),'xml');
/*
    $p = xml_parser_create('UTF-8');
    xml_parse_into_struct($p, $raw_data, $vals, $index);
    xml_parser_free($p);
*/
    $xml = new SimpleXMLElement($raw_data);
    $status = $xml->xpath('/GeocodeResponse/status');
    if ($status == false || $status[0] != 'OK')
    {

      return false;
    }

    //$coordinates = $vals[$index['COORDINATES'][0]]['value'];
    //list($this->lng, $this->lat) = explode(',', $coordinates);
    $longitud = $xml->xpath('/GeocodeResponse/result/geometry/location/lng');
    if ($longitud == false)
        return false;
    $this->lng = $longitud[0];
    $latitud = $xml->xpath('/GeocodeResponse/result/geometry/location/lat');
    if ($latitud == false)
        return false;
    $this->lat = $latitud[0];
/*
    $this->accuracy = $vals[$index['ADDRESSDETAILS'][0]]['attributes']['ACCURACY'];

    // We voluntarily silence errors, the values will still be set to NULL if the array indexes are not defined
    @$this->geocoded_address = $xml->xpath('/GeocodeResponse/result/formatted_address')[0];
    @$this->geocoded_street = $vals[$index['THOROUGHFARENAME'][0]]['value'];
    @$this->geocoded_postal_code = $vals[$index['POSTALCODENUMBER'][0]]['value'];
    @$this->geocoded_country = $vals[$index['COUNTRYNAME'][0]]['value'];
    @$this->geocoded_country_code = $vals[$index['COUNTRYNAMECODE'][0]]['value'];

    @$this->geocoded_city = $vals[$index['LOCALITYNAME'][0]]['value'];
    if (empty($this->geocoded_city))
    {
      @$this->geocoded_city = $vals[$index['SUBADMINISTRATIVEAREANAME'][0]]['value'];
    }
    if (empty($this->geocoded_city))
    {
      @$this->geocoded_city = $vals[$index['ADMINISTRATIVEAREANAME'][0]]['value'];
    }
*/
    return $this->accuracy;
  }


  /**
   * Returns the latitude
   * @return float $latitude
   */
  public function getLat()
  {

    return $this->lat;
  }

  /**
   * Returns the longitude
   * @return float $longitude
   */
  public function getLng()
  {

    return $this->lng;
  }

  /**
   * Returns the Geocoding accuracy
   * @return integer $accuracy
   */
  public function getAccuracy()
  {

    return $this->accuracy;
  }

  /**
   * Returns the address normalized by the Google Maps web service
   * @return string $geocoded_address
   */
  public function getGeocodedAddress()
  {

    return $this->geocoded_address;
  }

  /**
   * Returns the city normalized by the Google Maps web service
   * @return string $geocoded_city
   */
  public function getGeocodedCity()
  {

    return $this->geocoded_city;
  }

  /**
   * Returns the country code normalized by the Google Maps web service
   * @return string $geocoded_country_code
   */
  public function getGeocodedCountryCode()
  {

    return $this->geocoded_country_code;
  }

  /**
   * Returns the country normalized by the Google Maps web service
   * @return string $geocoded_country
   */
  public function getGeocodedCountry()
  {

    return $this->geocoded_country;
  }

  /**
   * Returns the postal code normalized by the Google Maps web service
   * @return string $geocoded_postal_code
   */
  public function getGeocodedPostalCode()
  {

    return $this->geocoded_postal_code;
  }

  /**
   * Returns the street name normalized by the Google Maps web service
   * @return string $geocoded_country_code
   */
  public function getGeocodedStreet()
  {

    return $this->geocoded_street;
  }

  /**
   * @param string $raw raw address to set
   */
  public function setRawAddress($raw)
  {
    $this->raw_address = $raw;
  }


  /**
   * @param float $lat latitude to set
   */
  public function setLat($lat)
  {
    $this->lat = $lat;
  }

  /**
   * @param float $lat longitude to set
   */
  public function setLng($lng)
  {
    $this->lng = $lng;
  }

  /**
   * @param float $lat accuracy to set
   */
  public function setAccuracy($accuracy)
  {
    $this->accuracy = $accuracy;
  }

  /**
   * @param string $val geocoded city
   */
  public function setGeocodedCity($val)
  {
    $this->geocoded_city = $val;
  }

  /**
   * @param string $val geocoded country code
   */
  public function setGeocodedCountryCode($val)
  {
    $this->geocoded_country_code = $val;
  }

  /**
   * @param string $val geocoded country code
   */
  public function setGeocodedCountry($val)
  {
    $this->geocoded_country = $val;
  }

  /**
   * @param string $val geocoded address
   */
  public function setGeocodedAddress($val)
  {
    $this->geocoded_address = $val;
  }

  /**
   * @param string $val geocoded street
   */
  public function setGeocodedStreet($val)
  {
    $this->geocoded_street = $val;
  }

  /**
   * @param string $val geocoded postal_code
   */
  public function setGeocodedPostalCode($val)
  {
    $this->geocoded_postal_code = $val;
  }


}
