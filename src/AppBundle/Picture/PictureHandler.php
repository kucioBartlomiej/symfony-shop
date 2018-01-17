<?php

namespace AppBundle\Picture;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\File\FileManager;
use AppBundle\Entity\Picture;

class PictureHandler {
    
    private $manager;
    
    private $fileManager;

    /**
     * @var string
     */
    private $picturesUploadPath;
    
    public function __construct(string $picturesUploadPath, ObjectManager $manager, FileManager $fileManager) {
        $this->manager = $manager;
        $this->fileManager = $fileManager;
        $this->picturesUploadPath = $picturesUploadPath;
    }
    
    public function uploadPicture(Picture $picture)
    {
        $this->fileManager->upload($this->picturesUploadPath, $picture->getName(), $picture->getFile());
    }


    public function deletePicture(Picture $picture)
    {
        $this->fileManager->delete($this->picturesUploadPath, $picture->getName());
        $this->manager->remove($picture);
        $this->manager->flush();
    }
    
}
