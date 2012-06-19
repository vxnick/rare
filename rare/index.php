<?php
require_once '_orm/user.php';
require_once '_orm/task.php';
require_once '_orm/note.php';
require_once '_orm/priority.php';
require_once '_orm/status.php';

sitecmd::set('page.title', 'Tasks');

$filter_clause = fRequest::get('filter') ? 'assigned_to=' : 'assigned_to!=';
$filter_id = fRequest::get('filter', 'integer', fSession::get('user_id'));

$where_clause = fRequest::get('q') ? 'subject|content|notes.content~' : 'statuses.is_closed=';
$where_value = fRequest::get('q') ? fRequest::get('q') : 0;

$tasks = fRecordSet::build('Task',
	array($where_clause => $where_value, $filter_clause => $filter_id),
	array('priorities.order' => 'asc', 'created_at' => 'desc'));

require sitecmd::get('rare.tpl').'list.php';
?>