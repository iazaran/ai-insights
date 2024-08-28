<?php

namespace Tests;

use AIInsights\AIInsightsProcessor;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class AIInsightsTest extends TestCase
{
    /**
     * Test the analyze method of AIInsightsProcessor
     *
     * @return void
     * @throws GuzzleException
     */
    public function testAnalyze()
    {
        // Set up test data
        $businessType = 'retail';
        $goal = 'increase sales';
        // TODO: Update tables based on your actual database tables
        $tables = ['products', 'sales'];

        // Call the analyze method
        $result = AIInsightsProcessor::analyze($businessType, $goal, $tables);

        // Assert that the result is a non-empty array
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        
        // Check if the OpenAI response has the expected structure
        $this->assertArrayHasKey('choices', $result);
        $this->assertIsArray($result['choices']);
        $this->assertNotEmpty($result['choices']);
        
        // Check if the first choice has a message with content
        $this->assertArrayHasKey('message', $result['choices'][0]);
        $this->assertArrayHasKey('content', $result['choices'][0]['message']);
        $this->assertNotEmpty($result['choices'][0]['message']['content']);
    }
}
