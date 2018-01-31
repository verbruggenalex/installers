<?php

namespace Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{

    public function activate(Composer $composer, IOInterface $io)
    {
        $destination = isset($GLOBALS['argv']['--no-dev']) ? 'dist' : 'build';
        $baseDir = dirname($composer->getConfig()->get('vendor-dir'));
        $branch = trim(str_replace('* ', '', exec("git branch | grep '\*'")));

        $vendorDir = $baseDir . DIRECTORY_SEPARATOR . $destination . DIRECTORY_SEPARATOR . $branch . DIRECTORY_SEPARATOR .$
        $composer->getConfig()->merge(['config' => ['vendor-dir' => $vendorDir]]);

        $installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
