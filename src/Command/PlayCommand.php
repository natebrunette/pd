<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Pd\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tebru\Pd\Enum\ResponseEnum;
use Tebru\Pd\Provider\ResponseProvider;

/**
 * Class PlayCommand
 *
 * @author Nate Brunette <n@tebru.net>
 */
class PlayCommand extends Command
{
    const NAME = 'play';

    /**#@+
     * Command Arguments
     */
    const PARTNER_NAME = 'partnerName';
    const PARTNER_DISCIPLINE = 'partnerDiscipline';
    const PARTNER_PREVIOUS_RESPONSE = 'partnerPreviousResponse';
    const PLAYER_PREVIOUS_RESPONSE = 'playerPreviousResponse';
    /**#@-*/

    /**
     * @var ResponseProvider
     */
    private $responseProvider;

    /**
     * Constructor
     *
     * @param ResponseProvider $responseProvider
     * @param string|null $name
     */
    public function __construct(ResponseProvider $responseProvider, $name = null)
    {
        parent::__construct($name);

        $this->responseProvider = $responseProvider;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName(self::NAME);
        $this->addArgument(self::PARTNER_NAME, InputArgument::REQUIRED);
        $this->addArgument(self::PARTNER_DISCIPLINE, InputArgument::REQUIRED);
        $this->addArgument(self::PARTNER_PREVIOUS_RESPONSE, InputArgument::OPTIONAL);
        $this->addArgument(self::PLAYER_PREVIOUS_RESPONSE, InputArgument::OPTIONAL);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $partnerPreviousResponse  = null;
        $playerPreviousResponse  = null;

        if (null !== $input->getArgument(self::PARTNER_PREVIOUS_RESPONSE)) {
            $partnerPreviousResponse = ResponseEnum::create($input->getArgument(self::PARTNER_PREVIOUS_RESPONSE));
        }

        if (null !== $input->getArgument(self::PLAYER_PREVIOUS_RESPONSE)) {
            $playerPreviousResponse = ResponseEnum::create($input->getArgument(self::PLAYER_PREVIOUS_RESPONSE));
        }

        $response = $this->responseProvider->getResponse($partnerPreviousResponse, $playerPreviousResponse);

        $output->writeln((string)$response);
    }
}
