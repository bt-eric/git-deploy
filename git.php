<?php
/**
 * @file
 * Git auto deploy for dev.drupal.breaktech.org.
 */

require 'vendor/autoload.php';

use BtDeploy\BtDeploy;
use BtDeploy\BtGitFactory;
use BtDeploy\BtMailerFactory;

$repos = BtDeploy::parseConfig('repos');

foreach ($repos as $repo => $config) {
    $git_config = array_key_exists('git', $config) ? $config['git'] : [];
    $btGit = BtGitFactory::create($git_config);
    if ($btGit) {
        $output = $btGit->run();
        if (!empty($output) && $output != "Already up-to-date.") {
            $mail_config = array_key_exists('mailer', $config) ? $config['mailer'] : [];
            $mailer = BtMailerFactory::create($mail_config);
            $mailer->mail($output, "$repo on dev.drupal has been updated.");
        }
    }
}
