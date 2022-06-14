<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @Command
 */
#[Command]
class ArkGenController extends HyperfCommand
{ /**
 * @var ContainerInterface
 */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('arkGen:controller');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Create a new ark controller');
    }

    public function handle()
    {
        $param = $this->input->getArgument('name');
        if(!empty($param)){
            $argument = explode('/', $param);
            if (count($argument) > 1) {
                $temp = str_replace("/".$argument[count($argument)-1],"",$param);
                $fileNamespace = 'App\\Controller\\'.str_replace("/","\\",$temp);
                $use = 'use App\Controller\BaseController;';
                $class = $argument[count($argument)-1];
            } else {
                $fileNamespace = 'App\Controller';
                $use = '';
                $class = $argument[0];
            }
            $fileName = __DIR__.'/../Controller';
            $fileName = gen_file_name($fileName,$param,$argument);
            $content = file_get_contents(__DIR__.'/Template/Controller.stub');
            $content = str_replace(array("%NAMESPACE%", "%USES%", "%CLASS%"), array($fileNamespace, $use, $class), $content);
            file_put_contents($fileName,$content);
        }
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'Controller class']
        ];
    }
}
