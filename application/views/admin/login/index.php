<html>
    <head>
        <?php $this->load->view('admin/head'); ?>
    </head>
    <body class="nobg loginPage" style="min-height:100%;">
        <div class="loginWrapper" style="top:45%;">
	
	    <div class="widget" id="admin_login" style="height:auto; margin:auto;">
	        <div class="title"><img src="<?php echo public_url('admin') ?>/images/icons/dark/laptop.png" alt="" class="titleIcon">
	        	<h6>Đăng nhập</h6>
	        </div>
	        
	        <form class="form" id="form" action="" method="post">
	           <fieldset>
	                <div class="formRow">
	                    <label for="param_username">Tên đăng nhập:</label>
	                    <div class="loginInput"><input name="username" id="param_username" type="text"></div>
	                    <div class="clear"></div>
	                </div>
	                
	                <div class="formRow">
	                    <label for="param_password">Mật khẩu:</label>
	                    <div class="loginInput"><input name="password" id="param_password" type="password"></div>
	                    <div class="clear"></div>
	                </div>
	                
	                <div class="loginControl">
	                    <input name="submit" value="1" type="hidden">
	                    <input value="Đăng nhập" class="dredB logMeIn" type="submit">
	                    <div class="clear"></div>
	                </div>
	            </fieldset>
	        </form>
	    </div>
	    
	</div>
    <?php $this->load->view('admin/footer')?>
    </body>
</html>