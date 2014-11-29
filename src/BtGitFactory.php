<?php
/**
 * @file
 * Contains \BtDeploy\BtGitFactory.
 */

namespace BtDeploy;

class BtGitFactory
{
    public static function create($config)
    {
        $data = BtDeploy::fromConfig($config, BtDeploy::parseConfig(['defaults', 'git']), [
            'repositoryPath',
            'branch'
        ]);
        $repositoryPath = $data['repositoryPath'];
        $branch = $data['branch'];

        if (file_exists($repositoryPath)) {
            return new BtGit($repositoryPath, $branch);
        }
        return null;
    }
}
