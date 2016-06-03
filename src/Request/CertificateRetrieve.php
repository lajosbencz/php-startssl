<?php

namespace StartSSL\Request;

use StartSSL\Request;
use StartSSL\Response\CertificateRetrieve as Response;

/**
 * @package StartSSL\Request
 * @method Response send()
 */
class CertificateRetrieve extends Request
{
    /*
     * tokenID
     * actionType
     * orderID
     */

    /**
     * @inheritdoc
     */
    function getAction()
    {
        return 'RetrieveCertificate';
    }


}