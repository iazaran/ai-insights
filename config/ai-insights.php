<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Insights Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings for the AI Insights package.
    | It includes API credentials and default settings for the package.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | AI Base URL
    |--------------------------------------------------------------------------
    |
    | This setting specifies the base URL for the AI service.
    | You can set this in your .env file to point to your AI service.
    |
    */
    'ai_base_url' => env('AI_BASE_URL', 'https://api.openai.com/v1'),

    /*
    |--------------------------------------------------------------------------
    | AI Chat Path
    |--------------------------------------------------------------------------
    |
    | This setting specifies the path for the chat endpoint of the AI service.
    | You can set this in your .env file to point to the chat endpoint.
    |
    */
    'ai_chat_path' => env('AI_CHAT_PATH', '/chat/completions'),

    /*
    |--------------------------------------------------------------------------
    | AI Image Path
    |--------------------------------------------------------------------------
    |
    | This setting specifies the path for the image generation endpoint of the AI service.
    | You can set this in your .env file to point to the image generation endpoint.
    |
    */
    'ai_image_path' => env('AI_IMAGE_PATH', '/images/generations'),

    /*
    |--------------------------------------------------------------------------
    | AI API Key
    |--------------------------------------------------------------------------
    |
    | This key is used to authenticate requests to the AI API.
    | It should be set in your .env file for security.
    |
    */
    'ai_api_key' => env('AI_API_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | AI Organization ID
    |--------------------------------------------------------------------------
    |
    | This is the organization ID for your AI account. It's used to
    | associate API requests with your organization. You can find this
    | in your AI account settings. Set it in your .env file.
    |
    */
    'ai_organization' => env('AI_ORGANIZATION', null),

    /*
    |--------------------------------------------------------------------------
    | AI Project
    |--------------------------------------------------------------------------
    |
    | This setting specifies the AI project to be used for generating insights.
    | You can set this in your .env file to associate requests with a specific project.
    |
    */
    'ai_project' => env('AI_PROJECT', null),

    /*
    |--------------------------------------------------------------------------
    | AI Model
    |--------------------------------------------------------------------------
    |
    | This setting specifies the AI model to be used for generating insights.
    | You can change this in your .env file to use different models as needed.
    |
    */
    'ai_chat_model' => env('AI_CHAT_MODEL', 'gpt-4o-mini'),

    /*
    |--------------------------------------------------------------------------
    | AI Image Model
    |--------------------------------------------------------------------------
    |
    | This setting specifies the AI model to be used for generating images.
    | You can change this in your .env file to use different image models as needed.
    |
    */
    'ai_image_model' => env('AI_IMAGE_MODEL', 'dall-e-3'),

    /*
    |--------------------------------------------------------------------------
    | AI Max Tokens
    |--------------------------------------------------------------------------
    |
    | This setting specifies the maximum number of tokens to be generated
    | in the response from the AI API. You can adjust this value
    | based on your needs for response length and API usage.
    |
    */
    'ai_max_tokens' => env('AI_MAX_TOKENS', 150),

    /*
    |--------------------------------------------------------------------------
    | AI Temperature
    |--------------------------------------------------------------------------
    |
    | This setting controls the randomness of the AI's output. Values closer to 0
    | produce more focused and deterministic responses, while values closer to 1
    | make the output more diverse and creative. The default is set to 0.7,
    | which provides a balance between coherence and creativity.
    |
    */
    'ai_temperature' => env('AI_TEMPERATURE', 0.7),

    /*
    |--------------------------------------------------------------------------
    | Default Business Goal
    |--------------------------------------------------------------------------
    |
    | This setting defines the default goal for business analysis.
    | It can be overridden when calling the analyze method.
    |
    */
    'ai_insights_default_goal' => env('AI_INSIGHTS_DEFAULT_GOAL', 'increase sales'),

    /*
    |--------------------------------------------------------------------------
    | AI Image Size
    |--------------------------------------------------------------------------
    |
    | This setting specifies the size of the image to be generated by the AI API.
    | It can be overridden when calling the analyze method.
    |
    */
    'ai_image_size' => env('AI_IMAGE_SIZE', '1024x1024'),

];
