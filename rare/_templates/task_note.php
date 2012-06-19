<?php
if (fRequest::get('action') == 'edit') {
	$form_action = 'note/'.$note->getId();
	$post_action = 'edit';
	$form_content = fRequest::get('content', null, $note->getContent());
} else {
	$form_action = 'task/'.$task->getId();
	$post_action = 'add-note';
	$form_content = fRequest::get('content');
}
?>
<form id="form" action="<?php echo sitecmd::url($form_action) ?>" method="post">
	<input type="hidden" name="action" value="<?php echo $post_action ?>" />
	<?php if ($post_action == 'add-note'): ?>
	<label>Priority:</label>
		<select name="priority_id">
			<?php foreach ($priorities as $priority): ?>
				<?php fHTML::printOption($priority->encodeName(),
					$priority->getId(),
					fRequest::get('priority_id', 'integer',
						isset($task) ?
							$task->getPriorityId() :
							sitecmd::get('rare.default.priority'))) ?>
			<?php endforeach ?>
		</select>

	<label>Status:</label>
		<select name="status_id">
			<?php foreach ($statuses as $status): ?>
				<?php fHTML::printOption($status->encodeName(),
					$status->getId(),
					fRequest::get('status_id', 'integer',
						isset($task) ?
							$task->getStatusId() :
							sitecmd::get('rare.default.status'))) ?>
			<?php endforeach ?>
		</select>
	<?php endif ?>
	<textarea name="content" cols="80" rows="10"><?php echo $form_content ?></textarea><br />
	<input type="submit" name="submit" value="Save Note" />
</form>
<?php if (fRequest::get('action') == 'edit'): ?>
<div class="right">
<form action="<?php echo sitecmd::url('note/'.$note->getId()) ?>?action=delete" method="post" class="extra">
	<input type="button" value="Back" onclick="window.location='<?php echo sitecmd::url('task/'.$note->getTaskId()) ?>'" />
	<input type="submit" value="Delete" onclick="return confirm('Really delete this note?');" />
</form>
</div>
<?php endif ?>