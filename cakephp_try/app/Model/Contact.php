<?php
    class Contact extends AppModel {
        public $name = 'Contact';
        
        public $validate = array(
            
            //-------------------------------vaildation checking for filename starts here-------------------------------------
            
            'filename' => array(
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::uploadError
			'uploadError' => array(
				'rule' => 'uploadError',
				'message' => 'Something went wrong with the file upload',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
                
               
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::mimeType
//			'mimeType' => array(
//                        'rule' => array('mimeType',array('image/gif','image/png','image/jpeg')),
//                        'message' => 'Please only upload images (gif, png, jpg).',
//                        'alllowEmpty' => true
//                    ),
			// custom callback to deal with the file upload
			'processUpload' => array(
				'rule' => 'processUpload',      //used to call a function below named processUpload
				'message' => 'Something went wrong processing your file',
				'required' => FALSE,
				'allowEmpty' => TRUE,
				'last' => TRUE,
			)
		),
            
            //-------------------------------vaildation checking for filename ends here-------------------------------------
            
            //-------------------------------vaildation checking for filename2 starts here-------------------------------------
            
            'filename2' => array(
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::uploadError
			'uploadError' => array(
				'rule' => 'uploadError',
				'message' => 'Something went wrong with the file upload',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
                
               
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::mimeType
//			'mimeType' => array(
//                        'rule' => array('mimeType',array('image/gif','image/png','image/jpeg')),
//                        'message' => 'Please only upload images (gif, png, jpg).',
//                        'alllowEmpty' => true
//                    ),
			// custom callback to deal with the file upload
			'processUpload' => array(
				'rule' => 'processUpload2',      //used to call a function below named processUpload
				'message' => 'Something went wrong processing your file',
				'required' => FALSE,
				'allowEmpty' => TRUE,
				'last' => TRUE,
			)
		)
            
            //-------------------------------vaildation checking for filename2 ends here-------------------------------------
            
            );
        
        /**
        * Upload Directory relative to WWW_ROOT
        * @param string
        */
       public $uploadDir = 'uploads';       //define directory where to upload files

       /**
        * Process the Upload
        * @param array $check
        * @return boolean
        * This function is manadatory as it is a function of uploading file
        */
       
//-------------------------------------------------code for uploading first file starts here---------------------------------------------
       
       public function processUpload($check=array()) {
               // deal with uploaded file
               if (!empty($check['filename']['tmp_name'])) {        //filename is a name of text box its full name is data[Contact][filename]
                   
                    $ext = substr(strtolower(strrchr($check['filename']['name'], '.')), 1);     //get the extension
                    
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

                    if (in_array($ext, $arr_ext)) {
                       //upload code
                    
                        // check file is uploaded
                        if (!is_uploaded_file($check['filename']['tmp_name'])) {
                                return FALSE;
                        }

                        // build full filename
                        $check['filename']['name'] = time().".".$ext;           // to change the name of file with current date and time
//                        pr($filename);
//                        die();
                        $filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($check['filename']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);

                        // @todo check for duplicate filename

                        // try moving file
                        if (!move_uploaded_file($check['filename']['tmp_name'], $filename)) {
                                return FALSE;

                        // file successfully uploaded
                        } else {
                                // save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
                                $this->data[$this->alias]['filepath'] = str_replace(DS, "/", str_replace(WWW_ROOT, "", $filename) );        //to set file path for filename2 to insert it into database
                                
                        }
                    }
                     else
                    {
                       return 'Please only upload images (gif, png, jpg).';
                    }
               }
               
               return TRUE;
       }
       
       //-------------------------------------------------code for uploading first file ends here---------------------------------------------
       
       //-------------------------------------------------code for uploading second file starts here---------------------------------------------
                public function processUpload2($check=array()) {
               
                    if (!empty($check['filename2']['tmp_name'])) {        //filename is a name of text box its full name is data[Contact][filename]
                   
                        $ext = substr(strtolower(strrchr($check['filename2']['name'], '.')), 1);     //get the extension

                        $arr_ext = array('pdf'); //set allowed extensions

                        if (in_array($ext, $arr_ext)) {
                           //upload code

                            // check file is uploaded
                            if (!is_uploaded_file($check['filename2']['tmp_name'])) {
                                    return FALSE;
                            }

                            // build full filename
                            $check['filename2']['name'] = time().".".$ext;           // to change the name of file with current date and time
    //                        pr($filename);
    //                        die();
                            $filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($check['filename2']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename2']['name'], PATHINFO_EXTENSION);

                            // @todo check for duplicate filename

                            // try moving file
                            if (!move_uploaded_file($check['filename2']['tmp_name'], $filename)) {
                                    return FALSE;

                            // file successfully uploaded
                            } else {
                                    // save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
                                    $this->data[$this->alias]['filepath2'] = str_replace(DS, "/", str_replace(WWW_ROOT, "", $filename) );       //to set file path for filename2 to insert it into database
                                    
                            }
                        }
                         else
                        {
                           return 'Please only upload images (pdf file).';
                        }
                   }
                   return TRUE;
                }
               
               
               //-------------------------------------------------code for uploading second file ends here---------------------------------------------

       /**
        * Before Save Callback
        * @param array $options
        * @return boolean
        */
       public function beforeSave($options = array()) {
               // a file has been uploaded so grab the filepath
               if (!empty($this->data[$this->alias]['filepath'])) {
                       $this->data[$this->alias]['filename'] = $this->data[$this->alias]['filepath'];       //to set data for filename to insert it into database
               }
               if (!empty($this->data[$this->alias]['filepath2'])) {
                       $this->data[$this->alias]['filename2'] = $this->data[$this->alias]['filepath2'];     //to set data for filename2 to insert it into database
               }

               return parent::beforeSave($options);
       }
       
       /**
        * Before Validation
        * @param array $options
        * @return boolean
        */
       public function beforeValidate($options = array()) {
               // ignore empty file - causes issues with form validation when file is empty and optional
               if (!empty($this->data[$this->alias]['filename']['error']) && $this->data[$this->alias]['filename']['error']==4 && $this->data[$this->alias]['filename']['size']==0) {
                       unset($this->data[$this->alias]['filename']);
               }

               parent::beforeValidate($options);
       }
    }
?>