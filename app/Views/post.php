
    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--top-padding s-content--narrow">

        <article class="row entry format-standard">

            <div class="entry__media col-full">
                <div class="entry__post-thumb">
                    <img src="<?php echo base_url().'/public/uploads/'.$posts[0]['banner']; ?>"  
                         sizes="(max-width: 2000px) 100vw, 2000px" alt="">
                </div>
            </div>

            <div class="entry__header col-full">
                <h1 class="entry__header-title display-1">
                <?php echo $posts[0]['title']; ?>
                </h1>
                <ul class="entry__header-meta">
                    <li class="date"><?php echo date('d-m-Y',strtotime($posts[0]['created_at'])); ?></li>
                    <li class="byline">
                        By
                        <a href="#0"><?php echo $posts[0]['username']; ?></a>
                    </li>
                </ul>
            </div>

            <div class="col-full entry__main">

                <p class="lead drop-cap"><?php echo $posts[0]['intro']; ?></p>
                
                <p><?php echo $posts[0]['contentp']; ?></p>

                <h2>Large Heading</h2>

                <p>Harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus <a href="http://#">omnis voluptas assumenda est</a> id quod maxime placeat facere possimus, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et.</p>

                <blockquote><p>This is a simple example of a styled blockquote. A blockquote tag typically specifies a section that is quoted from another source of some sort, or highlighting text in your post.</p></blockquote>

                <p>Odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nulla vitae elit libero, a pharetra augue laboris in sit minim cupidatat ut dolor voluptate enim veniam consequat occaecat fugiat in adipisicing in amet Ut nulla nisi non ut enim aliqua laborum mollit quis nostrud sed sed.</p>

                <h3>Smaller Heading</h3>

                <p>Dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nulla vitae elit libero, a pharetra augue laboris in sit minim cupidatat ut dolor voluptate enim veniam consequat occaecat fugiat in adipisicing in amet Ut nulla nisi non ut enim aliqua laborum mollit quis nostrud sed sed.

<pre><code>
    code {
        font-size: 1.4rem;
        margin: 0 .2rem;
        padding: .2rem .6rem;
        white-space: nowrap;
        background: #F1F1F1;
        border: 1px solid #E1E1E1;
        border-radius: 3px;
    }
</code></pre>

                <p>Odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa.</p>

                <ul>
                    <li>Donec nulla non metus auctor fringilla.
                        <ul>
                            <li>Lorem ipsum dolor sit amet.</li>
                            <li>Lorem ipsum dolor sit amet.</li>
                            <li>Lorem ipsum dolor sit amet.</li>
                        </ul>
                    </li>
                    <li>Donec nulla non metus auctor fringilla.</li>
                    <li>Donec nulla non metus auctor fringilla.</li>
                </ul>

                <p>Odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nulla vitae elit libero, a pharetra augue laboris in sit minim cupidatat ut dolor voluptate enim veniam consequat occaecat fugiat in adipisicing in amet Ut nulla nisi non ut enim aliqua laborum mollit quis nostrud sed sed.</p>

                <div class="entry__taxonomies">
                    <div class="entry__cat">
                        <h5>Posted In: </h5>
                        <span class="entry__tax-list">
                            <a href="<?php echo base_url().'/index.php/dashboard/category/'.$posts[0]['idcat'];?>"><?php echo $posts[0]['namec']; ?></a>
                        </span>
                    </div> <!-- end entry__cat -->

                    <div class="entry__tags">
                        <h5>Tags: </h5>
                        <?php for($i=0;$i<count($posts);$i++){?>
                        <span class="entry__tax-list entry__tax-list--pill">
                            <a href="#0"><?php echo $posts[$i]['nametag']?></a>
                        </span>
                        <?php } ?>
                    </div> <!-- end entry__tags -->
                </div> <!-- end s-content__taxonomies -->

                <div class="entry__author">
                    <img src="<?php echo base_url().'/public/assets/images/avatars/'.$posts[0]['image']; ?>" alt="">

                    <div class="entry__author-about">
                        <h5 class="entry__author-name">
                            <span>Posted by</span>
                            <a href="#0"><?php echo $posts[0]['username']; ?></a>
                        </h5>

                        <div class="entry__author-desc">
                            <p>
                            Alias aperiam at debitis deserunt dignissimos dolorem doloribus, fuga fugiat 
                            impedit laudantium magni maxime nihil nisi quidem quisquam sed ullam voluptas 
                            voluptatum. Lorem ipsum dolor sit.
                            </p>
                        </div>
                    </div>
                </div>

            </div> <!-- s-entry__main -->

        </article> <!-- end entry/article -->


        <?php 
            $db = \Config\Database::connect();
            $query = $db->query('select * from POSTS order by random() limit 2');
            $result = $query->getResult();
        ?>

        <div class="s-content__entry-nav">
            <div class="row s-content__nav">
                <div class="col-six s-content__prev">
                    <a href="<?php echo base_url().'/index.php/dashboard/posts/'.$result[0]->slug.'/'.$result[0]->idpost?>" rel="prev">
                        <span>Previous Post</span>
                        <?php echo $result[0]->title;?>
                    </a>
                </div>
                <div class="col-six s-content__next">
                    <a href="<?php echo base_url().'/index.php/dashboard/posts/'.$result[1]->slug.'/'.$result[1]->idpost?>" rel="next">
                        <span>Next Post</span>
                        <?php echo $result[1]->title;?>
                    </a>
                </div>
            </div>
        </div> <!-- end s-content__pagenav -->

        <div class="comments-wrap">

            <div id="comments" class="row">
                <div class="col-full">

                    <h3 class="h2"><?php echo $countcomments; ?> Comments</h3>

                    <!-- START commentlist -->
                    <ol class="commentlist">
                        <?php 
                            foreach($comments as $com){
                        ?>
                        <li class="depth-1 comment">

                            <div class="comment__avatar">
                                <img class="avatar" src="<?php echo base_url().'/public/assets/images/images.jpg';?>" alt="" width="50" height="50">
                            </div>

                            <div class="comment__content">

                                <div class="comment__info">
                                    <div class="comment__author"><?php echo $com['cname'];?></div>

                                    <div class="comment__meta">
                                        <div class="comment__time"><?php echo date('d-m-Y',strtotime($com['added_m']));?></div>
                                        <div class="comment__reply">
                                            <a class="comment-reply-link" href="#0">Reply</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="comment__text">
                                <p><?php echo $com['cmessage'];?></p>
                                </div>

                            </div>

                        </li> <!-- end comment level 1 -->
                        <?php }?> 
                    </ol>
                    <!-- END commentlist --> 
                             

                </div> <!-- end col-full -->
            </div> <!-- end comments -->

            <div class="row comment-respond">

                <!-- START respond -->
                <div id="respond" class="col-full">

                    <h3 class="h2">Add Comment <span>Your email address will not be published</span></h3>

                    <form name="contactForm" id="contactForm" method="POST" action="" autocomplete="off">
                        <fieldset>

                            <div class="form-field">
                                <input name="cname" id="cname" class="full-width" placeholder="Your Name*" value="" type="text">
                            </div>

                            <div class="form-field">
                                <input name="cemail" id="cemail" class="full-width" placeholder="Your Email*" value="" type="text">
                            </div>

                            <div class="message form-field">
                                <textarea name="cmessage" id="cmessage" class="full-width" placeholder="Your Message*"></textarea>
                            </div>

                            <input name="submit" id="submit" class="btn btn--primary btn-wide btn--large full-width" value="Add Comment" type="submit">

                        </fieldset>
                    </form> <!-- end form -->

                </div>
                <!-- END respond-->

            </div> <!-- end comment-respond -->

        </div> <!-- end comments-wrap -->

    </section> <!-- end s-content -->
