<?php 

namespace App\Service;

use Intervention\Image\ImageManager;

class InterventionImage
{
    public function resizeCatalogBpCarroussel($image, $width, $height)
    {
        ini_set ("memory_limit", " -1 ");
        $manager = new ImageManager();

        if($width > $height){
            $biggestSize = $width;
        }else{
            $biggestSize = $height;
        }

        if($biggestSize > 1500 && $biggestSize < 3000){
        $manager
            ->make('../public/uploads/models/' . $image)
            ->resize($width/3 ,  $height/3 )
            ->save('../public/uploads/models/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
        }
        elseif($biggestSize > 3000 || $biggestSize > 3000){
            $manager
            ->make('../public/uploads/models/' . $image)
            ->resize($width/4 ,  $height/4 )
            ->save('../public/uploads/models/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
        }
        else{
            $manager
            ->make('../public/uploads/models/' . $image)
            ->save('../public/uploads/models/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
        }
    
    }

    
    public function resizeCatalogVbCarroussel($image, $width, $height)
    {
        ini_set ("memory_limit", " -1 ");
        $manager = new ImageManager();

        if($width > $height){
            $biggestSize = $width;
        }else{
            $biggestSize = $height;
        }

        if($biggestSize > 1500 && $biggestSize < 3000){
            $manager
                ->make('../public/uploads/modelsVb/' . $image)
                ->resize($width/3 ,  $height/3 )
                ->save('../public/uploads/modelsVb/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
            }
            elseif($biggestSize > 3000 || $biggestSize > 3000){
                $manager
                ->make('../public/uploads/modelsVb/' . $image)
                ->resize($width/4 ,  $height/4 )
                ->save('../public/uploads/modelsVb/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
            }
            
            else{
                $manager
                ->make('../public/uploads/modelsVb/' . $image)
                ->save('../public/uploads/modelsVb/' . pathinfo($image,PATHINFO_FILENAME) . '.' . pathinfo($image,PATHINFO_EXTENSION),75);
            }
    }
}