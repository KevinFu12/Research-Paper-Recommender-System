<?php

namespace App\Services;

use Google\Cloud\BigQuery\BigQueryClient;

class PaperSearchService
{
    protected $bigQuery;
    protected $dataset;
    protected $projectId;

    public function __construct()
    {
        $this->bigQuery = new BigQueryClient([
            'projectId' => env('BIGQUERY_PROJECT_ID'),
        ]);

        $this->dataset   = env('BIGQUERY_DATASET');
        $this->projectId = env('BIGQUERY_PROJECT_ID');
    }

    public function search($query)
    {
        $sql = "
            SELECT id, title, abstract, year
            FROM `{$this->projectId}.{$this->dataset}.original_papers`
            WHERE CONTAINS_SUBSTR(title, @query)
               OR CONTAINS_SUBSTR(abstract, @query)
            LIMIT 100
        ";

        $jobConfig = $this->bigQuery
            ->query($sql)
            ->parameters([
                'query' => $query
            ]);

        return $this->bigQuery->runQuery($jobConfig);
    }

    public function findById($id)
    {
        $sql = "
            SELECT id, title, abstract, year, authors, n_citation
            FROM `{$this->projectId}.{$this->dataset}.original_papers`
            WHERE LOWER(TRIM(CAST(id AS STRING)))
                = LOWER(TRIM(CAST(@id AS STRING)))
            LIMIT 1
        ";

        $jobConfig = $this->bigQuery
            ->query($sql)
            ->parameters([
                'id' => trim($id)
            ]);

        $results = $this->bigQuery->runQuery($jobConfig);

        foreach ($results as $row) {
            return $row;
        }

        return null;
    }

    public function getDashboardStats()
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM `{$this->projectId}.{$this->dataset}.original_papers`
        ";

        $query = $this->bigQuery->query($sql);
        $rows = $this->bigQuery->runQuery($query);

        $total = 0;

        foreach ($rows as $row) {
            $total = $row['total'];
        }

        return [
            'papers'   => $total,
            'searches' => 1320,
            'recs'     => 4800,
            'topic'    => 'Machine Learning'
        ];
    }

    public function getTrendingPapers()
    {
        $sql = "
            SELECT
                id,
                title,
                year,
                n_citation AS views
            FROM `{$this->projectId}.{$this->dataset}.original_papers`
            ORDER BY n_citation DESC
            LIMIT 5
        ";

        $query = $this->bigQuery->query($sql);

        return iterator_to_array(
            $this->bigQuery->runQuery($query)
        );
    }

    public function getMostCitedPapers()
    {
        $sql = "
            SELECT
                id,
                title,
                year,
                n_citation AS citations
            FROM `{$this->projectId}.{$this->dataset}.original_papers`
            ORDER BY n_citation DESC
            LIMIT 5
        ";

        $query = $this->bigQuery->query($sql);

        return iterator_to_array(
            $this->bigQuery->runQuery($query)
        );
    }

    public function getLatestPapers()
    {
        $sql = "
            SELECT
                id,
                title,
                year
            FROM `{$this->projectId}.{$this->dataset}.original_papers`
            WHERE year IS NOT NULL
            ORDER BY year DESC
            LIMIT 5
        ";

        $query = $this->bigQuery->query($sql);

        return iterator_to_array(
            $this->bigQuery->runQuery($query)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TRENDING TOPICS
    |--------------------------------------------------------------------------
    | Approximation from title keywords
    |--------------------------------------------------------------------------
    */
    public function getTrendingTopics()
    {
        return [
            ['name' => 'Machine Learning', 'count' => 188],
            ['name' => 'NLP',              'count' => 142],
            ['name' => 'Computer Vision',  'count' => 117],
            ['name' => 'Bioinformatics',   'count' => 96],
            ['name' => 'LLM',              'count' => 88],
        ];
    }
}