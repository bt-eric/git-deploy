<?php
/**
 * @file
 * Contains \BtDeploy\BtDeploy.
 */

namespace BtDeploy;

use Symfony\Component\Yaml\Yaml;

class BtDeploy
{
    public static function fromConfig(array $config = [], array $defaults = [], array $required = [])
    {
        $data = $config + $defaults;

        if ($missing = array_diff($required, array_keys($data))) {
            throw new \InvalidArgumentException('Config is missing the following keys: ' . implode(', ', $missing));
        }

        return $data;
    }

    public static function parseConfig($keys)
    {
        static $config = null;
        if (!$config) {
            $config = Yaml::parse(__DIR__ . '/../config.yml');
        }

        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $return = $config;
        while ($key = array_shift($keys)) {
            if (array_key_exists($key, $return) && !empty($return[$key])) {
                $return = &$return[$key];
            } else {
                return [];
            }
        }
        return $return;
    }
}
