<?php
use \mageekguy\atoum;

define('TEST_ROOT',          __DIR__   . DIRECTORY_SEPARATOR . 'tests');
define('CODE_COVERAGE_ROOT', TEST_ROOT . DIRECTORY_SEPARATOR . 'coverage');

$report = $script->addDefaultReport();

if (!file_exists(CODE_COVERAGE_ROOT) && !@mkdir(CODE_COVERAGE_ROOT)) {
    die('Unable to create directory "' . CODE_COVERAGE_ROOT . '".');
}

$coverageField = new atoum\report\fields\runner\coverage\html(
    basename(__DIR__),
    CODE_COVERAGE_ROOT
);

$coverageField->setRootUrl('file://' . CODE_COVERAGE_ROOT);

// $coverageField->addSrcDirectory(__DIR__ . '/src/Marmotz/Dumper');

$report->addField($coverageField);


$script->noCodeCoverageForNamespaces('atoum');