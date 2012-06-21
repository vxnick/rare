<table class="tablesorter">
	<thead>
	<tr>
		<th>ID</th>
		<th>Assignee</th>
		<th>Subject</th>
		<th>Priority</th>
		<th>Status</th>
		<th>Created</th>
	</tr>
	</thead>
	<tbody>
	<?php if (count($tasks) == 0): ?>
	<tr>
		<td colspan="6" align="center">No tasks to display</td>
	</tr>
	<?php endif ?>

	<?php foreach ($tasks as $task): ?>
	<?php
	$status = $task->createStatus();
	$priority = $task->createPriority();

	$assignee = new User($task->getAssignedTo());
	$assignee_name = $assignee->getName();
	?>
	<tr>
		<td><?php echo $task->getId() ?></td>
		<td><?php echo $assignee_name ?></td>
		<td><a href="<?php echo sitecmd::url('task/'.$task->getId().(fRequest::get('q') ? '?highlight='.fRequest::get('q') : '')) ?>"><?php echo $task->encodeSubject() ?></a></td>
		<td><span class="button"<?php echo ($priority->getColour() ? ' style="background-color:#'.$priority->getColour().'"' : '') ?>>
			<?php echo $priority->encodeName() ?>
		</span></td>
		<td><span class="button"<?php echo ($status->getColour() ? ' style="background-color:#'.$status->getColour().'"' : '') ?>>
			<?php echo $status->encodeName() ?>
		</span></td>
		<td title="<?php echo $task->getCreatedAt()->format('r') ?>">
			<?php echo $task->getCreatedAt()->getFuzzyDifference() ?>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
