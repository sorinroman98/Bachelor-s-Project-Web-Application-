<?php


function generate_public_pvkey(){
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    $res = openssl_pkey_new($config);
    openssl_pkey_export($res, $privKey);
    $pubKey = openssl_pkey_get_details($res);
    $pubKey = $pubKey["key"];
    $data = [
        'pvKey'    => $privKey,
        'pubKey' => $pubKey
    ];

    return $data;
}


function encrypt_message($data,$pubKey){

    if(   openssl_public_encrypt($data, $encrypted, $pubKey)){
        return $encrypted;
    }else{
        return false;
    }
}

function decrypt_message($encrypted,$privKey){

    if(openssl_private_decrypt($encrypted, $decrypted, $privKey)){
        return $decrypted;
    }else{
        return false;
    }

}




