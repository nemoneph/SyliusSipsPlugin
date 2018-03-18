<?php

namespace Nemoneph\SipsPlugin\Action\Api;

use Nemoneph\SipsPlugin\Api\Api;
use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\UnsupportedApiException;

/**
 * Class BaseApiAction
 */
abstract class BaseApiAction extends GatewayAwareAction implements ApiAwareInterface
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof Api) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->api = $api;
    }
}