<?php
require_once '_orm/user.php';
require_once '_orm/task.php';
require_once '_orm/note.php';
require_once '_orm/priority.php';
require_once '_orm/status.php';

sitecmd::set('page.title', 'Tasks');

$where = array();

// Add search to the 'where' clause
if (fRequest::get('q')) {
	$where['subject|content|notes.content~'] = fRequest::get('q');
} else {
	// Handle task assignment
	$tasks_where = fRequest::get('filter') ? 'assigned_to=' : 'assigned_to!=';
	$where[$tasks_where] = fRequest::get('filter', 'integer', fSession::get('user_id'));

	// Only show tasks that have an 'open' status
	$where['statuses.is_closed='] = 0;
}

$tasks = fRecordSet::build('Task', $where,
	array('priorities.order' => 'asc', 'created_at' => 'desc'));

require sitecmd::get('rare.tpl').'list.php';
?>