<?php

namespace StartSSL\Request;

use StartSSL\Request;

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