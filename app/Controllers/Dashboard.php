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

    public function getPosts(){

        $postsModel    = new PostsModel();
        $posts         = $postsModel->findAll();

        return $posts;

    }

    public function getPostsByPage($posts_Pages, $begin){

        $postsModel = new PostsModel();
        $posts      = $postsModel->select('*')
                                 ->join('users', 'users.iduser = posts.author')
                                 ->join('categories', 'categories.idcat = posts.category')
                                 ->limit($posts_Pages,$begin)
                                 ->find();

        return $posts;
    }

    public function getTotalPosts(){

        $resultPosts    = $this->getPosts();
        $totalpostsDB   = count($resultPosts);

        return $totalpostsDB;

    }

    public function pagination(){

        if(!$_GET){
            $_GET['page'] = 1;
        }

        $posts_Pages    = 6;
        $totalpostsDB   = $this->getTotalPosts();
        $pages          = ceil($totalpostsDB/$posts_Pages);
        $begin          = ($_GET['page']-1) * $posts_Pages;
        $posts          = $this->getPostsByPage($posts_Pages,$begin);
        
        $data['posts'] = $posts;
        $data['pages'] = $pages;

        return $data;
    }

    public function getUser($username){

        $userModel  = new UserModel();
        $user       = $userModel->where('username',$username)
                                ->first();

        return $user;
    }

    public function verifyPassword($username,$password){

        $passw = preg_replace('([^A-Za-z0-9])','',$password);

        $user = $this->getUser($username);

        return (password_verify($passw,$user['passwordu']));

    }

    public function createUserSession($username){

        $user = $this->getUser($username);

        $_SESSION['user']['username']   = $user['username'];
        $_SESSION['user']['iduser']     = $user['iduser'];
        $_SESSION['user']['email']      = $user['mail'];

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

                $user = $this->getUser($_POST['user']);
                                        
                if($user){

                    if($this->verifyPassword($_POST['user'],$_POST['password'])){

                        $this->createUserSession($_POST['user']);
                        
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
                $data['error'] = $errors;
                $this->loadViews('login',$data);
            }
        }else{
            $this->loadViews('login');
        }
    }

    public function getTotalPostsbySearch($search){

        $postsModel = new PostsModel();
        $results    = $postsModel->join('users', 'users.iduser = posts.author')
                                 ->join('categories', 'categories.idcat = posts.category')
                                 ->like('LOWER(title)',strtolower($search))
                                 ->orLike('LOWER(intro)',strtolower($search))
                                 ->orLike('LOWER(username)',strtolower($search))
                                 ->find();
        return $results;

    }

    public function getPostsbySearch($search, $posts_Pages, $begin){

        $postsModel = new PostsModel();
        $posts      = $postsModel->join('users', 'users.iduser = posts.author')
                                 ->join('categories', 'categories.idcat = posts.category')
                                 ->like('LOWER(title)',strtolower($search))
                                 ->orLike('LOWER(intro)',strtolower($search))
                                 ->orLike('LOWER(username)',strtolower($search))
                                 ->limit($posts_Pages,$begin)
                                 ->find();
        return $posts;

    }

    public function search(){

        if($_GET['s']){

            $results = $this->getTotalPostsbySearch($_GET['s']);

            $posts_Pages    = 6;
            $totalpostsDB   = count($results);
            $pages          = ceil($totalpostsDB / $posts_Pages);       
            $begin          = ($_GET['page'] - 1) * $posts_Pages;

            $posts = $this->getPostsbySearch($_GET['s'],$posts_Pages,$begin);
 
            $data['posts'] = $posts;
            $data['pages'] = $pages;
                        
            $this->loadViews('results',$data);

        }
    }

    public function createUser($user,$password,$mail){

        $userModel      = new UserModel();
        $hashpassword   = password_hash($passwordu,PASSWORD_DEFAULT);
        $dataU          = [
            'username'  => $user,
            'passwordu' => $hashpassword,
            'mail'      => $mail,
            'image'     => $user.'.jpg'
        ];

        $userModel->insert($dataU);

    }

    public function register(){

        helper(['url','form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username'  => 'required',
            'passwordu' => 'required',
            'mail'      => 'required'
        ],[
            'username'  =>[
                 'required' => 'User is required!'
            ],
            'passwordu' =>[
                 'required' => 'Password is required!'
            ],
            'mail'      =>[
                'required'  => 'Email is required!'
            ]
        ]);

        if($_POST){

            if($validation->withRequest($this->request)->run()){

                $file = $this->request->getFile('image');

                if($file->isValid()){

                    $file->move(ROOTPATH.'public/assets/images/avatars/',$_POST['username'].'.jpg');

                    $this->createUser($_POST['username'],$_POST['passwordu'],$_POST['mail']);
                    
                    $this->createUserSession($_POST['username']);

                    return redirect()->to(base_url());
                }
            }else{

                $errors = $validation->getErrors();
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

    public function getCategories(){

        $categoriesModel    = new CategoriesModel();
        $categories         = $categoriesModel->findAll();

        return $categories;

    }

    public function createPost($banner,$title,$intro,$contentp,$category,$author){

        $postModel  = new PostsModel();
        $dataPost   = [
                'banner'        => $banner,
                'title'         => $title,
                'intro'         => $intro,
                'contentp'      => $contentp,
                'category'      => $category,
                'created_at'    => date('Y-m-d'),
                'author'        => $author,
                'slug'          => url_title($title)
        ];

        $postModel->insert($dataPost);

    }

    public function getPostByTitle($title,$author){

        $postModel      = new PostsModel();

        $arrayDataPost  = array('title' => $title, 
                               'author' => $author);

        $postResult     = $postModel->where($arrayDataPost)
                                    ->first();
        return $postResult;

    }

    public function insertTags($title,$author,$tagsPost){

        $tagModel   = new TagsModel();
        $res        = $this->getPostByTitle($title,$author);

        foreach ($tagsPost as $tags){

            $dataTag = [
                'idpos'     => $res['idpost'],
                'nametag'   => $tags
            ];
            $tagModel->insert($dataTag);
        }

    }

    public function uploadPost(){

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

        $data ['categories'] = $this->getCategories();

        if($_POST){

            if($validation->withRequest($this->request)->run()){

                $file       = $this->request->getFile('banner');
                $fileName   = $file->getRandomName();
    
                if($file->isValid()){

                    $file->move(ROOTPATH.'public/uploads',$fileName);

                    $this->createPost($fileName,$_POST['title'],$_POST['intro'],$_POST['contentp'],$_POST['category'],$_SESSION['user']['iduser']);

                    $this->insertTags($_POST['title'],$_SESSION['user']['iduser']);

                    $res = $this->getPostByTitle($_POST['title'],$_SESSION['user']['iduser']);

                    return redirect()->to('dashboard/posts/'.$res['slug'].'/'.$res['idpost']);

                }else echo 'ERROR!';

            }else{
                $errors         = $validation->getErrors();
                $data['error']  = $errors;
            }
        }

        $this->loadViews('uploadPost',$data);
    }

    public function getEmail($email){

        $newsLModel     = new NewsLetterModel();
        $emailRes       = $newsLModel->where('email',$email)
                                     ->first();

        return $emailRes;
    }

    public function insertEmail($email){

        $newsLModel     = new NewsLetterModel();
        $dataEmail      = [
            'email'      => $email,
            'added_at'   => date('Y-m-d')
        ];

        $newsLModel->insert($dataEmail);

    }

    public function addNewsLetter(){

        if(isset($_POST['email'])){

            $email = $this->getEmail($_POST['email']);

            if(!$email){

                $this->insertEmail($_POST['email']);
                echo 'Welcome to our NewsLetter!';

            }else{
                echo 'Email already exists!';
            }
        }else{
            echo 'Email is required!';
        }
    }

    public function getComments($id){

        $commentsModel  = new CommentsModel();

        $comments       = $commentsModel->where('post',$id)
                                        ->findAll();

        return $comments;
    }

    public function countComments($id){

        $resultComments  = $this->getComments($id);
        $totalComments   = count($resultComments);

        return $totalComments;

    }

    public function insertComment($id, $name, $email, $message){

        $commentsModel = new CommentsModel();
        $dataComment   = [
            'post'      => $id,
            'cname'     => $name,
            'cemail'    => $email,
            'cmessage'  => $message,
            'added_m'   => date('Y-m-d')
        ];

        $commentsModel->insert($dataComment);
    }

    public function getPostById($id){

        $postsModel = new PostsModel();

        $post       = $postsModel->select('*')
                                 ->join('users',      'users.iduser = posts.author')
                                 ->join('categories', 'categories.idcat = posts.category')
                                 ->join('tags',       'tags.idpos = posts.idpost')
                                 ->where('idpost',$id)
                                 ->find();

        return $post;
    }

    public function posts($slug = null, $id = null){

        if($slug && $id){

            $data['comments']       = $this->getComments($id);
            $data['countcomments']  = $this->countComments($id);

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

                    $this->insertComment($id,$_POST['cname'],$_POST['cemail'],$_POST['cmessage']);

                    return redirect()->to(current_url());

                }else{

                    $errors = $validation->getErrors();
                    $data['error'] = $errors;
                }
            }

            $post = $this->getPostById($id);

            $data['posts'] = $post;
            $this->loadViews('post',$data);
        }
    }

    public function getPostByCategory($category){

        $postsModel = new PostsModel();

        $posts      = $postsModel->where('category',$category)
                                 ->find();

        return $posts;
    }

    public function getCategory($idCategory){

        $categoryModel  = new CategoriesModel();

        $category       = $categoryModel->where('idcat',$idCategory)
                                        ->first();

        return $category;
    }

    public function getPostByCategoryWithLimit($id,$cat_Pages,$begin){

        $postsModel     = new PostsModel();

        $result         = $postsModel->where('category',$id)
                                     ->limit($cat_Pages,$begin)
                                     ->find();

        return $result;

    }

    public function category($id = null){

        if(!$_GET){
            $_GET['page'] = 1;
        }

        $result     = $this->getPostByCategory($id);
        $cat_Pages  = 6;
        $totalcatDB = count($result);
        $pages      = ceil($totalcatDB / $cat_Pages);
        $begin      = ($_GET['page'] - 1) * $cat_Pages;


        $data['category']   = $this->getCategory($id);
        $data['posts']      = $this->getPostByCategoryWithLimit($id,$cat_Pages,$begin);
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
