<?php
require_once __DIR__ . '/../../Envtesting.php';

\envtesting\Assert::true(
	\envtesting\Check::lib('bz2', 'bzopen'),
	'Bzip not found'
);