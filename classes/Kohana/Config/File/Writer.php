<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * File writer for the config system
 *
 * @package    config-writer
 * @category   Configuration
 * @author     Niels Oostindiër
 * @license    MIT
 */
class Kohana_Config_File_Writer extends Kohana_Config_File_Reader implements Kohana_Config_Writer
{
    public function write($group, $key, $config)
    {
        $group_config = Kohana::$config->load($group);

        $config_array = $this->_apply_config($group_config, $key, $config);

        $this->_write_group($group, $this->_serialize_object($config_array));
    }

    private function _apply_config($group_config, $key, $config)
    {
        $config_array = $group_config->as_array();
        $config_array[$key] = $config;
        return $config_array;
    }

    private function _write_group($group, $data)
    {
        $file = APPPATH . $this->_directory . DIRECTORY_SEPARATOR . $group . EXT;
        if ( ! is_writable($file)) {
            throw new Exception('Could not write to config file, please make sure it\'s writable ('.$file.')');
        }

        file_put_contents($file, $data);
    }

    private function _serialize_object($object)
    {
        if ($object instanceof Config_Group) {
            $object = $object->as_array();
        }
        return "<?php defined('SYSPATH') OR die('No direct script access.');\nreturn " . var_export($object, TRUE) . ";";
    }
}