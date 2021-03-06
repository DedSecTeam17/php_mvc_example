<?php


/**
 * Class PhoneBookImagesController
 */
class PhoneBookImagesController
    extends Controller
{
    /**
     * PhoneBookImagesController constructor.
     * give it the model related to this controller
     * you can assign middleware on top of this controller for redirection purpose
  */
    public function __construct()
    {
        Parent::__construct('PhoneBookImages');
        $this->middleWare('Auth');

    }


    /**
     * @return mixed
     * get all images related to contact
     */
    public function index()
    {

        $phone_book_id = $this->getGetRequestData('id');
        $images = new PhoneBookImages();

        $data = $images->select(['*'], null)->where([array("phone_book_id", "=", $phone_book_id)])->
        orderBy('id', 'desc')->getAll();


        return $this->view->render('phone_book_images.index', [
            "id" => $phone_book_id,
            "images" => $data
        ]);
    }


    /**
     * @return mixed
     * render create new contact image page
     */
    public function create()
    {

        return $this->view->render('phone_book_images.create');
    }


    /**
     *save images to public folder withing img/contacts_images
     * use image uri and save it into DB then redirect to index page
     */
    public function store()
    {

        $phone_book_id = $this->getPostRequestData('id');
        $image = new PhoneBookImages();

        $UploadedFileName = $_FILES['image']['name'];


        if ($UploadedFileName != '') {
            echo " found ";
            $upload_directory = "public/img/contacts_images/"; //This is the folder which you created just now
            $TargetPath = time() . $UploadedFileName;
            $up = move_uploaded_file($_FILES['image']['tmp_name'], $upload_directory . $TargetPath);
            if ($up) {
//                echo "uploaded ";
                $image->columns['image_url'] = $TargetPath;
            } else {
//                echo "not uploaded ";
            }
        } else {

            echo "not found ";
        }
        $image->columns['phone_book_id'] = $phone_book_id;
        $image->insert();
        $images = new PhoneBookImages();










        return Route::redirectToWithPrams(
            Route::to('index', 'PhoneBookImagesController', null, false) , $phone_book_id);




//

    }


    /**
     * @param $id
     * delete image related to contact by it id and from public folder and DB then redirect to index page
     */
    public function delete($id)
    {
        $phone_book_id = $this->getGetRequestData('contact_id');

        $image = new PhoneBookImages();

        $selectedImages = $image->find($id);

        unlink("public/img/contacts_images/" . $selectedImages->image_url);
        // get related images

        $image->delete()->where([array("id", "=", $id)])->execute();

//        $data = $image->select(['*'], null)->where([array("phone_book_id", "=", $phone_book_id)])->
//        orderBy('id', 'desc')->getAll();
//
//        return $this->view->render('phone_book_images.index', [
//            "id" => $phone_book_id,
//            "images" => $data
//        ]);


        return Route::redirectToWithPrams(
            Route::to('index', 'PhoneBookImagesController', null, false) , $phone_book_id);


    }


}