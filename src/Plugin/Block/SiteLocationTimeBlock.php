<?php

/**
 * Contains Drupal\site_location_time\Plugin\Block\SiteLocationTimeBlock
 */
namespace Drupal\site_location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a 'Site Location Time' Block.
 *
 * @Block(
 *   id = "site_location_time_block",
 *   admin_label = @Translation("Site Location Time Block"),
 *   category = @Translation("Site Location Time"),
 * )
 */
class SiteLocationTimeBlock extends BlockBase 
implements ContainerFactoryPluginInterface
{
    /**
     * Config Factory.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;
    protected $slt;

    /**
     * {@inheritdoc}
     * 
     * @param $configuration 
     * @param $plugin_id 
     * @param $plugin_definition 
     * @param $configFactory 
     * @param $slt 
     */
    public function __construct(array $configuration, $plugin_id, 
        $plugin_definition, $configFactory, $slt
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->configFactory = $configFactory;
        $this->slt = $slt;
    }

    /**
     * {@inheritdoc}
     * 
     * @param $container 
     * @param $configuration 
     * @param $plugin_id 
     * @param $plugin_definition 
     * 
     * @return plugin
     */
    public static function create(ContainerInterface $container, 
        array $configuration, $plugin_id, $plugin_definition
    ) {
        return new static(
            $configuration, $plugin_id, $plugin_definition,
            $container->get('config.factory'),
            $container->get('site_location_time.timezone'),
        );
    }

    /**
     * {@inheritdoc}
     * 
     * @return $build
     */
    public function build()
    {
        $city = $country = $timeontimezone ='';
        $tag = $contexts = [];
        
        $config = $this->configFactory->get('site_location_time.settings');
        
        $city = $config->get('site_location_time_city');
        $country = $config->get('site_location_time_country');
        $timeontimezone = $this->slt
            ->timezonedetector('site_location_time.timezone');

        $build = [
        '#theme' => 'site_location_time_block',
        '#city' => $city,
        '#country' => $country,
        '#timezone' => $timeontimezone,
        ];
        return $build;
    }

    /**
     * {@inheritdoc}
     * 
     * @return null
     */
    public function getCacheMaxAge()
    {
        return 0;
    }

}
