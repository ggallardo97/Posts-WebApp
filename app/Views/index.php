
    <!-- featured 
    ================================================== -->
    <section class="s-featured">
        <div class="row">
            <div class="col-full">

                <div class="featured-slider featured" data-aos="zoom-in">

                <?php foreach($posts as $p){?>


                    <div class="featured__slide">
                        <div class="entry">

                            <div class="entry__background" style="background-image:url('<?php echo base_url().'/public/uploads/'.$p['banner']; ?>');"></div>
                            
                            <div class="entry__content">
                                <span class="entry__category"><a href="<?php echo base_url().'/index.php/dashboard/category/'.$p['category'];?>"><?php echo $p['namec']; ?></a></span>

                                <h1><a href="<?php echo base_url().'/index.php/dashboard/posts/'.$p['slug'].'/'.$p['idpost']; ?>" title=""><?php echo $p['title']; ?></a></h1>

                                <div class="entry__info">
                                    <a href="#0" class="entry__profile-pic">
                                        <img class="avatar" src="<?php echo base_url();?>/public/assets/images/avatars/<?php echo $p['username'];?>.jpg" alt="User">
                                    </a>
                                    <ul class="entry__meta">
                                        <li><a href="#0"><?php echo $p['username']; ?></a></li>
                                        <li><?php echo date('d-m-Y',strtotime($p['created_at']));?></li>
                                    </ul>
                                </div>
                            </div> <!-- end entry__content -->
                            
                        </div> <!-- end entry -->
                    </div> <!-- end featured__slide -->

                    <?php }?>

                    
                </div> <!-- end featured -->

            </div> <!-- end col-full -->
        </div>
    </section> <!-- end s-featured -->


    <!-- s-content
    ================================================== -->
    <section class="s-content">
        
        <div class="row entries-wrap wide">
            <div class="entries">

                <?php
                    
                    foreach($posts as $p){?>

                <article class="col-block">
                    
                    <div class="item-entry" data-aos="zoom-in">
                        <div class="item-entry__thumb">
                            <a href="<?php echo base_url().'/index.php/dashboard/posts/'.$p['slug'].'/'.$p['idpost']; ?>" class="item-entry__thumb-link">
                                <img src="<?php echo base_url().'/public/uploads/'.$p['banner']; ?>" alt="">
                            </a>
                        </div>
        
                        <div class="item-entry__text">    
                            <div class="item-entry__cat">
                                <a href="<?php echo base_url().'/index.php/dashboard/category/'.$p['idcat']?>"><?php echo $p['namec']; ?></a> 
                            </div>
    
                            <h1 class="item-entry__title"><a href="single-standard.html"><?php echo $p['title']; ?></a></h1>
                                
                            <div class="item-entry__date">
                               <?php echo date('d-m-Y',strtotime($p['created_at']));?>
                            </div>
                        </div>
                    </div> <!-- item-entry -->

                </article> <!-- end article -->
                <?php }?>

            </div> <!-- end entries -->
        </div> <!-- end entries-wrap -->

        <div class="row pagination-wrap">
            <div class="col-full">
                <nav class="pgn" data-aos="fade-up">
                    <ul>
                        <li><a class="pgn__prev" <?php echo $_GET['page'] > 1 ? 'href="'.base_url().'?page='.($_GET['page']-1).'"' : '';?>>Prev</a></li>
                        <?php for($i=0;$i<$pages;$i++){?>
                            <li><a class="pgn__num <?php echo $_GET['page'] == $i+1 ? 'current' : '';?>" href="<?php echo base_url().'?page='.($i+1); ?>"><?php echo $i+1; ?></a></li>
                        <?php } ?>
                        <li><a class="pgn__next" <?php echo $_GET['page'] < $pages ? 'href="'.base_url().'?page='.($_GET['page']+1).'"' : '';?>>Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </section> <!-- end s-content -->

