<?php

sitecmd::set('rare.version', '0.2.0');

$db = sitecmd::get('rare.db');

$conn = new fDatabase('mysql', $db['database'], $db['username'], $db['password'], $db['hostname']);
fORMDatabase::attach($conn);

sitecmd::set('rare.tpl', sitecmd::get('paths.root').DIRECTORY_SEPARATOR.
	'_templates'.DIRECTORY_SEPARATOR);

// Wrapper for fRequest and non-instantiated ORM objects
function get_value($primary, $secondary) {
	$secondary = isset($secondary) ? $secondary : NULL;
	return fRequest::get($primary, NULL, $secondary);
}

/**
 * Send notification emails to task subscribers.
 *
 * Takes a Task object and optional action
 */
function mail_notify($task, $action = null) {
	// Array of names and email addresses to notify
	$notify = array();

	switch ($action) {
		case 'note-added':
			// Get the task creator
			$creator = $task->createUser();
			$notify[$creator->getEmail()] = $creator->getName();

			// Get the task assignee
			$assignee = new User($task->getAssignedTo());
			$notify[$assignee->getEmail()] = $assignee->getName();

			// Find everyone who is involved with this task
			$notes = $task->buildNotes();

			foreach ($notes as $note) {
				$author = $note->createUser();
				// Skip the default assignee user
				if ($author->getId() == sitecmd::get('rare.default.assignee')) {
					continue;
				}
				$notify[$author->getEmail()] = $author->getName();
			}

			// Remove the current user - we don't want to be notified about our
			// own actions!
			$current_user = new User(fSession::get('user_id'));
			if (isset($notify[$current_user->getEmail()])) {
				unset($notify[$current_user->getEmail()]);
			}

			// Get the most recent note
			$note = fRecordSet::build('Note', array('task_id=' => $task->getId()),
				array('id' => 'desc'), 1)->getRecord(0);

			$template = 'mail_task_note';
			$subject = 'New note added';
			$replacements = array
			(
				'{TASK_ID}' => $task->getId(),
				'{NOTE_AUTHOR_NAME}' => $note->createUser()->getName(),
				'{NOTE_CONTENT}' => $note->getContent(),
				'{TASK_URL}' => sitecmd::url('task/'.$task->getId()),
			);
		break;

		case 'new-task':
		case 'task-assigned':
			// Ignore if we're assigning to ourself
			if ($task->getAssignedTo() == fSession::get('user_id')) {
				return true;
			}

			// Ignore if it's assigned to the default assignee
			if ($task->getAssignedTo() == sitecmd::get('rare.default.assignee')) {
				return true;
			}

			// Find the assigned user
			$assignee = new User($task->getAssignedTo());
			$notify[$assignee->getEmail()] = $assignee->getName();

			$template = 'mail_task_assigned';
			$subject = 'Task assigned';
			$replacements = array
			(
				'{TASK_ID}' => $task->getId(),
				'{TASK_AUTHOR_NAME}' => $task->createUser()->getName(),
				'{TASK_URL}' => sitecmd::url('task/'.$task->getId()),
			);
		break;

		default:
			return false;
	}

	$mail = new fEmail();
	$mail->setSubject('Rare: '.$subject);
	$mail->setFromEmail(sitecmd::get('rare.default.from_email'),
		sitecmd::get('rare.default.from_name'));
	$mail->loadBody(sitecmd::get('rare.tpl').$template.'.php',
		$replacements);

	// Send each email individually
	foreach ($notify as $email => $name) {
		// Ignore empty email addresses
		if (empty($email)) {
			continue;
		}
		$mail->clearRecipients();
		$mail->addRecipient($email, $name);
		$mail->send();
	}
}

// Transform task/note content
function content_convert($source) {
	// Handle task references
	$source = preg_replace('/#([0-9]+)/',
		'<a href="'.sitecmd::url('task/$1').'">#$1</a>', $source);

	return fHTML::makeLinks(Markdown($source));
}

// Map `htpasswd` usernames to the database
function usermap_hook($file) {
	if (PHP_SAPI == 'cli') {
		return null;
	}

	if (isset($_SERVER['PHP_AUTH_USER'])) {
		require_once sitecmd::get('paths.root').DIRECTORY_SEPARATOR.'_orm'.
			DIRECTORY_SEPARATOR.'user.php';
		try {
			$user = new User(array('username' => $_SERVER['PHP_AUTH_USER']));

			if (fSession::get('user_id')) {
				return true;
			}

			fSession::set('user_id', $user->getId());
			fURL::redirect('');
		} catch (fNotFoundException $e) {}
	}

	$file = new fFile(sitecmd::get('paths.root').DIRECTORY_SEPARATOR.'_401.php');
}

sitecmd::addEvent('request-file', 'usermap_hook');

?>