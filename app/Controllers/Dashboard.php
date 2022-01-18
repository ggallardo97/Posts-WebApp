<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostsModel;
use App\Models\TagsModel;
use App\Models\CategoriesModel;
use App\Models\NewsLetterModel;
use App\Models\CommentsModel;

class Dashboard extends BaseController{

    protected $session;

    function __construct(){
        $this->session = \Config\Services::session();
        $this->session->start();
    }

	public function index(){

        $this->loadViews('index',$this->pagination());
        
	}

    public function pagination(){

        if(!$_GET){
            $_GET['page'] = 1;
        }

        $postsModel     = new PostsModel();
        $result         = $postsModel->findAll();
        $posts_Pages    = 6;
        $totalpostsDB   = count($result);
        $pages          = ceil($totalpostsDB/$posts_Pages);
        $begin          = ($_GET['page']-1) * $posts_Pages;

        $posts = $postsModel->select('*')
                            ->join('users', 'users.iduser = posts.author')
                            ->join('categories', 'categories.idcat = posts.category')
                            ->limit($posts_Pages,$begin)
                            ->find();
        
        $data['posts'] = $posts;
        $data['pages'] = $pages;

        return $data;
    }

    public function login(){

        helper(['url','form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'user'      => 'required',
            'password'  => 'required'
        ],[
            'user' =>[
                 'required' => 'User is required!'
            ],
            'password' =>[
                'required' => 'Password is required!'
            ]
        ]);

        if($_POST){

            if($validation->withRequest($this->request)->run()){

                $userModel  = new UserModel();
                $user       = $userModel->where('username',$_POST['user'])->findAll();

                if($user){

                    $passw = preg_replace('([^A-Za-z0-9])','',$_POST['password']);

                    if(password_verify($passw,$user[0]['passwordu'])){

                        $_SESSION['user']['username']   = $user[0]['username'];
                        $_SESSION['user']['iduser']     = $user[0]['iduser'];

                        $data['user'] = $user[0];
                        return redirect()->to(base_url());

                    }else{
                        echo "Something went wrong!";
                        $this->loadViews('login');
                    }

                }else{
                    echo 'Something went wrong!';
                    $this->loadViews('login');
                }

            }else{

                $errors = $validation->getErrors();
                print_r($errors);
                $data['error'] = $errors;
                $this->loadViews('login',$data);
            }
        }else{
            $this->loadViews('login');
        }
    }

    public function search(){

        if($_GET['s']){

            $postsModel = new PostsModel();

            $results = $postsModel->select('*')
                                  ->join('users', 'users.iduser = posts.author')
                                  ->join('categories', 'categories.idcat = posts.category')
                                  ->like('LOWER(title)',strtolower($_GET['s']))
                                  ->orLike('LOWER(intro)',strtolower($_GET['s']))
                                  ->orLike('LOWER(username)',strtolower($_GET['s']))
                                  ->find();

            $posts_Pages    = 6;
            $totalpostsDB   = count($results);
            $pages          = ceil($totalpostsDB / $posts_Pages);       
            $begin          = ($_GET['page'] - 1) * $posts_Pages;

            $posts = $postsModel->select('*')
                                ->join('users', 'users.iduser = posts.author')
                                ->join('categories', 'categories.idcat = posts.category')
                                ->like('LOWER(title)',strtolower($_GET['s']))
                                ->orLike('LOWER(intro)',strtolower($_GET['s']))
                                ->orLike('LOWER(username)',strtolower($_GET['s']))
                                ->limit($posts_Pages,$begin)
                                ->find();

            $data['posts'] = $posts;
            $data['pages'] = $pages;
                        
            $this->loadViews('results',$data);

        }
    }

    public function register(){

        helper(['url','form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username'  => 'required',
            'passwordu' => 'required',
            'mail'      => 'required'
        ],[
            'username' =>[
                 'required' => 'User is required!'
            ],
            'passwordu' =>[
                 'required' => 'Password is required!'
            ],
            'mail' =>[
                'required' => 'Email is required!'
            ]
        ]);

        if($_POST){

            if($validation->withRequest($this->request)->run()){

                $userModel = new UserModel();

                $_POST['passwordu'] = password_hash($_POST['passwordu'],PASSWORD_DEFAULT);

                $file = $this->request->getFile('image');

                if($file->isValid()){

                    $file->move(ROOTPATH.'public/assets/images/avatars/',$_POST['username'].'.jpg');

                    $dataU = [
                     	'username'  => $_POST['username'],
                     	'passwordu' => $_POST['passwordu'],
                     	'mail'      => $_POST['mail'],
                        'image'     => $_POST['username'].'.jpg'
                     ];

                    $userModel->insert($dataU);
                    $res = $userModel->where('username',$_POST['username'])->find();

                    $_SESSION['user']['username']   = $_POST['username'];
                    $_SESSION['user']['iduser']     = $res[0]['iduser'];

                    return redirect()->to(base_url());
                }
            }else{
                $errors = $validation->getErrors();
                print_r($errors);
                $data['error'] = $errors;
                $this->loadViews('register',$data);
            }
        }else{
            $this->loadViews('register');
        }
    }

    public function logout(){

        unset($_SESSION['user']);
        session_destroy();

        return redirect()->to('dashboard/login');
    }

    public function uploadPost(){

        $categories = new CategoriesModel();
        $postModel  = new PostsModel();
        $tagModel   = new TagsModel();

        helper(['url','form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title'     => 'required',
            'intro'     => 'required',
            'contentp'  => 'required|min_length[10]',
            'category'  => 'required',
        ],[
            'title' =>[
                 'required' => 'Title is required!'
            ],
            'intro' =>[
                'required' => 'Intro is required!'
            ],
            'contentp' =>[
                'required'   => 'Content is required!',
                'min_length' => 'Text must be 10 characters length at least!'
            ],
            'category' =>[
                'required' => 'Category is required!'
            ]
        ]);

        $data ['categories'] = $categories->findAll();

        if($_POST){

            if($validation->withRequest($this->request)->run()){

                $file       = $this->request->getFile('banner');
                $fileName   = $file->getRandomName();
    
                if($file->isValid()){
                    $file->move(ROOTPATH.'public/uploads',$fileName);

                    $dataPost = [
                        'banner'        => $fileName,
                        'title'         => $_POST['title'],
                        'intro'         => $_POST['intro'],
                        'contentp'      => $_POST['contentp'],
                        'category'      => $_POST['category'],
                        'created_at'    => date('Y-m-d'),
                        'author'        => $_SESSION['user']['iduser'],
                        'slug'          => url_title(($_POST['title']))
                    ];

                    $postModel->insert($dataPost);

                    $array = array('title' => $_POST['title'], 'author' => $_SESSION['user']['iduser']);

                    $res = $postModel->where($array)->find();

                    foreach ($_POST['tags'] as $tags){

                        $dataTag = [
                            'idpos'     => $res[0]['idpost'],
                            'nametag'   => $tags
                        ];
                        $tagModel->insert($dataTag);
                    }
                    return redirect()->to('dashboard/posts/'.$res[0]['slug'].'/'.$res[0]['idpost']);

                }else echo 'ERROR!';

            }else{
                $errors         = $validation->getErrors();
                $data['error']  = $errors;
            }
        }

        $this->loadViews('uploadPost',$data);
    }

    public function addNewsLetter(){

        if(isset($_POST['email'])){

            $newsLModel = new NewsLetterModel();
            $emails     = $newsLModel->where('email',$_POST['email'])->findAll();

            if(!$emails){

                $_POST['added_at'] = date('Y-m-d');
                $newsLModel->insert($_POST);
                echo 'Welcome to our NewsLetter!';

            }else{
                echo 'Email already exists!';
            }
        }else{
            echo 'Email is required!';
        }
    }

    public function posts($slug = null, $id = null){

        if($slug && $id){

            $commentsModel = new CommentsModel();

            $data['comments']       = $commentsModel->where('post',$id)->findAll();
            $data['countcomments']  = $commentsModel->where('post',$id)->countAllResults();

            if($_POST){
                
                helper(['url','form']);

                $validation = \Config\Services::validation();
                $validation->setRules([
                    'cname'     => 'required',
                    'cemail'    => 'required',
                    'cmessage'  => 'required'
                ],[
                    'cname' =>[
                         'required' => 'Name is required!'
                    ],
                    'cemail' =>[
                        'required' => 'Your email is required!'
                    ],
                    'cmessage' =>[
                        'required' => 'Message is required!',
                    ]
                ]);

                if($validation->withRequest($this->request)->run()){

                    $_POST['post']      = $id;
                    $_POST['added_m']   = date('Y-m-d');
                    
                    $commentsModel->insert($_POST);
                    return redirect()->to(current_url());

                }else{
                    $errors = $validation->getErrors();
                    print_r($errors);
                    $data['error'] = $errors;
                }
            }

            $postsModel = new PostsModel();

            $posts = $postsModel->select('*')
                                ->join('users', 'users.iduser = posts.author')
                                ->join('categories', 'categories.idcat = posts.category')
                                ->join('tags', 'tags.idpos = posts.idpost')
                                ->where('idpost',$id)
                                ->find();

            $data['posts'] = $posts;
            $this->loadViews('post',$data);
        }
    }

    public function category($id = null){

        $postsModel     = new PostsModel();
        $categoryModel  = new CategoriesModel();

        if(!$_GET){
            $_GET['page'] = 1;
        }

        $result = $postsModel->where('category',$id)
                             ->find();
        $cat_Pages  = 6;
        $totalcatDB = count($result);
        $pages      = ceil($totalcatDB / $cat_Pages);
        $begin      = ($_GET['page'] - 1) * $cat_Pages;

        $category = $categoryModel->select('*')
                                  ->where('idcat',$id)
                                  ->find();

        $data['category']   = $category;
        $data['posts']      = $postsModel->where('category',$id)
                                         ->limit($cat_Pages,$begin)
                                         ->find();
        $data['pages']      = $pages;

        $this->loadViews('category',$data);
    }

    public function loadViews($view = null, $data = null){

        if($data){

            echo view('includes/header',$data);
            echo view($view,$data);
            echo view('includes/footer',$data);
        }else{

            echo view('includes/header');
            echo view($view);
            echo view('includes/footer');
        }
    }
}
