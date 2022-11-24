<?php

use League\OAuth2\Client\Token\AccessToken;

define('TOKEN_FILE', DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'token_info.json');

// /**
//  * @param array $accessToken
//  */
// function saveToken($accessToken)
// {
//     if (
//         isset($accessToken)
//         && isset($accessToken['accessToken'])
//         && isset($accessToken['refreshToken'])
//         && isset($accessToken['expires'])
//         && isset($accessToken['baseDomain'])
//     ) {

//         $json = json_decode(file_get_contents(TOKEN_FILE), true);

//         $json['tokens'][$accessToken['baseDomain']] = [
//             'accessToken' => $accessToken['accessToken'],
//             'expires' => $accessToken['expires'],
//             'refreshToken' => $accessToken['refreshToken'],
//             'baseDomain' => $accessToken['baseDomain'],
//         ];

//         file_put_contents(TOKEN_FILE, json_encode($json));
//     } else {
//         exit('Invalid access token ' . var_export($json, true));
//     }
// }

// /**
//  * @return AccessToken
//  */
// function getToken($domain)
// {
//     if (!file_exists(TOKEN_FILE)) {
//         exit('Access token file not found');
//     }

//     $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

//     if (isset($accessToken['tokens'])) {

//         foreach ($accessToken['tokens'] as $token) {

//             if (
//                 isset($token['accessToken'])
//                 && isset($token['refreshToken'])
//                 && isset($token['expires'])
//                 && isset($token['baseDomain'])
//                 && $token['baseDomain'] == $domain
//             )  {

//                 return new AccessToken([
//                     'access_token' => $token['accessToken'],
//                     'refresh_token' => $token['refreshToken'],
//                     'expires' => $token['expires'],
//                     'baseDomain' => $token['baseDomain'],
//                 ]);

//             }
//         }
//     } else {
//         exit('Invalid access token ' . var_export($accessToken, true));
//     }

// }

/*
* list($clientId,$clientSecret,$redirectUri) = getData
*/
function getData() {
    $clientId = env('CLIENT_ID', "xxx");
    $clientSecret = env('CLIENT_SECRET', 'xxx');
    $redirectUri = env('REDIRECT_URI', 'xxx');

    return array($clientId,$clientSecret,$redirectUri);
}



function saveToken($accessToken)
{
    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        $data = [
            'accessToken' => $accessToken['accessToken'],
            'expires' => $accessToken['expires'],
            'refreshToken' => $accessToken['refreshToken'],
            'baseDomain' => $accessToken['baseDomain'],
        ];

        file_put_contents(TOKEN_FILE, json_encode($data));
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

/**
 * @return \League\OAuth2\Client\Token\AccessToken
 */
function getToken()
{
    $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        return new \League\OAuth2\Client\Token\AccessToken([
            'access_token' => $accessToken['accessToken'],
            'refresh_token' => $accessToken['refreshToken'],
            'expires' => $accessToken['expires'],
            'baseDomain' => $accessToken['baseDomain'],
        ]);
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}
