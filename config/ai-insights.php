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
    | OpenAI API Key
    |--------------------------------------------------------------------------
    |
    | This key is used to authenticate requests to the OpenAI API.
    | It should be set in your .env file for security.
    |
    */
    'openai_api_key' => env('OPENAI_API_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Organization ID
    |--------------------------------------------------------------------------
    |
    | This is the organization ID for your OpenAI account. It's used to
    | associate API requests with your organization. You can find this
    | in your OpenAI account settings. Set it in your .env file.
    |
    */
    'openai_organization' => env('OPENAI_ORGANIZATION', null),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Project
    |--------------------------------------------------------------------------
    |
    | This setting specifies the OpenAI project to be used for generating insights.
    | You can set this in your .env file to associate requests with a specific project.
    |
    */
    'openai_project' => env('OPENAI_PROJECT', null),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Model
    |--------------------------------------------------------------------------
    |
    | This setting specifies the OpenAI model to be used for generating insights.
    | You can change this in your .env file to use different models as needed.
    |
    */
    'openai_model' => env('OPENAI_MODEL', 'gpt-4o-mini'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Max Tokens
    |--------------------------------------------------------------------------
    |
    | This setting specifies the maximum number of tokens to be generated
    | in the response from the OpenAI API. You can adjust this value
    | based on your needs for response length and API usage.
    |
    */
    'openai_max_tokens' => env('OPENAI_MAX_TOKENS', 150),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Temperature
    |--------------------------------------------------------------------------
    |
    | This setting controls the randomness of the AI's output. Values closer to 0
    | produce more focused and deterministic responses, while values closer to 1
    | make the output more diverse and creative. The default is set to 0.7,
    | which provides a balance between coherence and creativity.
    |
    */
    'openai_temperature' => env('OPENAI_TEMPERATURE', 0.7),

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

];
