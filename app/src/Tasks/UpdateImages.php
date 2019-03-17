<?php
/**
 * @file ￼UpdateImages
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Save image blocks to ensure that the new pagging field is added to all image records
 */
use App\Web\Model\ImageBlock;

use SilverStripe\Dev\BuildTask;

class UpdateImages extends BuildTask
{
    protected $title = 'Update images';
    protected $description = 'Save image blocks to ensure that the new pagging field is added to all image records';
    protected $enabled = true;
    protected $silent = false;
    protected $error = false;
    protected $shutdown = false;

    /**
     * @param    SS_HTTPRequest $request
     */
    public function run($request)
    {
        $images = ImageBlock::get();

        echo '<h2>Saving ' . $images->count() . ' Images.</h2>';

        foreach ($images as $image) {
            $published = $image->isPublished();
            $image->writeToStage('Stage');

            echo 'image: ' . $image->ID . '<br>';
            echo 'Padding: ' . $image->Padding . '<br>';

            if ($published) {
                $image->writeToStage('Live');
            }

            echo 'Updated Padding: ' . $image->Padding . '<br>';
            echo '<hr>';
        }
    }
}
