<?php

namespace App\Services;

use Google\Cloud\BigQuery\BigQueryClient;

class PaperSearchService
{
    protected $bigQuery;
    protected $dataset;

    public function __construct()
    {
        // No keyFilePath needed! ADC handles the authentication.
        $this->bigQuery = new BigQueryClient([
            'projectId' => config('services.bigquery.project_id')
        ]);
        
        $this->dataset = config('services.bigquery.dataset');
    }

    public function search($query)
    {
        $projectId = config('services.bigquery.project_id');
        
        $str = "SELECT id, title, abstract, year 
                FROM `{$projectId}.{$this->dataset}.original_papers`
                WHERE CONTAINS_SUBSTR(title, @query) OR CONTAINS_SUBSTR(abstract, @query)
                LIMIT 20";

        $jobConfig = $this->bigQuery->query($str)->parameters(['query' => $query]);
        return $this->bigQuery->runQuery($jobConfig);
    }
}