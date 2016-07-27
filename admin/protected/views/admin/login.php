
<div id="m_1" class="m">
	<div class="m_m">
		<div class="m_m_m">
			<div class="m_m_m_body">
				<div class="m_m_m_content">
					<div class="conteiner">
						<div id="logo">
							<span class="name">
								<img  src="/admin/images/logo.gif" alt="Reactive.CMS 3.0">
							</span>
						</div>
					</div>
					<div class="modal_form">	
                        <?php 
                            $form   =   $this->beginWidget('CActiveForm', array(
                        	   'id'                        =>  'login-form',
                        	   'enableClientValidation'    =>  false,
                        	   'clientOptions'             =>  array(
                		              'validateOnSubmit'  =>  true,
                    	       ),
                            )); 
                        ?>

						<div class="modal_line">
							<div class="title">
								<?='Логин'; ?>
							</div>
							<div class="value">
								<?=$form->textField($model,'username', array('autofocus'=>true)); ?>
							</div>
							<div class="error">
								<?=$form->error($model,'username'); ?>
							</div>
						</div>
						
						<div class="modal_line">
							<div class="title">
								<?='Пароль'; ?>
							</div>
							<div class="value">
								<?=$form->passwordField($model,'password'); ?>
							</div>
							<div class="error">
								<?=$form->error($model,'password'); ?>
							</div>
						</div>
							
						<div class="modal_line">
							<div class="title">
								<?='Запомнить меня'; ?>
							</div>
							<div class="value">
								<?=$form->checkBox($model,'rememberMe'); ?>
							</div>
							<div class="error">
								<?=$form->error($model,'rememberMe'); ?>
							</div>
						</div>
						
						<div class="modal_line_btn">
                            <a href="/admin/password" title="Забыли пароль?">Забыли пароль?</a>
                            <button class="modal_btn">Войти</button>
                            
						</div>	
                        

                        <? $this->endWidget(); ?>	
						</div>										
					</div>						
				</div>			
			</div>		
		</div>		
	</div>
</div>
<? var_dump($model);?>