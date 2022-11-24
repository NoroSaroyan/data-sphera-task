<?php

use AmoCRM\Exceptions\AmoCRMApiException;

$clientId='xxx';
$clientSecret='xxxx-xxxx-xxxx-xxxx';
$redirectUri = 'google.com';
$apiClient = new \AmoCRM\Client\AmoCRMApiClient('$clientId', '$clientSecret', '$redirectUri');


$apiClientFactory = new \AmoCRM\Client\AmoCRMApiClientFactory($oAuthConfig, $oAuthService);
$apiClient = $apiClientFactory->make();
$accessToken = getToken();
$apiClient->setAccessToken($accessToken)
   ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
   ->onAccessTokenRefresh(
       function (\League\OAuth2\Client\Token\AccessTokenInterface $accessToken, string $baseDomain) {
           saveToken(
               [
                   'accessToken' => $accessToken->getToken(),
                   'refreshToken' => $accessToken->getRefreshToken(),
                   'expires' => $accessToken->getExpires(),
                   'baseDomain' => $baseDomain,
               ]
           );
       });

$authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
    'state' => $state,
    'mode' => 'post_message', //post_message - редирект произойдет в открытом окне, popup - редирект произойдет в окне родителе
]);

header('Location: ' . $authorizationUrl);

$state = 0;

try {
   $apiClient->getOAuthClient()->getOAuthButton(
       [
           'title' => 'Установить интеграцию',
           'compact' => true,
           'class_name' => 'className',
           'color' => 'default',
           'error_callback' => 'handleOauthError',
           'state' => $state,
       ]
   );
} catch (\AmoCRM\Exceptions\BadTypeException $e) {

}
 function getLeads()
   {
       $leadsService = $apiClient->leads();

       //Получим сделки и следующую страницу сделок
       try {
           $leadsCollection = $leadsService->get();
           $leadsService->
           $leadsCollection = $leadsService->nextPage($leadsCollection);
       } catch (AmoCRMApiException $e) {
           printError($e);
           die;
       }
   }

   $leads = $apiClient->leads()->get();

   foreach ($leads as $lead) {
       //Получим коллекцию значений полей сделки
       $customFields = $lead->getCustomFieldsValues();
       $lead->getCustomFieldsValues();

       //Получим значение поля по его ID
       if (!empty($customFields)) {
           $textField = $customFields->getBy('fieldId', 269303);
           if ($textField) {
               $textFieldValueCollection = $textField->getValues();
           }
       }

       if (empty($textFieldValueCollection)) {
           //Если полей нет
           $customFields = new CustomFieldsValuesCollection();
           $textField = (new TextCustomFieldValuesModel())->setFieldId(269303);
           $textFieldValueCollection = (new TextCustomFieldValueCollection());
           $customFields->add($textField);
       }

       $textField->setValues(
           (new TextCustomFieldValueCollection())
               ->add(
                   (new TextCustomFieldValueModel())
                       ->setValue('новое значение')
               )
       );

       //Или удалим значение поля
       //$textField->setValues(
       //    (new NullCustomFieldValueCollection())
       //);

       //Ниже зададим/обновим значения для полей типа дата-время и день рождения
       foreach ($customFields as $customFieldValues) {
           if (
               $customFieldValues instanceof DateTimeCustomFieldValuesModel
               || $customFieldValues instanceof BirthdayCustomFieldValuesModel
           ) {
               $customFieldValue = $customFieldValues->getValues()->first();
               /** @var Carbon|null $value */
               $value = $customFieldValue->getValue();
               if ($value) {
                   if ($customFieldValues instanceof DateTimeCustomFieldValuesModel) {
                       //Если поле дата/время, укажем завтрашний день
                       $customFieldValue->setValue(new Carbon('tomorrow'));
                   } else {
                       //Если поле заполнено, добавим 100 дней
                       $value->addYears(50);
                   }
               }
           }
       }

       $lead->setCustomFieldsValues($customFields);

       //Установим название
       $lead->setName('Example lead');
       //Установим бюджет
       $lead->setPrice(12);
       //Установим нового ответственного пользователя
       $lead->setResponsibleUserId(0);
       //Удалим теги
       $lead->setTags((new NullTagsCollection()));
   }


