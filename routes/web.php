<?php

use Illuminate\Support\Facades\Route;
use AmoCRM\OAuth\OAuthConfigInterface;
use AmoCRM\OAuth\OAuthServiceInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

// include_once __DIR__ . '/../app/amo/auth.php';
include_once __DIR__ . '/../app/amo/auth2.php';


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



Route::get('/', function () {

    list($clientId,$clientSecret,$redirectUri) = getData();
    echo "clientId = $clientId<br>";
    echo "clientSecret = $clientSecret<br>";
    echo "redirectUri = $redirectUri<br>";

    $oAuthConfig = new UserAuth($clientId, $clientSecret, $redirectUri);
    $baseDomain = 'noriksaroyan.amocrm.ru';

    echo "base domain after <br>";

    $accessToken = getToken($baseDomain);

    echo "get token <br>";

    $oAuthService = new UserToken($accessToken, $baseDomain);



    echo "apiclient <br>";
    $apiClient = new \AmoCRM\Client\AmoCRMApiClient('$clientId', '$clientSecret', '$redirectUri');


    echo "set access token <br>";

    $apiClient->setAccessToken($accessToken)
        ->setAccountBaseDomain($accessToken->getValues()['baseDomain']);


        echo "try block <br>";
$state=0;


    try {

        $mybutton = $apiClient->getOAuthClient()->getOAuthButton(
            [
                'title' => 'Установить интеграцию',
                'compact' => true,
                'class_name' => 'className',
                'color' => 'default',
                'error_callback' => 'handleOauthError',
                'state' => $state,
            ]
        );
         printf("$mybutton"); 
    } catch (\AmoCRM\Exceptions\BadTypeException$e) {
        echo "exception thrown";
    }

    return view('welcome', ['user' => 'test user']);
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

    public function saveOAuthToken(AccessTokenInterface $accessToken, string $baseDomain) :void
    {

        saveToken([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
            'baseDomain' => $baseDomain,
        ]);


    }

}
