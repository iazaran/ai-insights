# AI Insights
Using AI LLMs to analyze data and receive insights and charts to improve specific areas of your business. The default LLM is OpenAI, but you can use any other LLMs.

## Requirements
- PHP >=8.1
- Laravel >= 10

## Get Started
Install `iazaran/ai-insights` via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require iazaran/ai-insights
```

Optionally, publish the configuration file

```bash
php artisan vendor:publish --provider="AIInsights\Providers\AIInsightsServiceProvider"
```

Set .env configuration. You can get your OpenAI API key [here](https://platform.openai.com/account/api-keys). Others are optional.

```bash
AI_BASE_URL=""
AI_CHAT_PATH=""
AI_IMAGE_PATH=""
AI_API_KEY=""
AI_ORGANIZATION=""
AI_PROJECT=""
AI_MODEL=""
AI_IMAGE_MODEL=""
AI_MAX_TOKENS=""
AI_TEMPERATURE=""
AI_INSIGHTS_DEFAULT_GOAL=""
AI_IMAGE_SIZE=""
```

Use the `AIInsightsProcessor` class to analyze your data. As default, it will use your last rows in DB

```php
$businessType = 'Retail';
$goal = 'Increase sales';
$tables = ['orders', 'products'];
$limit = 5;
$insights = AIInsightsProcessor::analyze($businessType, $goal, $tables, $limit);
```


And sample response can be like this, if you are using OpenAI:

```php
[
    'insights' => [
        [
            'index' => 0,
            'message' => [
                'role' => 'assistant',
                'content' => "Based on the provided data from the 'orders' and 'products' tables, here are some insights to improve your Retail business and increase sales:\n\n1. Focus on promoting high-margin products: The data shows that Product A has a higher profit margin compared to other products. Consider running targeted marketing campaigns for this item.\n2. Implement a loyalty program: Analyzing customer purchase history reveals repeat buyers. Introduce a loyalty program to incentivize these customers and encourage more frequent purchases.\n3. Optimize inventory management: The product data indicates some items have low stock levels. Ensure popular products are always available to avoid missing sales opportunities.\n4. Personalize marketing efforts: Use customer order history to create personalized product recommendations, potentially increasing cross-selling and upselling."
            ],
            'finish_reason' => 'stop',
        ],
    ],
    'charts' => [
        [
            'url' => 'https://oaidalleapiprodscus.blob.core.windows.net/private/org-123456/user-123456/img-abcdef.png'
        ],
    ]
]
```
