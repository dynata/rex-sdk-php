> [!warning]
> ## DEPRECATED
> This repository is no longer supported.

# rex-sdk-php

Package for building and interacting with the Dynata Respondent Exchange (REX)

## Quickstart:

## Note: if you do not have an "account_id" null can be used

### _**Opportunity Registry**_

### Instantiate a Registry Client
```php
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;
use Dynata\Rex\Registry\Registry;

$interval = \DateInterval::createFromDateString('1 day');
$creds_provider = new BasicCredentialsProvider("REX_ACCESS_KEY", "REX_SECRET_KEY");
$string_signer = new StringSigner($creds_provider, $interval);
$registy = new Registry("REX_REGISTRY_BASE_URL", $string_signer);
```

##### List Opportunity Notifications

```php
$shardConfig = new ShardConfig(1, 1);
$notification_payload = new ReceiveNotificationsInput(1, $shardConfig, "account_id");
$registry->recieveNotifications($notification_payload);
```


##### Acknowledge Notifications

```php
$ack_notification_payload = new AckNotificationsInput("account_id", [1, 2 , 3]);
$registry->ackNotifications($ack_notification_payload);
```

##### Get Opportunity

```php
$registry->getOpportunity(['id'=> 1]);
```

##### List Project Opportunities

```php
$list_project_opportunities_payload = new ListProjectOpportunitiesInput("account_id", 1);
$registry->listProjectOpportunities($list_project_opportunities_payload);
```

##### Download Collection

```php
$download_collection_payload = new DownloadCollectionInput("account_id", 1);
$registry->downloadCollection($list_project_opportunities_payload);
```

### _**Respondent Gateway**_

### Instantiate a Gateway Client

```php
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;

$interval = \DateInterval::createFromDateString('1 day');
$creds_provider = new BasicCredentialsProvider("REX_ACCESS_KEY", "REX_SECRET_KEY");
$string_signer = new StringSigner($creds_provider, $interval);
$gateway = new Gateway("REX_BASE_URL", $string_signer);

```

##### Create a context

```php
$context = new CreateContextInput("unique_context_id", "account_id", "expiration",
[
        "ctx" => "a987dsglh34t435jkhsdg98u",
        "gender" => "male",
        "postal_code" => "60081",
        "birth_date" => "1959-10-05",
        "country" => "US"
    ]
);
$gateway->createContext($context);
```

##### Get a context

```php
$context = new GetContextInput("unique_context_id", "account_id");
$gatway->getContext($context);
```

##### Expire a context

```php
$context = new ExpireContextInput("unique_context_id", "account_id");
$gatway->expireContext($context);
```

##### Create or Update a Respondent

```php
$respondent = new PutRespondentInput(
    "unique_respondent_id",
    "en",
    "US",
    "female",
    "1999-09-09",
    "60081"
);
$gatway->putRespondent($respondent);
```

##### Create or Update a Respondent Answers

```php
$respondent = new PutRespondentAnwsersInput(
    "unique_respondent_id",
    "US",
    [
         [
            "id" => -9223372036854776000,
            "answers" => [
                -9223372036854776000
            ]
        ]
    ]
);
$gatway->putRespondentAnswers($respondent);
```

##### List Attributes

```php
$list_attributes = new ListAttributesInput();
$list_attributes->page_size = 1;
$gateway->listAttributes($list_attributes);
```

##### Get Attribute Info

```php
$get_attribute_info = new GetAttributeInfoInput(1);
$gateway->getAttributeInfo($get_attribute_info);
```
