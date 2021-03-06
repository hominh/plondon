<div class="maincontent">
    <div class="maincontentinner">
        <div class="widgetbox box-inverse">
            <h4 class="widgettitle">Cập nhật video</h4>
            <div class="widgetcontent wc1">
                <form class="form-horizontal" action="<?php echo base_url(); ?>quantri/videos/edit/<?php echo $info['id']; ?>" method="post" enctype="multipart/form-data">
                <?php
			        echo "<div class='mess_error'>";
			        echo "<ul>";
			            if(validation_errors() != ''){
			                echo "<li>".validation_errors()."</li>";
			            }
			        echo "</ul>";
			        echo "</div>";
				?>
                    <div class="control-group">
                        <label class="control-label">Tên bài viết</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Tên bài viết" value="<?php echo $info['name']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Tiêu đề bài viết</label>
                        <div class="controls">
                            <input name="title" type="text"  placeholder="Tiêu đề bài viết" value="<?php echo $info['title']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Miêu tả bài viết</label>
                        <div class="controls">
                            <textarea name="description" id="description" class="span5"><?php echo $info['description']; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                    	<label class="control-label">Nội dung bài viết</label>
                    	<div class="controls">
                    		<span class="field">
	                    		<?php
	                    			echo $this->ckeditor->editor("content",$info['content']);
	                    		?>
                    		</span>
                    	</div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Ảnh bài viết</label>
                        <div class="controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append" style="">
                                   	<input type="file" name="userfile" size="20" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <a class="btn" href="index.php">Hủy bỏ</a>
                    </div>
                </form>
            </div><!--widgetcontent-->
        </div><!--widget-->
    </div><!-- End maincontentinner-->
</div><!-- End maincontent -->