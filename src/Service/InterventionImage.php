<?php 

namespace App\Service;

use Intervention\Image\ImageManager;

class InterventionImage
{
    public function resizeCatalogBpCarroussel($image)
    {
        ini_set ("memory_limit", " -1 ");
        $manager = new ImageManager();

        $manager
            ->make('../public/uploads/models/' . $image)
            ->resize(600,330)
            ->save('../public/uploads/models/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
    }

    
    public function resizeCatalogVbCarroussel($image)
    {
        ini_set ("memory_limit", " -1 ");
        $manager = new ImageManager();

        $manager
            ->make('../public/uploads/modelsVb/' . $image)
            ->resize(600,330)
            ->save('../public/uploads/modelsVb/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
    }
}