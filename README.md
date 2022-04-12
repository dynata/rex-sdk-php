# rex-sdk-php

Package for building and interacting with the Dynata Respondent Exchange (REX)


## Quickstart:



### *__Respondent Gateway__*
### Instantiate a Gateway Client
```
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;

$interval = \DateInterval::createFromDateString('1 day');
$creds_provider = new BasicCredentialsProvider("REX_ACCESS_KEY", "REX_SECRET_KEY");
$string_signer = new StringSigner($creds_provider, $interval);
$gateway = new Gateway("REX_BASE_URL", $string_signer);

```

##### Create a context
```
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
```
$context = new GetContextInput("unique_context_id", "account_id");
$gatway->getContext($context);
```

##### Expire a context
```
$context = new ExpireContextInput("unique_context_id", "account_id");
$gatway->expireContext($context);
```

##### Create or Update a Respondent
```
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
```
$respondent = new PutRespondentAnwsersInput(
    "unique_respondent_id",
    "US",
    "attributes" => [
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

### *__Opportunity Registry__*
### Instantiate a Registry Client

```
use Dynata\Rex\Core\Security\BasicCredentialsProvider;
use Dynata\Rex\Core\Security\StringSigner;
use Dynata\Rex\Registry\Registry;

$interval = \DateInterval::createFromDateString('1 day');
$creds_provider = new BasicCredentialsProvider("REX_ACCESS_KEY", "REX_SECRET_KEY");
$string_signer = new StringSigner($creds_provider, $interval);
$registy = new Registry("REX_REGISTRY_BASE_URL", $string_signer);
```

##### List Opportunities
```
$shardConfig = new ShardConfig(1, 1);
$opportunity_payload = new ListOpportunitiesInput(1, $shardConfig, "account_id");
$registry->listOpportunities($opportunity_payload);
```

##### List Opportunities
```
$shardConfig = new ShardConfig(1, 1);
$opportunity_payload = new ListOpportunitiesInput(1, $shardConfig, "account_id");
$registry->listOpportunities($opportunity_payload);
```

##### Acknowledge Opportunities
```
$ack_opportunity_payload = new AckOpportunitiesInput("account_id", [1, 2 , 3]);
$registry->ackOpportunities($ack_opportunity_payload);
```
##### Get Opportunity
```
$registry->getOpportunity(['id'=> 1]);
```
##### List Project Opportunities
```
$list_project_opportunities_payload = new ListProjectOpportunitiesInput("account_id", 1);
$registry->listProjectOpportunities($list_project_opportunities_payload);
```
##### Download Collection
```
$download_collection_payload = new DownloadCollectionInput("account_id", 1);
$registry->downloadCollection($list_project_opportunities_payload);
```

##### Get Attribute Questions
```
$get_attribute_question_payload = new GetAttributeQuestionsInput("US");
$registry->getAttributeQuestions($get_attribute_question_payload);
```
##### Get Attribute Answers
```
$get_attribute_answer_payload = new GetAttributeAnswersInput("US");
$registry->getAttributeAnswers($get_attribute_answer_payload);
```
