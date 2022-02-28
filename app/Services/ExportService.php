<?php


namespace App\Services;


use Spatie\DbDumper\Databases\MySql;

class ExportService
{
    /**
     * @return string
     */
    public function generateDbFile()
    {
        MySql::create()
            ->setDbName(config('app.DB_DATABASE'))
            ->setHost(config('app.DB_HOST'))
            ->setUserName(config('app.DB_USERNAME'))
            ->setPassword(config('app.DB_PASSWORD'))
            ->includeTables(['columns', 'cards'])
            ->doNotUseColumnStatistics()
            ->dumpToFile('dump.sql');

        $file = public_path('dump.sql');
        return $file;
    }
}
