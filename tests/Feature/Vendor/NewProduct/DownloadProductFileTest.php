<?php

namespace Tests\Feature\Vendor\NewProduct;

use App\File;
use App\Vendor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadProductFileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_vendor_can_download_the_uploaded_file_for_their_new_product()
    {
        $this->actingAs(
            factory(Vendor::class)->create()
        );

        Storage::fake();

        Storage::put(
            'product_files/download.tst',
            'This is only a test.'
        );

        $file = factory(File::class)
            ->states('product_file')
            ->create([
                'disk' => 'local',
                'path' => 'product_files/download.tst',
                'original_name' => 'download.tst',
                'size' => strlen('This is only a test.')
            ]);

        $this->session([
            'new_product' => [
                'product_file_step' => [
                    'file_id' => $file->id
                ]
            ]
        ]);

        $this->get('/vendor/new-product/download-product-file')
            ->assertHeader('Content-Disposition', 'attachment; filename=download.tst')
            ->assertSee('This is only a test.');
    }
}
