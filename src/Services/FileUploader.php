<?php
namespace App\Services;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader{

    private $targetDirectory;
    private $slugger;
    public function __construct($targetDirectory, SluggerInterface $slugger){

        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function Upload(UploadedFile $file){
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
        
    }
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}