<?php
/**
 * @file
 * Contains \BtDeploy\BtGit.
 */

namespace BtDeploy;

use SebastianBergmann\Git\Git;

class BtGit
{
    protected $repositoryPath;
    protected $branch;
    protected $git;

    public function __construct($repositoryPath, $branch)
    {
        $this->repositoryPath = $repositoryPath;
        $this->branch = $branch;
        $this->git = new Git($repositoryPath);
    }

    public function run()
    {
        $output = '';
        $branch = $this->git->getCurrentBranch();
        if ($this->branch == $branch) {
            $pre_sha = $this->getLatestSha();
            $output .= $this->git->pull($branch);
            $post_sha = $this->getLatestSha();
            if ($pre_sha != $post_sha) {
                $output .= PHP_EOL . $this->git->getDiff($pre_sha, $post_sha);

            }
        }
        return $output;
    }

    private function getLatestSha()
    {
        $revisions = $this->git->getRevisions(true, false, 1);
        $latest = reset($revisions);
        return $latest['sha1'];
    }
}
