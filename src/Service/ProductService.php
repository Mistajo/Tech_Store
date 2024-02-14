<?php



namespace App\Service;



use App\Entity\Image;

use App\Entity\Product;

use App\Repository\ProductRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;



class ProductService

{

    private $entityManager;

    private $productRepository;

    private $targetDirectory;

    private $thumbnailDirectory;

    private $thumbnailWidth;

    private $thumbnailHeight;

    private $allowedImageTypes = [

        'image/jpeg',

        'image/png',

        'image/gif',

        'image/webp',

    ];



    public function __construct(

        EntityManagerInterface $entityManager,

        ProductRepository $productRepository,

        string $targetDirectory,

        string $thumbnailDirectory,

        int $thumbnailWidth = 300,

        int $thumbnailHeight = 300

    ) {

        $this->entityManager = $entityManager;

        $this->productRepository = $productRepository;

        $this->targetDirectory = $targetDirectory;

        $this->thumbnailDirectory = $thumbnailDirectory;

        $this->thumbnailWidth = $thumbnailWidth;

        $this->thumbnailHeight = $thumbnailHeight;
    }



    public function uploadImages(array $files): array

    {

        $imageNames = [];



        foreach ($files as $file) {

            $imageName = md5(uniqid()) . '.' . $file->guessExtension();



            if (!in_array($file->getMimeType(), $this->allowedImageTypes)) {

                throw new FileException('Invalid image type: ' . $file->getMimeType());
            }



            try {

                $file->move($this->targetDirectory, $imageName);

                $imageNames[] = $imageName;
            } catch (FileException $e) {

                throw new FileException($e->getMessage());
            }
        }



        return $imageNames;
    }



    public function createThumbnail(string $imageName): void
    {
        $imagePath = $this->targetDirectory . '/' . $imageName;
        $thumbnailPath = $this->thumbnailDirectory . '/' . $imageName;

        if (!file_exists($imagePath)) {
            throw new FileException('L\'image ' . $imageName . ' n\'existe pas.');
        }

        if (file_exists($thumbnailPath)) {
            return;
        }

        $imageInfo = getimagesize($imagePath);
        $imageType = $imageInfo[2];

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($imagePath);
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($imagePath);
                break;
            default:
                throw new FileException('Unsupported image type: ' . $imageType);
        }

        $thumbnail = imagescale($image, $this->thumbnailWidth, $this->thumbnailHeight);
        imagejpeg($thumbnail, $thumbnailPath);
    }



    public function createImage(string $imageName): Image

    {

        $image = new Image();

        $image->setName($imageName);

        // add other image properties, if necessary



        return $image;
    }



    public function create(Product $product, array $imageNames): void

    {

        foreach ($imageNames as $imageName) {

            $image = $this->createImage($imageName);

            $product->addImage($image);
        }



        $this->entityManager->persist($product);

        $this->entityManager->flush();
    }



    // public function read(int $id): Product

    // {

    //     $product = $this->productRepository->find($id);

    //

    //     if (!$product) {

    //         throw $this->createNotFoundException('Product #' . $id . ' does not exist');

    //     }

    //

    //     return $product;

    // }



    public function update(Product $product, array $imageNames, string $name, float $price): void

    {

        $product->setName($name);
        $product->setPrice($price);

        foreach ($imageNames as $imageName) {

            $image = new Image();

            $image->setName($imageName);

            $product->addImage($image);
        }



        $this->entityManager->flush();
    }



    public function delete(Product $product): void

    {

        $imageNames = $product->getImages();



        foreach ($imageNames as $imageName) {

            $imagePath = $this->targetDirectory . '/' . $imageName;

            $thumbnailPath = $this->thumbnailDirectory . '/' . $imageName;



            if (file_exists($imagePath)) {

                unlink($imagePath);
            }



            if (file_exists($thumbnailPath)) {

                unlink($thumbnailPath);
            }
        }



        $this->entityManager->remove($product);

        $this->entityManager->flush();
    }



    public function getProductImagePath(string $imageName): string

    {

        return $this->targetDirectory . '/' . $imageName;
    }



    public function getProductThumbnailPath(string $imageName): string

    {

        return $this->thumbnailDirectory . '/' . $imageName;
    }
}
