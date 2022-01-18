<section class="s-featured">
        <div class="row">
            <div class="col-full">
                <form method= "POST" action="" enctype="multipart/form-data">
                    <input type="text" name="title" placeholder='Title'>
                    <input type="text" name="intro" placeholder='Intro'>
                    <label for="banner">Banner</label>
                    <input type="file" name="banner">
                    <textarea id="summernote" name="contentp" placeholder='Content'></textarea><br>
                    <label for="category">Category</label>
                    <select name="category">
                        <?php
                            foreach($categories as $cat){
                                echo '<option value='.$cat['idcat'].'>'.$cat['namec'].'</option>';
                            }
                        ?>
                    </select>
                    <input type="text" name="tags[]" placeholder='Tags'>
                    <input type="button" value="Add tag" id="addTag">
                    <input type="button" value="Remove tag" id="removeTag"><br>
                    <input type="submit" value="Send">
                </form>
            </div>
        </div>
</section>
