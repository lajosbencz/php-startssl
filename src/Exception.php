<?php

namespace StartSSL;

class Exception extends \Exception
{
    const MESSAGES = [
        -2 => "The maximum length for domain name is 64 letter",
        -5 => "This domain name or hostname is not permitted in website control validation",
        -7 => "This domain is not permitted for your current validation level, you need to upgrade to up level. E.g. domain name 'credit.yourdomain.com' is not permitted for Class 1 validation account, but it is permitted for Class 2, Class 3 and Class 4 account.",
        -8 => "Website control validation code generation error",
        -10 => "Domain field is empty or not correct",
        -13 => "This domain is validated",
        -15 => "This domain name or hostname is not permitted",
        -17 => "This domain is not permitted for your current validation level, you need to upgrade to up level. E.g. domain name 'credit.yourdomain.com' is not permitted for Class 1 validation account, but it is permitted for Class 2, Class 3 and Class 4 account.",
        -18 => "Can't find the website control validation file, or can't access your website",
        -40 => "Your API authentication certificate is expired",
        -41 => "Your API authentication certificate is revoked",
        -42 => "API Call Authentication fail, maybe used wrong authen certificate",
        -43 => "JSON format error",
        -44 => "actionType not correct or empty",
        -47 => "This tokenID is not exist or this tokenID is disable to be used to call API",
        -49 => "Internal server error",
        -50 => "orderID is empty or not correct",
        -100 => "Some parameter missed",
        -1020 => "Domain field is empty or not correct",
        -1021 => "Exceed the maximum domain name (120 domains)",
        -1022 => "CSR is empty or format is not correct",
        -1023 => "certType is empty",
        -1024 => "certType is not correct or it don't match your StartSSL account validation level. E.g. your StartSSL account validation level is Class 1, then the certType must be DVSSL, can't be OVSSL or EVSSL.",
        -1025 => "Domain name is not validated",
        -1026 => "This domain name or hostname is not permitted",
        -1027 => "three same common name certificate only per day, please try it tomorrow",
        -1029 => "Wildcard is not permitted for EVSSL and DVSSL",
        -1030 => "Your account is Class 1 validation, only 5 domain name is permitted",
        -2000 => "The daily maximum certificate issued by StartAPI is 100",
        -2001 => "userID error, this userID is not exist or it is not belonged to your account",
        -4001 => "Email format is not correct, or the email is not a qualified email",
        -4002 => "Fail to send the domain verification code",
        -4005 => "Fail to validate this domain",
        -3000 => "userInfo filed is null",
        -3001 => "Empty field : email",
        -3002 => "Wrong field : email",
        -3003 => "Proof document is not enough, for example, you must upload 3 file for class 2 validation",
        -3004 => "The proof document file format must be JPG, GIF, PNG and PDF, and the max size is 4M",
        -3005 => "Empty field: OrgName",
        -3006 => "Wrong field: OrgName",
        -3009 => "The validation level must be 2 or 3 or 4",
        -3012 => "You are not qualified to use StartResell service",
        -3013 => "Error in posting data",
        -3015 => "The current validation level is higher than your application level",
        -3016 => "This parameter for StartResell customer only",
        -3017 => "The quantity of file is greater than 100",
        -3018 => "Empty file",
        -3100 => "Could not find the order",
        -3101 => "The order is not under that start resell user",
        -3102 => "Failed to revoke",
        -3103 => "Cert has been revoked or the order has no revoke request to cancel",
        -3104 => "Failed to cancel revoke",
        -3105 => "Repeated revoke request",
    ];

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        if (is_int($message) && $message < 0 && array_key_exists($message, self::MESSAGES)) {
            $code = $message;
            $message = self::MESSAGES[$code];
        }
        parent::__construct($message, $code, $previous);
    }
}