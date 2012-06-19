<?php
require_once '_orm/user.php';
require_once '_orm/task.php';
require_once '_orm/note.php';
require_once '_orm/status.php';
require_once '_orm/priority.php';

sitecmd::set('page.title', 'New Task');

$priorities = fRecordSet::build('Priority', array('is_disabled=' => 0),
	array('order' => 'asc', 'name' => 'asc'));

$statuses = fRecordSet::build('Status', array('is_disabled=' => 0),
	array('name' => 'asc'));

$users = fRecordSet::build('User', array('is_disabled=' => 0),
	array('name' => 'asc'));

if (fRequest::isPost()) {
	try {
		$task = new Task();
		$task->populate();
		$task->setUserId(fSession::get('user_id'));
		$task->store();
		mail_notify($task, 'new-task');
		fURL::redirect(sitecmd::url('task/'.$task->getId()));
	} catch (fValidationException $e) {
		fMessaging::create('error', $e->getMessage());
	}
}

require sitecmd::get('rare.tpl').'task_form.php';
?>