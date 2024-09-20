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
     * The base URL for the AI API.
     *
     * @var string
     */
    protected static string $baseUrl;

    /**
     * The path for chat completions.
     *
     * @var string
     */
    protected static string $chatPath;

    /**
     * The path for image generations.
     *
     * @var string
     */
    protected static string $imagePath;

    /**
     * The AI API key.
     *
     * @var string
     */
    protected static mixed $apiKey;

    /**
     * The AI organization ID.
     *
     * @var string|null
     */
    protected static mixed $organization;

    /**
     * The AI project ID.
     *
     * @var string|null
     */
    protected static mixed $project;

    /**
     * The AI model to use.
     *
     * @var string
     */
    protected static mixed $chatModel;

    /**
     * The AI model to use for image creation.
     *
     * @var string
     */
    protected static mixed $imageModel;

    /**
     * The maximum number of tokens for the AI response.
     *
     * @var int
     */
    protected static mixed $maxTokens;

    /**
     * The temperature setting for the AI API.
     *
     * @var float
     */
    protected static mixed $temperature;

    /**
     * The image size for the AI API.
     *
     * @var string
     */
    protected static mixed $imageSize;

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
        self::$baseUrl = config('ai-insights.ai_base_url');
        self::$chatPath = config('ai-insights.ai_chat_path');
        self::$imagePath = config('ai-insights.ai_image_path');
        self::$apiKey = config('ai-insights.api_key');
        self::$organization = config('ai-insights.organization');
        self::$project = config('ai-insights.project');
        self::$chatModel = config('ai-insights.chat_model');
        self::$imageModel = config('ai-insights.image_model');
        self::$maxTokens = config('ai-insights.max_tokens');
        self::$temperature = config('ai-insights.temperature');
        self::$imageSize = config('ai-insights.image_size');
    }

    /**
     * Send a request to the AI API.
     *
     * @param array $prompts The input prompts for the AI model.
     * @return array The decoded JSON response from the API.
     * @throws GuzzleException
     */
    public static function sendRequest(array $prompts): array
    {
        // Initialize headers array with required authentication and content type
        $headers = [
            'Authorization' => 'Bearer ' . self::$apiKey,
            'Content-Type'  => 'application/json',
        ];

        // Add organization ID to headers if it's set
        if (self::$organization) {
            $headers['AI-Organization'] = self::$organization;
        }

        // Add project ID to headers if it's set
        if (self::$project) {
            $headers['AI-Project'] = self::$project;
        }

        // Send a POST request to the AI API
        $chatResponse = self::$client->post(self::$baseUrl . self::$chatPath, [
            'headers' => $headers,
            'json' => [
                'model' => self::$chatModel,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'User has some data and wants to know how to improve their business. Provide insights on how to improve the business, but based on the data provided.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompts['chat_prompt']
                    ]
                ],
                'max_tokens' => self::$maxTokens,
                'temperature' => self::$temperature,
            ],
        ]);

        // Send a POST request to the AI API for image generation
        $imageResponse = self::$client->post(self::$baseUrl . self::$imagePath, [
            'headers' => $headers,
            'json' => [
                'model' => self::$imageModel,
                'prompt' => $prompts['image_prompt'],
                'n' => 1,
                'size' => self::$imageSize,
                'response_format' => 'url',
            ],
        ]);

        // Decode the JSON responses
        $chatResponse = json_decode($chatResponse->getBody()->getContents(), true);
        $imageResponse = json_decode($imageResponse->getBody()->getContents(), true);

        // Combine text insights and image URL
        return [
            'insights' => $chatResponse['choices'],
            'charts' => $imageResponse['data'],
        ];
    }
}
