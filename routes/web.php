<?php

use AmoCRM\OAuth\OAuthConfigInterface;
use AmoCRM\OAuth\OAuthServiceInterface;
use Illuminate\Support\Facades\Route;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\OAuth2\Client\Provider\AmoCRM;

include_once __DIR__ . '/../app/amo/auth.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/app/amo/auth.php', function () {
    list($clientId, $clientSecret, $redirectUri) = getData();

    $provider = new AmoCRM([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'redirectUri' => $redirectUri,
    ]);

    $accessToken = getToken();
    $ownerDetails = $provider->getResourceOwner($accessToken);
   
    return view('after', ['user' => $ownerDetails->getName()]);
});

Route::get('/', function () {

    // list($clientId, $clientSecret, $redirectUri) = getData();
    // echo "clientId = $clientId<br>";
    // echo "clientSecret = $clientSecret<br>";
    // echo "redirectUri = $redirectUri<br>";

    // retriveAccessToken();
    // $oAuthConfig = new UserAuth($clientId, $clientSecret, $redirectUri);
    
    // $accessToken = getToken();
    // echo "get token blabla $accessToken";

    // $baseDomain = $accessToken['baseDomain'];
    // $oAuthService = new UserToken($accessToken, $baseDomain);

    // $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

    // $apiClient->setAccessToken($accessToken)
    //     ->setAccountBaseDomain($accessToken->getValues()['baseDomain']);

    // $state = 0;

    // try {

    //     $mybutton = $apiClient->getOAuthClient()->getOAuthButton(
    //         [
    //             'title' => 'Установить интеграцию',
    //             'compact' => true,
    //             'class_name' => 'className',
    //             'color' => 'default',
    //             'error_callback' => 'handleOauthError',
    //             'state' => $state,
    //         ]
    //     );
    //     printf("$mybutton");
    // } catch (\AmoCRM\Exceptions\BadTypeException$e) {
    //     echo "exception thrown";
    // }

    return view('welcome');
});

Route::get('/doaction', function () {
    return view('after');
});

class UserAuth implements OAuthConfigInterface
{

    public $clientId;
    public $clientSecret;
    public $redirectUri;

    public function __construct($clientId, $clientSecret, $redirectUri)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }

    public function getIntegrationId(): string
    {
        return $this->clientId;
    }

    public function getSecretKey(): string
    {
        return $this->clientSecret;
    }

    public function getRedirectDomain(): string
    {
        return $this->redirectUri;
    }

}

class UserToken implements OAuthServiceInterface
{

    public $accessToken;
    public $baseDomain;

    public function __construct($accessToken, $baseDomain)
    {
        $this->baseDomain = $baseDomain;
        $this->accessToken = $accessToken;
    }

    public function saveOAuthToken(AccessTokenInterface $accessToken, string $baseDomain): void
    {

        saveToken([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
            'baseDomain' => $baseDomain,
        ]);

    }

}
