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
			</div>
			
		</div>
		
		<?php else: ?>
		
			<?php if(isset($success)): ?>
			<div class="alert alert-success"><?=$success?></div>
			<?php endif; ?>
				
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
