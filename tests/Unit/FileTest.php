<?php

namespace Tests\Unit;

use App\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_can_get_the_file_contents()
    {
        Storage::fake();

        $contents = $this->faker->text;
        tap($handle = tmpfile(), function ($handle) use ($contents) {
            fwrite($handle, $contents);
        });

        $path = (new \Illuminate\Http\Testing\File(
            $this->faker->word.'.'.$this->faker->fileExtension,
            $handle
        ))->store('some/path', 'local');

        $file = new File([
            'disk' => 'local',
            'path' => $path,
        ]);

        $this->assertEquals($contents, $file->getContents());
    }

    /**
     * @test
     */
    public function it_can_get_the_file_extension()
    {
        $ext = $this->faker->fileExtension;

        $file = new File([
            'path' => 'path/to/file.'.$ext
        ]);

        $this->assertEquals($ext, $file->getExtension());
    }
}
