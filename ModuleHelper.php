<?php

/**
*  @author    sbobrov85<sbobrov85@gmail.com>
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class ModuleHelper
{
    private static $SETTINGS_PREFIX = '';

    /**
     * Set class property for settings prefix
     * @param string $settingsPrefix settings prefix
     * @throws Exception if settingsPrefix is empty
     */
    public static function setSettingsPrefix($settingsPrefix)
    {
        if (empty($settingsPrefix)) {
            throw new Exception('Settings prefix require non empty value!');
        }

        $settingsPrefix = rtrim($settingsPrefix, '_') . '_';
        self::$SETTINGS_PREFIX = Tools::strtoupper($settingsPrefix);
    }

    /**
     * Build module settings key
     * @param string $paramName param name
     * @return string full settings key
     * @throws Exception if settings prefix not set
     */
    public static function buildSettingsKey($paramName)
    {
        if (empty(self::$SETTINGS_PREFIX)) {
            throw new Exception('Requre settings prefix for using method!');
        }

        return self::$SETTINGS_PREFIX . Tools::strtoupper($paramName);
    }

    /**
     * Get config field value by param name
     * @param string $paramName param name
     * @return mixed config value
     * @throws Exception if param name is empty
     */
    public static function getConfigFieldValue($paramName)
    {
        if (empty($paramName)) {
            throw new Exception('Require not empty param name!');
        }

        $settingsKey = self::buildSettingsKey($paramName);

        return Tools::getValue(
            $settingsKey,
            Configuration::get($settingsKey)
        );
    }

    /**
     * Set config field value by param name
     * @param string $paramName param name
     * @param mixed $value value for set, if null then read from request
     * @throws Exception if param name is empty
     */
    public static function setConfigFieldValue($paramName, $value = null)
    {
        if (empty($paramName)) {
            throw new Exception('Require not empty param name!');
        }

        $settingsKey = self::buildSettingsKey($paramName);

        if (!isset($value)) {
            $value = Tools::getValue($settingsKey);
        }

        Configuration::updateValue($settingsKey, $value);
    }
}
