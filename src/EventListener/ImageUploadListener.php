<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Image;
use App\Service\FileUploader;

class ImageUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        
        
        $entity = $args->getEntity();
        // var_dump(method_exists($entity,getImage()));     
        if (!$entity instanceof Image) {

            if(method_exists($entity,'getImage'))
                $entity = $entity->getImage();
        }
        // echo '<pre>';
        // // var_dump($entity instanceof Image);
        // var_dump($entity);
        // echo '</pre>';
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        
        $entity = $args->getEntity();

         if (!$entity instanceof Image) {

            if(method_exists($entity,'getImage'))
                $entity = $entity->getImage();
        }

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if(!$entity instanceof Image)
        {
            return;
        }
        $file = $entity->getFilename();    

        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            // $entity->setPath($this->uploader->getTargetDirectory() + $fileName);
            // var_dump($this->uploader->getTargetDirectory());
            $entity->setFilename($fileName);
        } elseif ($file instanceof File) {
            // prevents the full file path being saved on updates
            // as the path is set on the postLoad listener
            $entity->setFilename($file->getFilename());
            
        }
        
        if ($fileName = $entity->getFilename()) {
            $entity->setPath("uploads/Thumbnail/".$fileName);
        }
        
    }
    // public function postLoad(LifecycleEventArgs $args)
    // {
    //     $entity = $args->getEntity();

    //     if (!$entity instanceof Product) {
    //         return;
    //     }

    //     if ($fileName = $entity->getFilename()) {
    //         $entity->setPath(new File($this->uploader->getTargetDirectory().'/'.$fileName));
    //     }
    // }
}