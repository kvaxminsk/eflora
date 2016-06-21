<div id="m_1" class="m">
	<div class="m_m">
		<div class="m_m_m">
			<div class="m_m_m_body">
				<div class="m_m_m_content">
					<div class="conteiner">
						<div id="logo">
							<img  src="/admin/images/logo.gif" alt="Reactive.CMS 3.0">
						</div>
					</div>
					<div class="modal_form">	
                        <?php 
                            $form = $this->beginWidget('CActiveForm', array(
                        	       'id'                            =>  'password-form',
                        	       'enableClientValidation'        =>  false,
                        	       'clientOptions'                 =>  array(
                        		          'validateOnSubmit'=>true,
                        	       ),
                            )); 
                        ?>
                        
                        <? if(!empty($_GET['result'])): ?>
                            <? if($_GET['result'] == 'ok'): ?>
                                <font color="green">Инструкция по восстановлению пароля выслана вам на указанный e-mail.</font><br /><br />
                            <? else: ?>
                                <font color="red">Произошла ошибка, администратор с таким email адресом не найден.</font> <br /><br />
                            <? endif; ?>
                        <? endif; ?>
						<div class="modal_line">
							<div class="title">
								<?='E-mail администратора'; ?>
							</div>
							<div class="value">
								<?=$form->textField($model,'email', array('autofocus'=>true)); ?>
							</div>
							<div class="error">
								<?=$form->error($model,'email'); ?>
							</div>
						</div>
						
						
						<div class="modal_line_btn">
                            <a href="/admin/login" title="Войти">Войти</a>        
                            <button class="modal_btn">Восстановить пароль</button>
						</div>	

                        <?php $this->endWidget(); ?>	
						</div>										
					</div>						
				</div>			
			</div>		
		</div>		
	</div>
</div>
