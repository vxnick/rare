<div id="task">
	<h1><?php echo $task->getSubject() ?></h1>
	<ul class="meta">
		<li>Created by <?php echo $task->createUser()->getName() ?></li>
		<li title="<?php echo $task->getCreatedAt()->format('r') ?>">
			<?php echo $task->getCreatedAt()->getFuzzyDifference() ?>.
		</li>
		<li>Assigned to <?php echo $assignee_name ?></li>
		<li class="priority"<?php echo ($current_priority->getColour() ? ' style="background-color:#'.$current_priority->getColour().'"' : '') ?>>
			<?php echo $current_priority->encodeName() ?>
		</li>
		<li class="status"<?php echo ($current_status->getColour() ? ' style="background-color:#'.$current_status->getColour().'"' : '') ?>>
			<?php echo $current_status->encodeName() ?>
		</li>
	</ul>
	<span class="edit"><a href="<?php echo sitecmd::url('task/'.$task->getId().'?action=edit') ?>">Update</a></span>
	<div class="content">
		<?php echo content_convert($task->getContent()) ?>
	</div>
</div>

<?php if (count($notes) > 0): ?>
	<?php foreach ($notes as $note): ?>
	<div class="note<?php echo ($note->getUserId() == $task->getUserId() ? ' author' : '') ?>">
		<ul class="meta">
			<li id="note-<?php echo $note->getId() ?>">
				<?php echo $note->createUser()->getName() ?> &mdash;
			</li>
			<li class="date" title="<?php echo $note->getCreatedAt()->format('r') ?>">
				<?php echo $note->getCreatedAt()->getFuzzyDifference() ?>
			</li>
		</ul>
		<span class="edit">
			<a href="<?php echo sitecmd::url('note/'.$note->getId().'?action=edit') ?>">Edit</a>
		</span>
		<div class="content">
			<?php echo content_convert($note->getContent()) ?>
		</div>
	</div>
	<?php endforeach ?>
<?php endif ?>

<?php require sitecmd::get('rare.tpl').'task_note.php' ?>