<?php $this->load->view('template/header'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-success">
            <div id="title_warning" class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Your username or password was incorrect !</strong>
            </div>
                <div class="panel-heading">
                    <h2 class="panel-title"><span></span>Sign In To SMM-System Version 1.0.0</h2>
                    </div>
                    <div class="panel-body">
                        <div class="loading-progress"></div>
                        <form id="frmLogin" role="form" method="post">
                            <fieldset>
                                <div class="form-group" id="warning_user">
                                    <input class="form-control" placeholder="Username / Student code" id="username" name="username"  type="text" autofocus>
                                </div>
                                <div class="form-group" id="warning_pass">
                                    <input class="form-control" placeholder="Password" id="password" name="password"  type="password" value="">
                                </div>
                                <div class="form-group" id="warning_location">
                                	<select name="location" id="location" class="form-control" >
                                		<option value="" selected>Please select school</option>
										<?php
										if (!empty($model)) {
    										foreach ($model as $data) { ?>
											<option value="<?php echo $data['LOCAIDX']; ?>"><?php echo $data['LOCA_NAME']; ?></option>
										<?php
    										}
										}
										?>
                                	</select>
                                </div>
           <!--                      <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="1">Remember Me
                                    </label>
                                </div> -->
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo JS?>jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS?>jquery.form.js"></script>
<script type="text/javascript" src="<?php echo LB?>jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo LB?>bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo JS;?>smm-system.js" type="text/javascript"></script>
</div>
</body>
</html>