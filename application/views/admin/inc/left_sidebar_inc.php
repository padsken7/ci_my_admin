			<div class="span3">

			<?php if(!isset($table_name)) $table_name=''; ?>
			<?php $this->admin->create_add_links($table_name); ?>

			
			<div class="well">
			<h5><i class="icon-file"></i> Загрузить файл</h5> 	
			
			<?php echo form_open_multipart('admin/panel/upload', array('id'=>'img_form'));?>
			<p>
			<span class="badge">gif</span>
			<span class="badge">jpg</span>
			<span class="badge">png</span>
			<span class="badge">pdf</span>
			</small></p>
			<p><small><input type="file" name="fileToUpload" id="fileToUpload" class="input-file" style="font-size:11px;"/></small></p>
			<p><input type="submit" value="загрузить" id="img_submit" class="btn btn-small" /></p>
            
			<? echo form_close(); ?>
			
			<div id="loading" style="display:none;">
			<small><img src="<?=base_url()?>b/img/ajax-loader.gif" style="vertical-align: middle;"/> Идет загрузка </small>
			</div>
			<div id="file_data"></div>
			</div>
			
			</div>