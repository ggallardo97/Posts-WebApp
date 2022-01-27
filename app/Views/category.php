<!-- s-content
    ================================================== -->
    <section class="s-content s-content--top-padding">

        <div class="row narrow">
            <div class="col-full s-content__header" data-aos="fade-up">
                <h1 class="display-1 display-1--with-line-sep">Category: <?php echo $category['namec']; ?></h1>
                <p class="lead">Dolor similique vitae. Exercitationem quidem occaecati iusto. Id non vitae enim quas error dolor maiores ut. Exercitationem earum ut repudiandae optio veritatis animi nulla qui dolores.</p>
            </div>
        </div>
        
        <div class="row entries-wrap add-top-padding wide">
            <div class="entries">

                <?php foreach($posts as $p){ ?>

                <article class="col-block">
                    
                    <div class="item-entry" data-aos="zoom-in">
                        <div class="item-entry__thumb">
                            <a href="<?php echo base_url().'/index.php/dashboard/posts/'.$p['slug'].'/'.$p['idpost']; ?>" class="item-entry__thumb-link">
                                <img src="<?php echo base_url().'/public/uploads/'.$p['banner']; ?>" 
                                         alt="">
                            </a>
                        </div>
        
                        <div class="item-entry__text">
                            <div class="item-entry__cat">
                                <a href="category.html">Design</a> 
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

        <?php if($pages>0){?>
            <div class="row pagination-wrap">
                <div class="col-full">
                    <nav class="pgn" data-aos="fade-up">
                        <ul>
                            <li><a class="pgn__prev" <?php echo $_GET['page'] > 1 ? 'href="'.base_url().'/index.php/dashboard/category/'.$category['idcat'].'/?page='.($_GET['page']-1).'"' : '';?>>Prev</a></li>
                            <?php for($i=0;$i<$pages;$i++){?>
                                <li><a class="pgn__num <?php echo $_GET['page'] == $i+1 ? 'current' : '';?>" href="<?php echo base_url().'/index.php/dashboard/category/'.$category['idcat'].'/?page='.($i+1); ?>"><?php echo $i+1; ?></a></li>
                            <?php } ?>
                            <li><a class="pgn__next" <?php echo $_GET['page'] < $pages ? 'href="'.base_url().'/index.php/dashboard/category/'.$category['idcat'].'/?page='.($_GET['page']+1).'"' : '';?>>Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php } ?>

    </section> <!-- end s-content -->
