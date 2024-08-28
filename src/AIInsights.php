<?php

namespace AIInsights;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AIInsights
{
    /**
     * The HTTP client instance.
     *
     * @var Client
     */
    protected static Client $client;

    /**
     * The OpenAI API key.
     *
     * @var string
     */
    protected static mixed $apiKey;

    /**
     * The OpenAI organization ID.
     *
     * @var string|null
     */
    protected static mixed $organization;

    /**
     * The OpenAI project ID.
     *
     * @var string|null
     */
    protected static mixed $project;

    /**
     * The OpenAI model to use.
     *
     * @var string
     */
    protected static mixed $model;

    /**
     * The maximum number of tokens for the OpenAI response.
     *
     * @var int
     */
    protected static mixed $maxTokens;

    /**
     * The temperature setting for the OpenAI API.
     *
     * @var float
     */
    protected static mixed $temperature;

    /**
     * AIInsights constructor.
     *
     * Initializes the HTTP client and sets the API key from the configuration.
     */
    public function __construct()
    {
        // Initialize the HTTP client
        self::$client = new Client();

        // Set the API key, model and max tokens from the configuration
        self::$apiKey = config('ai-insights.openai_api_key');
        self::$organization = config('ai-insights.openai_organization');
        self::$project = config('ai-insights.openai_project');
        self::$model = config('ai-insights.openai_model');
        self::$maxTokens = config('ai-insights.openai_max_tokens');
        self::$temperature = config('ai-insights.openai_temperature');
    }

    /**
     * Send a request to the OpenAI API.
     *
     * @param string $prompt The input prompt for the AI model.
     * @return array The decoded JSON response from the API.
     * @throws GuzzleException
     */
    public static function sendRequest(string $prompt): array
    {
        // Initialize headers array with required authentication and content type
        $headers = [
            'Authorization' => 'Bearer ' . self::$apiKey,
            'Content-Type'  => 'application/json',
        ];

        // Add organization ID to headers if it's set
        if (self::$organization) {
            $headers['X-Organization-ID'] = self::$organization;
        }

        // Add project ID to headers if it's set
        if (self::$project) {
            $headers['X-Project-ID'] = self::$project;
        }

        // Send a POST request to the OpenAI API
        $response = self::$client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => $headers,
            'json' => [
                'model' => self::$model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'User has some data and wants to know how to improve their business. Provide insights on how to improve the business, but based on the data provided.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => self::$maxTokens,
                'temperature' => self::$temperature,
            ],
        ]);

        // Decode the JSON response and extract the main AI response
        $decodedResponse = json_decode($response->getBody()->getContents(), true);
        
        return $decodedResponse['choices'];
    }
}
