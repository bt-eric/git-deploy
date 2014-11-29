<?php
/**
 * @file
 * BtMailer factory class.
 */

namespace BtDeploy;

class BtMailerFactory
{
    public static function create($config = [])
    {
        return new BtMailer($config);
    }
}
