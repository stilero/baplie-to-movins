<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Settings' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit) {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
?>

<script language="javascript" type="text/javascript">
<?php 
$jv = new JVersion();
if ($jv->RELEASE < 1.6): ?>

function submitbutton(task)
{
    var form = document.adminForm;
    if (task == 'cancel' || document.formvalidator.isValid(form)) {
		submitform(task);
	}
}
<?php else: ?>

Joomla.submitbutton = function(task)
{
	if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

<?php endif; ?>
</script>

	 	<form method="post" action="index.php" id="adminForm" name="adminForm">
	 	<div class="col width-70 fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
							
				<?php echo $this->form->getLabel('name'); ?>
				
				<?php echo $this->form->getInput('name');  ?>
					
		
				<div class="clr"></div>
					
					
				<?php echo $this->form->getLabel('description'); ?>
				
					
				<div class="clr"></div>
					
				<?php echo $this->form->getInput('description');  ?>
					
							
				<?php echo $this->form->getLabel('published'); ?>
				
				<?php echo $this->form->getInput('published');  ?>
			
						
          </fieldset>                      
        </div>
        <div class="col width-30 fltrt">
		        
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Parameters' ); ?></legend>
							
				<?php echo $this->form->getLabel('created'); ?>
				
				<?php echo $this->form->getInput('created');  ?>
								
			</fieldset>
			        
     		
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Advanced Parameters' ); ?></legend>
				<table>				
				<?php 
					$fieldSets = $this->form->getFieldsets('params');
					foreach($fieldSets  as $name =>$fieldset):  ?>				
				<?php foreach ($this->form->getFieldset($name) as $field) : ?>
					<?php if ($field->hidden):  ?>
						<?php echo $field->input;  ?>
					<?php else:  ?>
					<tr>
						<td class="paramlist_key" width="40%">
							<?php echo $field->label;  ?>
						</td>
						<td class="paramlist_value">
							<?php echo $field->input;  ?>
						</td>
					</tr>
				<?php endif;  ?>
				<?php endforeach;  ?>
			<?php endforeach;  ?>
			</table>			
			</fieldset>									


        </div>                   
		<input type="hidden" name="option" value="com_convertbapliemovins" />
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="settings" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>