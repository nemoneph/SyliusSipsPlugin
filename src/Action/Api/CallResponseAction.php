<?php

namespace Nemoneph\SipsPlugin\Action\Api;

use Nemoneph\SipsPlugin\Request\CallResponse;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetHttpRequest;

/**
 * Class CallResponseAction
 * @package Nemoneph\SipsPlugin\Action\Api
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class CallResponseAction extends BaseApiAction
{
    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var CallResponse $request */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $this->gateway->execute($httpRequest = new GetHttpRequest());
        if (isset($httpRequest->request['DATA'])) {
            $data = $this->api->response($httpRequest->request['DATA']);

            $model->replace($data);

            $request->setModel($model);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof CallResponse &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
