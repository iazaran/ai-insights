<?php

namespace AIInsights;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class AIInsightsProcessor
{
    /**
     * The AIInsights instance.
     *
     * @var AIInsights
     */
    protected static $AIInsights;

    /**
     * Get the AIInsights instance, creating it if it doesn't exist.
     *
     * @return AIInsights
     */
    protected static function getAIInsights(): AIInsights
    {
        // Check if the AIInsights instance has not been created yet
        if (!static::$AIInsights) {
            // Create a new AIInsights instance
            static::$AIInsights = new AIInsights();
        }
        // Return the AIInsights instance (either newly created or existing)
        return static::$AIInsights;
    }

    /**
     * Analyze business data using AI insights.
     *
     * @param string $businessType The type of business
     * @param string $goal The business goal
     * @param array $tables The database tables to analyze
     * @return array The AI-generated insights
     * @throws GuzzleException
     */
    public static function analyze(string $businessType, string $goal, array $tables, int $limit = 5): array
    {
        // Create a new instance of the current class
        $instance = new static();
        
        // Call the processAnalysis method on the instance with the provided parameters
        // and return the result
        return $instance->processAnalysis($businessType, $goal, $tables, $limit);
    }


    /**
     * Process the analysis request.
     *
     * @param string $businessType The type of business
     * @param string $goal The business goal
     * @param array $tables The database tables to analyze
     * @return array The AI-generated insights
     * @throws GuzzleException
     */
    protected function processAnalysis(string $businessType, string $goal, array $tables, int $limit): array
    {
        // Fetch data samples from the specified tables
        $dataSamples = $this->fetchDataSamples($tables, $limit);

        // Generate the AI prompt based on business type, goal, and data samples
        $prompt = $this->generatePrompt($businessType, $goal, $dataSamples);

        // Send the generated prompt to the AI service and return the response
        return self::getAIInsights()->sendRequest($prompt);
    }

    /**
     * Fetch data samples from the specified tables and format as CSV-like structure.
     *
     * @param array $tables The database tables to sample
     * @param int $limit The number of rows to fetch from each table
     * @return array The sampled data from each table in CSV-like format
     */
    protected function fetchDataSamples(array $tables, int $limit): array
    {
        $samples = [];

        foreach ($tables as $table) {
            // Get the column names for the current table
            $columns = DB::getSchemaBuilder()->getColumnListing($table);

            // Exclude IDs and popular credentials columns
            $filteredColumns = array_filter($columns, function($column) {
                $lowercaseColumn = strtolower($column);
                return !in_array($lowercaseColumn, ['id', 'password', 'api_key', 'token', 'secret']) 
                    && !str_ends_with($lowercaseColumn, '_id');
            });

            // Fetch the last rows from the current table
            $rows = DB::table($table)->orderBy('id', 'desc')->limit($limit)->get($filteredColumns);

            // Create header row
            $header = $filteredColumns;

            // Convert each row to an array of values
            $data = $rows->map(function ($row) use ($filteredColumns) {
                return array_map(function ($column) use ($row) {
                    return $row->$column;
                }, $filteredColumns);
            })->toArray();

            // Add the header row to the beginning of the data array
            array_unshift($data, $header);
            
            // Convert the 2D array to a CSV-like string and store in samples array
            $samples[$table] = $this->arrayToCsvString($data);
        }

        return $samples;
    }

    /**
     * Convert a 2D array to a CSV-like string.
     *
     * @param array $data The 2D array to convert
     * @return string The CSV-like string
     */
    protected function arrayToCsvString(array $data): string
    {
        // Convert each row to a comma-separated string, then join rows with newlines
        return implode("\n", array_map(function ($row) {
            return implode(",", $row);
        }, $data));
    }

    /**
     * Generate the AI prompt based on business type, goal, and data samples.
     *
     * @param string $businessType The type of business
     * @param string $goal The business goal
     * @param array $dataSamples The sampled data from database tables in CSV-like format
     * @return string The generated prompt for AI analysis
     */
    protected function generatePrompt(string $businessType, string $goal, array $dataSamples): string
    {
        // Start the prompt with business type and goal
        $prompt = "Business Type: $businessType\n";
        $prompt .= "Goal: $goal\n\n";
        $prompt .= "Data Samples:\n";

        // Add each table's data to the prompt
        foreach ($dataSamples as $table => $data) {
            $prompt .= "Table: $table\n";
            $prompt .= $data . "\n";
        }

        // Add the final instruction for the AI
        $prompt .= "\nBased on the provided business type, goal, and data samples, please provide insights and recommendations to improve the business.";

        return $prompt;
    }
}
