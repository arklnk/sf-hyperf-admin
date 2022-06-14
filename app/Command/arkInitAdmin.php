<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\SysAdmin;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @Command
 */
#[Command]
class arkInitAdmin extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var SysAdmin
     */
    protected $sysUser;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('ark:admin');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Init ark admin');
    }

    public function handle()
    {
        $name = $this->input->getArgument('name');
        $password = $this->input->getArgument('password');

        if(empty($name) || strlen($name)<4){
            $this->line('名字至少4个字符!', 'info');die;
        }

        if(empty($password) || strlen($password)<6){
            $this->line('密码至少6个字符!', 'info');die;
        }

        $psalt = md5(uniqid());
        $password = md5($password . $psalt);
        $this->sysUser->updateItem(
            [['id', '=', 1]],
            [
                'id' => 1,
                'username' => $name,
                'password' => $password,
                'psalt' => $psalt
            ]);
        $this->line('管理员初始化完成!', 'info');
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL],
            ['password', InputArgument::OPTIONAL],
        ];
    }
}
