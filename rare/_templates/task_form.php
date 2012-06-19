<form id="form" action="<?php echo (fRequest::get('action') == 'edit' ? '/task/'.$task->getId().'/' : '/new/') ?>" method="post">
	<?php if (fRequest::get('action') == 'edit'): ?>
		<input type="hidden" name="action" value="edit-task" />
		<input type="hidden" name="current_assignee" value="<?php echo $task->getAssignedTo() ?>" />
	<?php endif ?>
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

	<label>Assignee:</label>
		<select name="assigned_to">
			<?php foreach ($users as $user): ?>
				<?php fHTML::printOption($user->getName(), $user->getId(),
					isset($task) ? $task->getAssignedTo() :
						sitecmd::get('rare.default.assignee')) ?>
			<?php endforeach ?>
		</select>

	<input type="text" name="subject" value="<?php echo fRequest::encode('subject', 'string', isset($task) ? $task->getSubject() : NULL) ?>" size="80" class="in" />
	<textarea name="content" rows="10" cols="80"><?php echo fRequest::encode('content', 'string', isset($task) ? $task->getContent() : NULL) ?></textarea>
	<input type="submit" name="submit" value="Save" />
</form>

<?php if (fRequest::get('action') == 'edit'): ?>
<div class="right">
<form action="<?php echo sitecmd::url('task/'.$task->getId()) ?>?action=delete" method="post" class="extra">
	<input type="button" value="Back" onclick="window.location='<?php echo sitecmd::url('task/'.$task->getId()) ?>'" />
	<input type="submit" value="Delete" onclick="return confirm('Really delete this task and all its notes?');" />
</form>
</div>
<?php endif ?>