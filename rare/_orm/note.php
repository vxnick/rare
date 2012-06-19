<?php

class Note extends fActiveRecord {
	protected function configure() {
		fORMDate::configureDateCreatedColumn($this, 'created_at');
	}
}

?>