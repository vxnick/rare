<?php
require_once '_orm/note.php';

try {
	$note = new Note(fRequest::get('id'));
	$task_id = $note->getTaskId();

	sitecmd::set('page.title', 'Editing note #'.$note->getId());

	if (fRequest::isPost()) {
		switch (fRequest::get('action')) {
			case 'edit':
				$note->setContent(fRequest::get('content'));
				$note->store();
				fURL::redirect(sitecmd::url('task/'.$task_id));
			break;

			case 'delete':
				try {
					$note->delete();
					fMessaging::create('success', 'Note deleted');
					fURL::redirect(sitecmd::url('task/'.$task_id));
				} catch (fValidationException $e) {
					fMessaging::create('error', $e->getMessage());
				}
			break;
		}
	}
} catch (fNotFoundException $e) {
	fMessaging::create('error', 'Invalid note ID specified');
	fURL::redirect('/');
}

require sitecmd::get('rare.tpl').'task_note.php';

?>