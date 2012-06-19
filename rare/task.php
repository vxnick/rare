<?php
require_once '_orm/task.php';
require_once '_orm/note.php';
require_once '_orm/status.php';
require_once '_orm/priority.php';

try {
	$task = new Task(fRequest::get('id'));

	try {
		$assignee = new User($task->getAssignedTo());
		$assignee_name = $assignee->getName();
	} catch (fNotFoundException $e) {
		$assignee_name = sitecmd::get('rare.default.assignee');
	}

	sitecmd::set('page.title', $task->getSubject());

	$priorities = fRecordSet::build('Priority', array('is_disabled=' => 0),
		array('order' => 'desc', 'name' => 'asc'));

	$statuses = fRecordSet::build('Status', array('is_disabled=' => 0),
		array('name' => 'asc'));

	$current_priority = $task->createPriority();
	$current_status = $task->createStatus();

	$users = fRecordSet::build('User', null, array('username' => 'asc'));

	if (fRequest::isPost()) {
		switch (fRequest::get('action')) {
			case 'edit-task':
				$task->populate();
				$task->setUserId(fSession::get('user_id'));
				$task->store();
				mail_notify($task,
					(fRequest::get('current_assignee') == fRequest::get('assigned_to') ?
						null : 'task-assigned'));
				fURL::redirect(sitecmd::url('task/'.$task->getId()));
			break;

			case 'add-note':
				try {
					$task->setPriorityId(fRequest::get('priority_id'));
					$task->setStatusId(fRequest::get('status_id'));
					$task->store();

					if (fRequest::get('content')) {
						$note = new Note();
						$note->setTaskId($task->getId());
						$note->setUserId(fSession::get('user_id'));
						$note->setContent(fRequest::get('content'));
						$note->setCreatedAt(time());
						$note->store();
						fMessaging::create('success', 'Note successfully created');
						mail_notify($task, 'note-added');
					} else {
						fMessaging::create('success', 'Task attributes changed');
					}
				} catch (fValidationException $e) {
					fMessaging::create('error', $e->getMessage());
				}
				fURL::redirect('/task/'.$task->getId());
			break;

			case 'delete':
				try {
					$task->delete();
					fMessaging::create('success', 'Task and notes deleted');
					fURL::redirect('/');
				} catch (fValidationException $e) {
					fMessaging::create('error', $e->getMessage());
				}
			break;
		}
	}

	$notes = $task->buildNotes();

	if (fRequest::get('action') == 'edit') {
		require sitecmd::get('rare.tpl').'task_form.php';
	} else {
		require sitecmd::get('rare.tpl').'task.php';
	}
} catch (fNotFoundException $e) {
	fMessaging::create('error', 'Invalid task ID specified');
	fURL::redirect('/');
}

?>