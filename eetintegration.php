<?php
// Ensure PrestaShop version is defined before executing
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Class EetIntegration
 *
 * This module integrates PrestaShop with the EET API, allowing product synchronization.
 * It provides a configuration form to set API credentials and syncs stock and pricing information.
 */
class EetIntegration extends Module
{
    /**
     * Constructor method for the module.
     * Initializes module properties such as name, version, author, and description.
     */
    public function __construct()
    {
        $this->name = 'eetintegration'; // Module's system name
        $this->tab = 'administration';  // Category in the back office
        $this->version = '1.0.0';       // Module version
        $this->author = 'Robert Mendonça'; // Module author
        $this->need_instance = 0;       // No instance is required
        $this->bootstrap = true;        // Enables Bootstrap styling

        parent::__construct();

        // Module display name and description (translatable)
        $this->displayName = $this->l('EET Integration');
        $this->description = $this->l('Sync products from the EET API to PrestaShop.');
    }

    /**
     * Install method.
     * Registers hooks and creates an admin tab for the module.
     *
     * @return bool Returns true if the installation is successful.
     */
    public function install()
    {
        return parent::install()
            && $this->registerHook('displayAdminProductsExtra') // Hook for extra admin product fields
            && $this->installTab(); // Creates an admin menu entry
    }

    /**
     * Creates an admin menu entry under "Advanced Parameters".
     *
     * @return bool Returns true if the tab is created successfully.
     */
    private function installTab()
    {
        $tab = new Tab();
        $tab->class_name = 'AdminEetIntegration'; // Controller name (must match exactly)
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminAdvancedParameters'); // Parent menu
        $tab->module = $this->name;

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'EET Integration';
        }

        return $tab->add();
    }

    /**
     * Uninstall method.
     * Removes stored configurations and deletes the admin tab.
     *
     * @return bool Returns true if the uninstallation is successful.
     */
    public function uninstall()
    {
        return parent::uninstall()
            && Configuration::deleteByName('EET_API_USERNAME')
            && Configuration::deleteByName('EET_API_PASSWORD')
            && Configuration::deleteByName('EET_API_BRAND_ID');
    }

    /**
     * Generates the module's configuration page in the back office.
     *
     * @return string The rendered HTML form.
     */
    public function getContent()
    {
        // Check if the form was submitted
        if (Tools::isSubmit('submitEETIntegration')) {
            Configuration::updateValue('EET_API_USERNAME', Tools::getValue('EET_API_USERNAME'));
            Configuration::updateValue('EET_API_PASSWORD', Tools::getValue('EET_API_PASSWORD'));
            Configuration::updateValue('EET_API_BRAND_ID', Tools::getValue('EET_API_BRAND_ID'));

            // Display a success message
            return $this->displayConfirmation($this->l('Settings saved successfully!')) . $this->renderForm();
        }

        return $this->renderForm();
    }

    /**
     * Builds the settings form for the module.
     *
     * @return string The generated HTML form.
     */
    private function renderForm()
    {
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->submit_action = 'submitEETIntegration';

        // Load saved configuration values
        $helper->fields_value['EET_API_USERNAME'] = Configuration::get('EET_API_USERNAME');
        $helper->fields_value['EET_API_PASSWORD'] = Configuration::get('EET_API_PASSWORD');
        $helper->fields_value['EET_API_BRAND_ID'] = Configuration::get('EET_API_BRAND_ID');

        return $helper->generateForm([[
            'form' => [
                'legend' => ['title' => $this->l('EET API Settings')],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('API Username'),
                        'name' => 'EET_API_USERNAME',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('API Password'),
                        'name' => 'EET_API_PASSWORD',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Brand ID'),
                        'name' => 'EET_API_BRAND_ID',
                        'required' => true,
                    ],
                ],
                'submit' => ['title' => $this->l('Save')],
            ],
        ]]);
    }

    /**
     * Adds custom CSS and JavaScript to the module's settings page.
     */
    public function hookActionAdminControllerSetMedia()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addCSS($this->_path . 'views/css/admin.css');
            $this->context->controller->addJS($this->_path . 'views/js/admin.js');
        }
    }
}
