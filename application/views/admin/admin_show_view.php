<?php $this->load->view('admin/inc/admin_header_inc') ?>
	
	<div class="container">
	

		<?php if($is_admin): ?>
		<div class="row">
<?php $this->load->view('admin/inc/left_sidebar_inc') ?>
			
			<div class="span9">
				
				<?php if(isset($success)): ?>
				<div class="alert alert-success"><?=$success?></div>
				<?php endif; ?>
				<?php if(isset($error)): ?>
				<div class="alert alert-error"><?=$error?></div>
				<?php endif; ?>
				
				<table class="table">
				
				<?php $first = $$table_name_show; ?>
				<?php foreach($first[0] as $key => $val): ?>
				<th><?php echo strip_tags($key); ?></th>
				<?php endforeach; ?>
				<th></th>
				<th></th>
				
				<?php foreach($$table_name_show as $item): ?>
				<tr>
					<?php foreach($item as $key => $val): ?>
						<td><?php echo cut_string(strip_tags($val), 50); ?></td>
					<?php endforeach; ?>
					<td style="text-align:center;width:20px;"><a href="/admin/panel/edit/<?=$table_name_show;?>/<?=$item->id;?>"><i class="icon-pencil"></i></a></td>
					<td style="text-align:center;width:20px;"><a href="/admin/panel/delete/<?=$table_name_show;?>/<?=$item->id;?>" onclick="return confirm('Вы действительно хотите удалить запись?')"><i class="icon-trash"></i></a></td>
				</tr>
				<?php endforeach; ?>
				
				</table>
				
				<div class="pagination">
				<ul>
				<?=$pag_links;?>
				</ul>
				</div>
				
			</div>
			
		</div>
		
		<?php else: ?>
		
			<?php if(isset($error)): ?>
			<div class="alert alert-error"><?=$error?></div>
			<?php endif; ?>
		
			<? echo form_open('admin/panel/login', array('class'=>'form-horizontal'));?>    
			<legend>Форма авторизации</legend>
			<div class="control-group">
				<label class="control-label" for="login"><i class="icon-user"></i> Логин</label>			
				<div class="controls"><input type="text" id="login" name="login" value=""/></div>
			</div>

			<div class="control-group">			
				<label class="control-label" for="password"><i class="icon-lock"></i> Пароль</label>
				<div class="controls"><input type="password" id="password" name="password" value=""/></div>
			</div>
			
			<div class="control-group">
				<div class="controls"><button type="submit" class="btn btn-large">вход</button></div>
			</div>
			
			<? echo form_close(); ?>
			
		<?php endif; ?>
	</div>
	
	<?php $this->load->view('admin/inc/js_inc'); ?>
	
	
  </body>
</html>
