<?php
/**
 * Contains Drupal\site_location_time\Services\SiteLocationTimeService
 */
namespace Drupal\site_location_time\Services;

use Drupal\Plugin\Block;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SiteLocationTimeService.
 */
class SiteLocationTimeService
{
    /**
     * Config Factory Interface.
     *
     * @var \Drupal\Core\Config\ConfigFactory
     */
    protected $configFactory;

    /**
     * Initialize obj "configFactory"
     * 
     * @param $configFactory 
     */
    public function __construct(ConfigFactory $configFactory)
    {
        $this->configFactory = $configFactory;
    }

    /**
     * Load service "config.factory".
     * 
     * @param $container 
     * 
     * @return 'string'
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('config.factory'),
        );
    }


    /**
     * Return Date and Time as selected timezone throught SiteLocationTimeConfigForm
     * 
     * @return 'string'
     */
    public function timezonedetector()
    {
        $config = $this->configFactory->get('site_location_time.settings');
        $timezone = $config->get('site_location_time_timezone');
        date_default_timezone_set($timezone);
        $datetime = date("jS M Y - h:i:s A");
        return $datetime;
    }
}