<?php
/**
 * Contains Drupal\site_location_time\Form\SiteLocationTimeConfigForm
 */
namespace Drupal\site_location_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Implement class SiteLocationTimeConfigForm 
 * extending ConfigFormBase
 *
 * @see \Drupal\Core\Form\ConfigFormBase
 */
class SiteLocationTimeConfigForm extends ConfigFormBase
{
    /**
     * Config Factory.
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
     * Load service "config.factory"
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
     * {@inheritdoc}
     * 
     * @return 'string'
     */
    public function getFormId()
    {
        return 'site_location_time_settings';
    }

    /** 
     * {@inheritdoc}
     * 
     * @return 'string'
     */
    protected function getEditableConfigNames()
    {
        return [
        'site_location_time.settings',
        ];
    }
    /** 
     * {@inheritdoc}
     * 
     * @param $form 
     * @param $form_state 
     * 
     * @return 'array'
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // using service config.factory
        $config = $this->configFactory->get('site_location_time.settings');
        $settings = $config->get();
        $country = '';
        $city = '';
        $timezone = '';

        if (isset($settings['site_location_time_country']) 
            && trim($settings['site_location_time_country']) != ''
        ) {
            $country = $settings['site_location_time_country'];
        }

        if (isset($settings['site_location_time_city']) 
            && trim($settings['site_location_time_city']) != ''
        ) {
            $city = $settings['site_location_time_city'];
        }

        if (isset($settings['site_location_timezone']) 
            && trim($settings['site_location_time_zone']) != ''
        ) {
            $timezone = $settings['site_location_zone'];
        }

        $form['site_location_time_country'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Country'),
        '#required' => true,
        '#description' => $this->t('Entry the Country Name'),
        '#default_value' => $config->get('site_location_time_country'),
        ];
        $form['site_location_time_city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#required' => true,
        '#description' => $this->t('Entry the City Name'),
        '#default_value' => $config->get('site_location_time_city'),
        ];
        $form['site_location_time_timezone'] = [
        '#type' => 'select',
        '#title' => $this->t('Timezone'),
        '#description' => 'Please select timezone from dropdown',
        '#required' => true,
        '#options' => [
            'America' => [
                'America/Chicago' => $this->t('Chicago'),
                'America/New_York' => $this->t('New York'),
            ],
            'Asia' => [
                'Asia/Tokyo' => $this->t('Tokyo'),
                'Asia/Dubai' => $this->t('Dubai'),
                'Asia/Kolkata' => $this->t('Kolkata'),
            ],
            'Europe' => [
                'Europe/Amstedam' => $this->t('Amstedam'),
                'Europe/Oslo' => $this->t('Oslo'),
                'Europe/London' => $this->t('London'),
            ],
        ],
        '#default_value' => $config->get('site_location_time_timezone'),
        ];

        return parent::buildForm($form, $form_state);
    }

    /** 
     * {@inheritdoc}
     * 
     * @param $form 
     * @param $form_state 
     * 
     * @return 'null'
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $values = $form_state->getValues();

        // using service config.factory
        $config = $this->configFactory->getEditable('site_location_time.settings');
        $config
            ->set(
                'site_location_time_country', ($values['site_location_time_country'])
            )
            ->set(
                'site_location_time_city', ($values['site_location_time_city'])
            )
            ->set(
                'site_location_time_timezone', 
                ($values['site_location_time_timezone'])
            )
            ->save();

        parent::submitForm($form, $form_state);
    }
}
