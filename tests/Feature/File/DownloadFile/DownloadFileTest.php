<?php

declare(strict_types=1);

namespace Tests\Feature\File\DownloadFile;

use App\Http\Actions\ActionWithFile\DownloadFile\DownloadFileAction;
use Tests\TestCase;

final class DownloadFileTest extends TestCase
{
    public function testDownloadSuccess(): void
    {
        $this->getJson($this->urlGenerator->route('download-file'))
            ->assertOk()
            ->assertDownload(DownloadFileAction::FILENAME . '.csv')
        ;
    }

    public function testFileContent(): void
    {
        $content = $this->getJson($this->urlGenerator->route('download-file'))->streamedContent();
        $content = explode(PHP_EOL, $content);

        // last line is empty
        array_pop($content);

        $header = null;
        foreach ($content as $key => $line) {
            if ($key === 0){
                $header = $line;
            } else {
                $data = array_combine(str_getcsv($header), str_getcsv($line));
                $this->debug([
                    '$data' => $data,
                    '$header' => $header
                ]);

                // Your file content checking logic goes here:
                $this->assertEquals(
                    'value1',
                    $data['column1']
                );

                $this->assertEquals(
                    'value2',
                    $data['column2']
                );
            }
        }
    }
}
