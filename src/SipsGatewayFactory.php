<?php

namespace Nemoneph\SipsPlugin;


use Nemoneph\SipsPlugin\Action\Api\CallRequestAction;
use Nemoneph\SipsPlugin\Action\Api\CallResponseAction;
use Nemoneph\SipsPlugin\Action\CaptureAction;
use Nemoneph\SipsPlugin\Action\ConvertPaymentAction;
use Nemoneph\SipsPlugin\Action\StatusAction;
use Nemoneph\SipsPlugin\Action\SyncAction;
use Nemoneph\SipsPlugin\Client\Client;
use Nemoneph\SipsPlugin\Api\Api;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

final class SipsGatewayFactory extends GatewayFactory
{

    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {



        $template = false != $config['payum.template.capture']
            ? $config['payum.template.capture']
            : '@PayumSips/Action/capture.html.twig';

        $apiConfig = false != $config['payum.api_config']
            ? (array) $config['payum.api_config']
            : array();


        $config->defaults([
            'payum.factory_name' => 'atos_sips',
            'payum.factory_title' => 'Atos Sips',

            'payum.action.capture'         => new CaptureAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),
            'payum.action.call_request'    => new CallRequestAction($template),
            'payum.action.call_response'   => new CallResponseAction(),
            'payum.action.sync'            => new SyncAction(),
            'payum.action.status'          => new StatusAction(),
        ]);


        if (false == $config['payum.client']) {
            $defaultOptions['client'] = array(
                'merchant_id'      => null,
                'merchant_country' => 'fr',
                'pathfile'         => null,
                'request_bin'      => null,
                'response_bin'     => null,
            );

            $requiredOptions[] = 'client';

            $config['payum.client'] = function (ArrayObject $config) {

                $config->validateNotEmpty($config['payum.required_options']);

                return new Client($config['client']);
            };
        }


        if (false == $config['payum.api']) {
            $defaultOptions['api'] = array_replace(array(
                'language'           => null,
                'payment_means'      => null,
                'header_flag'        => null,
                'bgcolor'            => null,
                'block_align'        => null,
                'block_order'        => null,
                'textcolor'          => null,
                'normal_return_logo' => null,
                'cancel_return_logo' => null,
                'submit_logo'        => null,
                'logo_id'            => null,
                'logo_id2'           => null,
                'advert'             => null,
                'background_id'      => null,
                'templatefile'       => null,
            ), $apiConfig);

            $requiredOptions[] = 'api';



            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                $client = $config['payum.client'] instanceof \Closure
                    ? $config['payum.client']($config)
                    : $config['payum.client'];

                return new Api($config['api'], $client);
            };
        }



        $config['payum.default_options']  = $defaultOptions;
        $config['payum.required_options'] = $requiredOptions;
        $config->defaults($config['payum.default_options']);


    }

}