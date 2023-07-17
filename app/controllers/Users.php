<?php 
class Users extends Controller{
    public function __construct(){
     $this->userModel = $this->model('User'); 
    }

    public function register(){
        //check for POST
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //process form

            //sanitize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            //init data
          $data =[
            'name' =>trim($_POST['name']),
            'email' =>trim($_POST['email']),
            'password' =>trim($_POST['password']),
            'confirm_password' =>trim($_POST['confirm_password']),
            'name_err' =>'',
            'email_err' =>'',
            'password_err' =>'',
            'confirm_password_err' =>'',
          ];

          
        //validate email
        if(empty($data['email'])){
            $data['email_err']='Please enter email';
        } else{
            //Check email
            if($this->userModel->findUserByEmail($data['email'])){
                $data['email_err']='Email is already taken';
            }
        }

        //validate name
        if(empty($data['name'])){
            $data['name_err']='Please enter name';
        }

           //validate password
           if(empty($data['password'])){
            $data['password_err']='Please enter password';
        } elseif(strlen($data['password'])<6){
            $data['password_err']='Password must at least be 6 characters';
        }

         //validate confirmpassword
         if(empty($data['confirm_password'])){
            $data['confirm_password_err']='Please confirm password';
        } else{
            if($data['password'] !=$data['confirm_password']){
                $data['confirm_password_err'] = 'Passwords do not match';
            }
        }

        //make sure errors are empty
        if(empty($data['email_err']) && empty($data['name_err'])&& empty($data['password_err']) && empty($data['confirm_password_err'])){
            //validated
            die('SUCCESS');
        } else{
            //load view with errors
            $this->view('users/register',$data);
        }

    }

        else{
            //init data
          $data =[
            'name' =>'',
            'email' =>'',
            'password' =>'',
            'confirm_password' =>'',
            'name_err' =>'',
            'email_err' =>'',
            'password_err' =>'',
            'confirm_password_err' =>'',
          ];

          //load view
          $this->view('users/register',$data);
          }
        }

        public function login(){
            //check for POST
            if($_SERVER['REQUEST_METHOD']=='POST'){
                //process form

            //sanitize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            //init data
            $data =[
                'email' =>trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'email_err' =>'',
                'password_err' =>'',
            ];

             //validate email
                if(empty($data['email'])){
                    $data['email_err']='Please enter email';
                }

            //validate email
                if(empty($data['password'])){
                    $data['password_err']='Please enter password';
                }
            
            //make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])){
            //validated
            
            
            // Hash password
            $data['password']= password_hash($data['password'], PASSWORD_DEFAULT);

            //register user
            if($this->userModel->register($data)){
                
            }else{
                die('Something went wrong');
            }

                } else{
            //load view with errors
                    $this->view('users/login',$data);
                }



            }else{
                //init data
              $data =[
                
                'email' =>'',
                'password' =>'',
                'email_err' =>'',
                'password_err' =>'',
                
              ];
    
              //load view
              $this->view('users/login',$data);
              }
            }
     
        
    }
