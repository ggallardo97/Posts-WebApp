
    <!-- s-extra
    ================================================== -->
    <section class="s-extra">

        <div class="row">

            <div class="col-seven md-six tab-full popular">
                <h3>Popular Posts</h3>

                <div class="block-1-2 block-m-full popular__posts">

                <?php 
                    $db = \Config\Database::connect();
                    $query = $db->query('select * from POSTS inner join USERS on POSTS.author=USERS.iduser limit 6');
                    $result = $query->getResult();

                    foreach($result as $r){
                ?>

                    <article class="col-block popular__post">
                        <a href="<?php echo base_url();?>/index.php/dashboard/posts/<?php echo $r->slug?>/<?php echo $r->idpost?>" class="popular__thumb">
                            <img src="<?php echo base_url();?>/public/uploads/<?php echo $r->banner?>" alt="">
                        </a>
                        <h5><?php echo $r->title?></h5>
                        <section class="popular__meta">
                            <span class="popular__author"><span>By</span> <a href="#0"><?php echo $r->username?></a></span>
                            <span class="popular__date"><span>on </span><?php echo date('d-m-Y',strtotime($r->created_at));?></span>
                        </section>
                    </article>

                <?php } ?>
                    
                </div> <!-- end popular_posts -->
            </div> <!-- end popular -->

            <div class="col-four md-six tab-full end">
                <div class="row">
                    <div class="col-six md-six mob-full categories">
                        <h3>Categories</h3>
                        <ul class="linklist">
                            
                    <?php 
                        $db = \Config\Database::connect();
                        $query = $db->query('select * from CATEGORIES');
                        $result = $query->getResult();

                        foreach($result as $r){
                    ?>
                        <li><a href="<?php echo base_url();?>/index.php/dashboard/category/<?php echo $r->idcat?>"><?php echo $r->namec ?></a></li>
                    <?php } ?>
                        </ul>
                    </div> <!-- end categories -->
        
                    <div class="col-six md-six mob-full sitelinks">
                        <h3>Site Links</h3>
        
                        <ul class="linklist">
                            <li><a href="<?php echo base_url();?>">Home</a></li>
                            <li> <?php
                                if(isset($_SESSION['user'])){
                                    echo "<a href='".base_url()."/index.php/dashboard/uploadPost'>New Blog</a>";
                                }else{ 
                                    echo "<a href='".base_url()."/index.php/dashboard/login'>New Blog</a>";
                                } ?> 
                            </li>
                        </ul>
                    </div> <!-- end sitelinks -->
                </div>
            </div>
        </div> <!-- end row -->

    </section> <!-- end s-extra -->


    <!-- s-footer
    ================================================== -->
    <footer class="s-footer">

        <div class="s-footer__main">
            <div class="row">
                
                <div class="col-six tab-full s-footer__about">
                        
                    <h4>About Wordsmith</h4>

                    <p>Fugiat quas eveniet voluptatem natus. Placeat error temporibus magnam sunt optio aliquam. Ut ut occaecati placeat at. 
                    Fuga fugit ea autem. Dignissimos voluptate repellat occaecati minima dignissimos mollitia consequatur.
                    Sit vel delectus amet officiis repudiandae est voluptatem. Tempora maxime provident nisi et fuga et enim exercitationem ipsam. Culpa error 
                    temporibus magnam est voluptatem.</p>

                </div> <!-- end s-footer__about -->

                <div class="col-six tab-full s-footer__subscribe">
                        
                    <h4>Our Newsletter</h4>

                    <p>Sit vel delectus amet officiis repudiandae est voluptatem. Tempora maxime provident nisi et fuga et enim exercitationem ipsam. Culpa consequatur occaecati.</p>

                     <div class="subscribe-form">
                        <form method="POST" id="newsletter-form" class="group" novalidate="true">

                            <input type="email" name="email" class="email" id="newsletter-email" placeholder="Email Address" required>
                
                            <input type="button" name="subscribe" id="sendNews" value="Send">
                
                            <label for="mc-email" class="subscribe-message"></label>
                
                        </form>
                    </div>

                </div> <!-- end s-footer__subscribe -->

            </div>
        </div> <!-- end s-footer__main -->

        <div class="s-footer__bottom">
            <div class="row">

                <div class="col-six">
                    <ul class="footer-social">
                        <li>
                            <a href="#0"><i class="fab fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#0"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#0"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#0"><i class="fab fa-youtube"></i></a>
                        </li>
                        <li>
                            <a href="#0"><i class="fab fa-pinterest"></i></a>
                        </li>
                    </ul>
                </div>

                <div class="col-six">
                    <div class="s-footer__copyright">
                        <span><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</span>
                    </div>
                </div>
                
            </div>
        </div> <!-- end s-footer__bottom -->

        <div class="go-top">
            <a class="smoothscroll" title="Back to Top" href="#top"></a>
        </div>

    </footer> <!-- end s-footer -->


    <!-- Java Script
    ================================================== -->
    <script src="<?php echo base_url();?>/public/assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>/public/assets/js/plugins.js"></script>
    <script src="<?php echo base_url();?>/public/assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sendNews').on('click',()=>{
                let emailinput = $('#newsletter-email').val();
                
                if(emailinput!=''){
                    $.post('<?php echo base_url();?>/index.php/dashboard/addNewsLetter',{
                        email:emailinput
                    }).done((data)=>{
                        console.log(data);
                        $('.subscribe-message').css('color','white');
                        $('.subscribe-message').html(data);

                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){

            const max_fields = 5;
            let x = 1;
            
            $('#removeTag').hide();

            $('#addTag').on('click',()=>{ 

                if(x<max_fields){
                    x++;
                    $('<input type="text" name="tags[]" placeholder="Tags">').insertBefore('#addTag');
                }

                if(x>1) $('#removeTag').show();
            });

            $('#removeTag').on('click',()=>{
                $('#addTag').prev().remove();
                x--;
                if(x===1) $('#removeTag').hide();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</body>

</html>