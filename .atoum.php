<?php
use \mageekguy\atoum;

define('TEST_ROOT',          __DIR__   . DIRECTORY_SEPARATOR . 'tests');
define('CODE_COVERAGE_ROOT', TEST_ROOT . DIRECTORY_SEPARATOR . 'coverage');

$report = $script->addDefaultReport();

if (!file_exists(CODE_COVERAGE_ROOT)) {
    mkdir(CODE_COVERAGE_ROOT);
}

$coverageField = new atoum\report\fields\runner\coverage\html(
    'Dumper',
    CODE_COVERAGE_ROOT
);

$coverageField->setRootUrl('file://' . CODE_COVERAGE_ROOT);

$report->addField($coverageField);


$script->noCodeCoverageForNamespaces('atoum');


$script->bootstrapFile(TEST_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php');