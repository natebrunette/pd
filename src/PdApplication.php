<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Pd;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Tebru\Pd\Command\PlayCommand;
use Tebru\Pd\Provider\ResponseProvider;

/**
 * Class PdApplication
 *
 * @author Nate Brunette <n@tebru.net>
 */
class PdApplication extends Application
{
    /**
     * @inheritDoc
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();

        // remove command name from arguments
        $inputDefinition->setArguments();

        return $inputDefinition;
    }

    /**
     * @inheritDoc
     */
    protected function getCommandName(InputInterface $input)
    {
        return PlayCommand::NAME;
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new PlayCommand(new ResponseProvider());

        return $defaultCommands;
    }

}
