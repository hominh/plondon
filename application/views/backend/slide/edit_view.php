<div class="maincontent">
    <div class="maincontentinner">
        <div class="widgetbox box-inverse">
            <h4 class="widgettitle">Cập nhậ slide</h4>
            <div class="widgetcontent wc1">
                <form class="form-horizontal" action="<?php echo base_url(); ?>quantri/slides/edit/<?php echo $info['id']; ?>" method="post" enctype="multipart/form-data">
                    <?php
                        echo "<div class='mess_error'>";
                        echo "<ul>";
                        if (validation_errors() != '') {
                            echo "<li>" . validation_errors() . "</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    ?>
                     <?php
                        if($info['margincontent'] == 1) {
                            $check1 = "checked";
                            $check2 = "";
                        }
                        else if($info['margincontent'] == 2) {
                            $check2 = "checked";
                            $check1 = "";
                        }
                        if($info['marginurlfix'] == 1) {
                            $check3 = "checked";
                            $check4 = "";
                        }
                        else if($info['marginurlfix'] == 2) {
                            $check4 = "checked";
                            $check3 = "";
                        }
                    ?>
                    <div class="control-group" style='display: none !important;'>
                        <label class="control-label">Tên slide</label>
                        <div class="controls">
                            <span class="field">
                                <?php
                                    echo $this->ckeditor->editor("name","");
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nội dung</label>
                        <div class="controls">
                            <span class="field">
                                <?php
                                    echo $this->ckeditor->editor("content",$info['content']);
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Căn lề</label>
                        <div class="controls">
                            <input type="radio" name="margincontent"  value="1" <?php echo $check1; ?> >Căn lề trái 
                            <input type="radio" name="margincontent"  value="2" <?php echo $check2; ?> >Căn lề phải
                        </div>
                    </div>
                    <div class="control-group" style='display: none !important;'>
                        <label class="control-label">Tên slide</label>
                        <div class="controls">
                            <span class="field">
                                <?php
                                    echo $this->ckeditor->editor("contents","123");
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Tên slide</label>
                        <div class="controls">
                            <span class="field">
                               <?php
                                    echo $this->ckeditor->editor("urlfix",$info['urlfix']);
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Căn lề</label>
                        <div class="controls">
                            <input type="radio" name="marginurlfix"  value="1" <?php echo $check3; ?> >Căn lề trái 
                            <input type="radio" name="marginurlfix"  value="2" <?php echo $check4; ?> >Căn lề phải
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Link sản phẩm</label>
                        <div class="controls">
                            <span class="field">
                               <input name="url" type="text"  placeholder="Link sản phẩm" value="">
                            </span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Hình ảnh</label>
                        <div class="controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append" style="">
                                    <input type="file" name="userfile" size="20" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        
                        <div class="controls">
                            <img src='<?php echo $info['image']; ?>' height='200' width='200' />
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Thêm mới</button>
                        <a class="btn" href="index.php">Hủy bỏ</a>
                    </div>
                </form>
            </div><!--widgetcontent-->
        </div><!--widget-->
    </div><!-- End maincontentinner-->
</div><!-- End maincontent -->