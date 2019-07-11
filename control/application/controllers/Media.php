<?php
/**
 * Media Class
 * 
 * This class manages all Medias functions
 */
class Media extends CI_Controller
{

        /**
         * Class constructor
         * 
         * loads form and url helpers
         * loads the media model class
         * loads the pagination and session library
         *  
         */
        public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->model('media_model');
            $this->load->library(array('session','pagination'));
            //verify user is logged in
            if($this->session->logged_in != true)
            {
                $current_url = current_url();
                header('location:'.base_url.'index.php/users/login?re_direct='.$current_url);
            }
        }

        //-----------------------------------------------------------------------------------

        /** 
         * Class index
         * 
         * initial page to load when the class gallery is called
         * 
         * gets all files from the database
         * 
        */
        public function index()
        {
            $this->display();
        }

        //--------------------------------------------------------------------------------------------

        /**
         * Method to limit user page access by roles
         * 
         * @param   array   $array of allowed roles
         * 
         * 
         */
        public function allowed_user($array)
        {
            //checks if logged in user role is is in $array
            if(!in_array($this->session->role, $array))
            {
                //if not in array show a page_restrict page instead
                $this->load->view('users/page_restrict');
            }
        }

        //----------------------------------------------------------------------------------

        public function add_new()
        {
        
              $data['title'] = 'Add New Media';
              $data['page'] = 'add_new';
              $this->load->view('template/header', $data);
              $this->load->view('media/add_new');
              $this->load->view('template/footer');
        }
        //--------------------------------------------------------------------------------------------

        /**
         * method to display all media by default or by type
         * sets up pagination
         * @param string $type of media to display
         * accepts a posted search string sent to database to fiter query
         * 
         */
        
        
        public function display($type = 'all_media')
        {
                 //configure the pagination
                $config = array();
                $config['base_url'] = base_url.'index.php/Media/display/'.$type;  //set the base url
                $config['total_rows'] = $this->media_model->count_media($type, $this->input->post('search_key'));  //get total number of registered users
                $config["per_page"] = 18; //display number of media per page
                $config['uri_segment'] = 4; //uri segment to be used for pagination(parameter)
                $choice = $config['total_rows'] / $config['per_page'];
                $config['num_links'] = round($choice); //number of pagination links to display
                $config['full_tag_open'] = '<div class="pagination_body col-12">';
                $config['full_tag_close'] = '</div>';
                $config['next_tag_open'] = '<span class="next_link">';
                $config['next_link'] = 'Next';
                $config['next_tag_close'] = '</span>';
                $config['prev_tag_open'] = '<span class="prev_link">';
                $config['prev_link'] = 'Prev';
                $config['prev_tag_close'] = '</span>';
                $config['num_tag_open'] = '<span class="pagination_links">';
                $config['num_tag_close'] = '</span>';
                $config['cur_tag_open'] = '<span class="curr_pagination_link">';
                $config['cur_tag_close'] = '</span>';
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0; //set current page to uri segment(3) if exist or initialize to 0

                $data['links'] = $this->pagination->create_links(); //variable to hold page links
                $data['files'] = $this->media_model->get_files($config['per_page'], $page, $type, $this->input->post('search_key'));
                $data['search_key'] = $this->input->post('search_key');
                $data['title'] = 'Media ('.$type.')';
                $data['page'] = 'all_media';
                $data['category'] = $type;
                $this->load->view('template/header', $data);
                $this->load->view('media/all_media');
                $this->load->view('template/footer');
        
        }

        //-----------------------------------------------------------------------------------------------------------------------------------

        /** 
         * Method to upload media to database
         * 
         * loads library 'uploads' to handle all downloads
         * 
         * uploads user files from an ajax post('userfile')
         * 
        */
        public function do_upload()
        {
            //Upload configuration and setting
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jpg|jpeg|png|mp4|doc|docx|avi|xls|zip|mp3|rar|pdf|js';
            $config['max_size']             = 0;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['max_filename']         = 0;

            //load the upload library with the configuration passes
            $this->load->library('upload', $config);

                //try uploading file, if error display error msg to user
                if ( ! $this->upload->do_upload('userfile'))
                {
                    $data['title'] = 'Upload error!';
                    $data['error'] = array('error' => $this->upload->display_errors());
                    $this->load->view('media/upload_info', $data);
                }

                //if upload success, process the file and store data in database
                else
                {
                    
                    $data = array('upload_data' => $this->upload->data()); //array of uploaded file data

                    //extention list for category
                    $video_ext = array(
                        '.mp4','.MP4',
                        '.avi','.AVI'
                    );
                    $audio_ext = array(
                        '.mp3','.MP3'
                    );
                    $image_ext = array(
                        '.jpg','.JPG',
                        '.jpeg','.JPEG',
                        '.png','.PNG'
                    );
                    
                    //categirize file into type based on extention
                    foreach($data as $details)
                    {
                        if(in_array($details['file_ext'], $video_ext))
                        {
                            $type = 'videos';
                        }
                        elseif(in_array($details['file_ext'], $audio_ext))
                        {
                            $type = 'audios';
                        }
                        elseif(in_array($details['file_ext'], $image_ext))
                        {
                            $type = 'images';
                        }
                        else
                        {
                            $type = 'files';
                        }
                    }

                    //add $type variable to the file data before storing in database
                    $data['upload_data']['type'] = $type;

                    //call a method to further process the file based on the type
                    //returns an array of well formatted file data for database storage 
                    if ($type == 'images')
                    { 
                        $file_infos = $this->process_images($data);
                    }
                    elseif($type == 'audios')
                    { 
                        $file_infos = $this->process_audios($data);
                    }
                    elseif($type == 'videos')
                    {
                        $file_infos = $this->process_videos($data);
                    }
                    elseif($type == 'files')
                    {
                        $file_infos = $this->process_files($data);
                    }

                    //send array of returned data to database method
                    $this->media_model->store_upload_details($file_infos);

                    $data['error'] = "";
                    $data['title'] = 'Upload Success!';
                    $this->load->view('media/upload_info', $data);
                }
        }

        //--------------------------------------------------------------------------------------------------------------

        /**
         * Method to further process image type
         * @param array $data of file
         */
        public function process_images($data)
        {
            //configuration for image library thumb 
            $thumbconfig['image_library'] = 'gd2';
            $thumbconfig['source_image'] = './uploads/'.$data['upload_data']['file_name'];
            $thumbconfig['new_image'] = './uploads/thumbs';
            $thumbconfig['thumb_marker'] = '';
            $thumbconfig['create_thumb'] = TRUE;
            $thumbconfig['maintain_ratio'] = TRUE;
            $thumbconfig['width']         = 200;
            $thumbconfig['height']       = 200;

            //load image library to create image thumb
            $this->load->library('image_lib', $thumbconfig);

            if ( ! $this->image_lib->resize())
            {
                echo $this->image_lib->display_errors();
            }

            foreach($data as $details)
            {

                //define upload path for files
                $path = base_url.'uploads/'.$details['file_name'];
                $thumb_path = base_url.'uploads/thumbs/'.$details['file_name'];
                
                //insert data into database
                $info = array(
                    'user_id' => 0,
                    'name' => $details['raw_name'],
                    'path' => $path,
                    'thumb_path' => $thumb_path,
                    'type' => $details['type'],
                    'extention' => $details['file_ext'],
                    'size' => $details['file_size'],
                    'width' => $details['image_width'],
                    'height' => $details['image_height']
                );
            }
            return $info;
        }

        //------------------------------------------------------------------------------------------

        /**
         * Method to further process audio type
         * @param array $data of file
         */
        public function process_audios($data)
        {
            foreach($data as $details)
            {

                //define upload path for files
                $path = base_url.'uploads/'.$details['file_name'];
                $thumb_path = base_url.'images/file_icons/'.substr($details['file_ext'], 1).'.png';
                
                //insert data into database
                $info = array(
                    'user_id' => 0,
                    'name' => $details['raw_name'],
                    'path' => $path,
                    'thumb_path' => $thumb_path,
                    'type' => $details['type'],
                    'extention' => $details['file_ext'],
                    'size' => $details['file_size'],
                );
            }
            return $info;
        }

        //------------------------------------------------------------------------------------------

        /**
         * Method to further process video type
         * @param array $data of file
         */
        public function process_videos($data)
        {
            foreach($data as $details)
            {

                //define upload path for files
                $path = base_url.'uploads/'.$details['file_name'];
                $thumb_path = base_url.'images/file_icons/'.substr($details['file_ext'], 1).'.png';
                
                //insert data into database
                $info = array(
                    'user_id' => 0,
                    'name' => $details['raw_name'],
                    'path' => $path,
                    'thumb_path' => $thumb_path,
                    'type' => $details['type'],
                    'extention' => $details['file_ext'],
                    'size' => $details['file_size'],
                );
            }
            return $info;
        }

        //------------------------------------------------------------------------------------------

        /**
         * Method to further process file types
         * @param array $data of file
         */
        public function process_files($data)
        {
            foreach($data as $details)
            {

                //define upload path for files
                $path = base_url.'uploads/'.$details['file_name'];
                $thumb_path = base_url.'images/file_icons/'.substr($details['file_ext'], 1).'.png';
                
                //insert data into database
                $info = array(
                    'user_id' => 0,
                    'name' => $details['raw_name'],
                    'path' => $path,
                    'thumb_path' => $thumb_path,
                    'type' => $details['type'],
                    'extention' => $details['file_ext'],
                    'size' => $details['file_size'],
                );
            }
            return $info;
        }

        //------------------------------------------------------------------------------------------

        /**
         * Method to delete medias
         * media ids and full file name are posted via  ajax
         */
        public function delete_media()
        {
            //verify if any id has been posted
            if(!empty($this->input->post('id')))
            {
                //delete the media from database record using the media id
                $remove = $this->media_model->delete_image($this->input->post('id'));

                //delete file from server
                $file_directory = $this->input->post('directory');
                unlink('./uploads/'.$file_directory);
                unlink('./uploads/thumbs/'.$file_directory);
            }
        }

        //------------------------------------------------------------------------------------------

        /**
         * Method to allow picking media file for specified purpose
         * @param string $type of file to be picked
         */
        public function media_picker($type)
        {
                 //configure the pagination
                 $config = array();
                 $config['base_url'] = base_url.'index.php/Media/media_picker/'.$type;  //set the base url
                 $config['total_rows'] = $this->media_model->count_media($type, $this->input->post('search_key'));  //get total number of registered users
                 $config["per_page"] = 18; //display number of media per page
                 $config['uri_segment'] = 4; //uri segment to be used for pagination(parameter)
                 $choice = $config['total_rows'] / $config['per_page'];
                 $config['num_links'] = round($choice); //number of pagination links to display
                 $config['full_tag_open'] = '<div class="pagination_body media_pick_pagination col-12">';
                 $config['full_tag_close'] = '</div>';
                 $config['next_tag_open'] = '<span class="next_link">';
                 $config['next_link'] = 'Next';
                 $config['next_tag_close'] = '</span>';
                 $config['prev_tag_open'] = '<span class="prev_link">';
                 $config['prev_link'] = 'Prev';
                 $config['prev_tag_close'] = '</span>';
                 $config['num_tag_open'] = '<span class="pagination_links">';
                 $config['num_tag_close'] = '</span>';
                 $config['cur_tag_open'] = '<span class="curr_pagination_link">';
                 $config['cur_tag_close'] = '</span>';
                 $this->pagination->initialize($config);
                 $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0; //set current page to uri segment(3) if exist or initialize to 0
 
                 $data['links'] = $this->pagination->create_links();
                 $data['files'] = $this->media_model->get_files($config['per_page'], $page, $type, $this->input->post('search_key'));
                 $data['search_key'] = $this->input->post('search_key');
                 $data['title'] = 'Media ('.$type.')';
                 $data['page'] = 'Media Picker';
                 $data['category'] = $type; 
                 $this->load->view('media/media_picker', $data);  
        }

        //-------------------------------------------------------------------------------------------------------------------------------------------
}
