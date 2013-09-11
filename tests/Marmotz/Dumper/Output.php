<?php

namespace tests\units\Marmotz\Dumper;

use atoum;
use Marmotz\Dumper\Proxy\ArrayProxy;
use Marmotz\Dumper\Output      as TestedClass;
use mock\Marmotz\Dumper\Dump   as mockDump;
use mock\Marmotz\Dumper\Output as mockOutput;


class Output extends atoum
{
    public function testConstruct()
    {
        $this
            ->if($mockDump = new mockDump)
            ->and($output = new TestedClass($mockDump))
                ->object($output->getDumper())
                    ->isIdenticalTo($mockDump)
                ->integer($output->getIndent())
                    ->isEqualTo(2)
                ->string($output->getPrefix())
                    ->isEqualTo('')
                ->variable($output->getParentOutput())
                    ->isNull()
                ->integer($output->getLevel())
                    ->isEqualTo(0)
                ->boolean($output->getAutoIndent())
                    ->isTrue()
                ->variable($output->getCurrentPosition())
                    ->isNull()

            ->if($mockDump = new mockDump)
            ->and($parentOutput = new TestedClass($mockDump))
            ->and($output = new TestedClass($mockDump, $parentOutput))
                ->object($output->getDumper())
                    ->isIdenticalTo($mockDump)
                ->integer($output->getIndent())
                    ->isEqualTo(2)
                ->string($output->getPrefix())
                    ->isEqualTo('')
                ->object($output->getParentOutput())
                    ->isIdenticalTo($parentOutput)
                ->integer($output->getLevel())
                    ->isEqualTo(0)
                ->boolean($output->getAutoIndent())
                    ->isTrue()
                ->variable($output->getCurrentPosition())
                    ->isNull()
        ;
    }

    public function testAdd()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setIndent($indent = 2))
            ->and($output->setLevel(0))
                ->given($output->reset())
                ->output(
                    function() use($output) {
                        $output->add();
                    }
                )
                    ->isEqualTo('')
                ->boolean($output->getAutoIndent())
                    ->isFalse()
                ->integer($output->getCurrentPosition())
                    ->isEqualTo(0)

                ->given($output->reset())
                ->output(
                    function() use($output) {
                        $output->add('');
                    }
                )
                    ->isEqualTo('')
                ->boolean($output->getAutoIndent())
                    ->isFalse()
                ->integer($output->getCurrentPosition())
                    ->isEqualTo(0)

                ->given($output->reset())
                ->output(
                    function() use($output) {
                        $output->add(' ');
                    }
                )
                    ->isEqualTo(' ')
                ->boolean($output->getAutoIndent())
                    ->isFalse()
                ->integer($output->getCurrentPosition())
                    ->isEqualTo(1)

                ->given($output->reset())
                ->output(
                    function() use($output) {
                        $output->add(PHP_EOL);
                    }
                )
                    ->isEqualTo(PHP_EOL)
                ->boolean($output->getAutoIndent())
                    ->isTrue()
                ->variable($output->getCurrentPosition())
                    ->isNull()

                ->given($output->reset())
                ->output(
                    function() use($output, &$format, &$data1, &$data2) {
                        $output->add(
                            $format = uniqid() . '%s' . uniqid(),
                            $data1 = uniqid(),
                            $data2 = uniqid()
                        );
                    }
                )
                    ->isEqualTo(
                        sprintf(
                            $format,
                            $data1,
                            $data2
                        )
                    )

                ->given($output->reset())
                ->given($output->setLevel($level = 1))
                ->output(
                    function() use($output, &$string) {
                        $output->add($string = uniqid());
                    }
                )
                    ->isEqualTo(str_repeat(' ', $level * $indent) . $string)
        ;
    }

    public function testAddLn()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setLevel(0))
                ->given($output->reset())
                ->output(
                    function() use($output) {
                        $output->addLn();
                    }
                )
                    ->isEqualTo(PHP_EOL)

                ->given($output->reset())
                ->output(
                    function() use($output) {
                        $output->addLn('');
                    }
                )
                    ->isEqualTo(PHP_EOL)

                ->given($output->reset())
                ->output(
                    function() use($output, &$string) {
                        $output->addLn($string = uniqid());
                    }
                )
                    ->isEqualTo($string . PHP_EOL)
        ;
    }

    public function testSetGetAddToCurrentTemplateCompilation()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
                ->object($output->addToCurrentTemplateCompilation($code1 = uniqid()))
                    ->isIdenticalTo($output)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo($code1 . PHP_EOL)

                ->object($output->addToCurrentTemplateCompilation($code2 = uniqid()))
                    ->isIdenticalTo($output)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo($code1 . PHP_EOL . $code2 . PHP_EOL)

                ->object($output->setCurrentTemplateCompilation($code3 = uniqid()))
                    ->isIdenticalTo($output)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo($code3)
        ;
    }

    public function testCompileCurrentTemplate()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
            ->and(
                $output->setCurrentTemplateSource(
                    array(
                        'a',
                        '    b',
                        '    {% if(true) %}',
                        '    {{ FORMAT_SHORT }}',
                        '    {% else %}',
                        '    {{{ $foobar }}}',
                        '    {% end %}',
                    )
                )
            )
                ->object($output->compileCurrentTemplate())
                    ->isIdenticalTo($output)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->add("a");'                                . PHP_EOL .
                        '$this->addLn();'                                 . PHP_EOL .
                        '$this->inc();'                                   . PHP_EOL .
                        '$this->add("b");'                                . PHP_EOL .
                        '$this->addLn();'                                 . PHP_EOL .
                        'if(true) {'                                      . PHP_EOL .
                        '$this->add(\Marmotz\Dumper\Dump::FORMAT_SHORT);' . PHP_EOL .
                        '$this->addLn();'                                 . PHP_EOL .
                        '} else {'                                        . PHP_EOL .
                        '$this->dump($foobar);'                           . PHP_EOL .
                        '}'                                               . PHP_EOL .
                        '$this->dec();'                                   . PHP_EOL
                    )
        ;
    }

    public function testCompileIndent()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
            ->and($output->setCurrentTemplateIndent(0))
                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileIndent(''))
                ->integer($output->getCurrentTemplateIndent())
                    ->isEqualTo(0)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo('')

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileIndent('    '))
                ->integer($output->getCurrentTemplateIndent())
                    ->isEqualTo(1)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->inc();' . PHP_EOL
                    )

                // still 4 spaces
                ->given($output->compileIndent('    '))
                ->integer($output->getCurrentTemplateIndent())
                    ->isEqualTo(1)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->inc();' . PHP_EOL
                    )

                ->given($output->compileIndent(''))
                ->integer($output->getCurrentTemplateIndent())
                    ->isEqualTo(0)
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->inc();' . PHP_EOL .
                        '$this->dec();' . PHP_EOL
                    )
        ;
    }

    public function testCompileLine()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('{{}}'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo('')

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('{% if(foobar) %}'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo('if(foobar) {' . PHP_EOL)

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('{% else %}'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo('} else {' . PHP_EOL)

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('{% end %}'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo('}' . PHP_EOL)

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('foobar'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->add("foobar");' . PHP_EOL .
                        '$this->addLn();'       . PHP_EOL
                    )
        ;
    }

    public function testCompileText()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('foo{{{ $variable }}}bar'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->add("foo");'      . PHP_EOL .
                        '$this->dump($variable);' . PHP_EOL .
                        '$this->add("bar");'      . PHP_EOL .
                        '$this->addLn();'         . PHP_EOL
                    )

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('foo{{ $variable }}bar'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->add("foo");'     . PHP_EOL .
                        '$this->add($variable);' . PHP_EOL .
                        '$this->add("bar");'     . PHP_EOL .
                        '$this->addLn();'        . PHP_EOL
                    )

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('foobar'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->add("foobar");' . PHP_EOL .
                        '$this->addLn();'       . PHP_EOL
                    )

                ->given($output->setCurrentTemplateCompilation(''))
                ->given($output->compileLine('foobar{{}}'))
                ->string($output->getCurrentTemplateCompilation())
                    ->isEqualTo(
                        '$this->add("foobar");' . PHP_EOL
                    )
        ;
    }

    public function testIncDec()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setLevel(0))
                ->object($output->inc())
                    ->isIdenticalTo($output)
                ->integer($output->getLevel())
                    ->isEqualTo(1)

                ->object($output->inc())
                    ->isIdenticalTo($output)
                ->integer($output->getLevel())
                    ->isEqualTo(2)

                ->object($output->dec())
                    ->isIdenticalTo($output)
                ->integer($output->getLevel())
                    ->isEqualTo(1)

                ->object($output->dec())
                    ->isIdenticalTo($output)
                ->integer($output->getLevel())
                    ->isEqualTo(0)
        ;
    }

    public function testDump()
    {
        $this
            ->if($mockDump = new mockDump)
            ->and($this->calling($mockDump)->dump = null)
            ->and($output = new TestedClass($mockDump))
                ->object($output->dump($variable = uniqid()))
                    ->isIdenticalTo($output)
                ->mock($mockDump)
                    ->call('dump')
                        ->once()
                        ->withIdenticalArguments(
                            $variable,
                            $output,
                            null
                        )
                            ->once()

                ->given($this->resetMock($mockDump))
                ->object($output->dump($variable = uniqid(), mockDump::FORMAT_SHORT))
                    ->isIdenticalTo($output)
                ->mock($mockDump)
                    ->call('dump')
                        ->once()
                        ->withIdenticalArguments(
                            $variable,
                            $output,
                            mockDump::FORMAT_SHORT
                        )
                            ->once()
        ;
    }

    public function testExecuteCurrentTemplate()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
                ->given(
                    $output->setCurrentTemplateCompilation(
                        '$this->add("foo");'      . PHP_EOL .
                        '$this->add($variable);'  . PHP_EOL .
                        '$this->add("bar");'      . PHP_EOL .
                        '$this->addLn();'         . PHP_EOL
                    )
                )
                ->output(
                    function() use($output, &$variable) {
                        $output->executeCurrentTemplate(
                            array(
                                'variable' => $variable = uniqid()
                            )
                        );
                    }
                )
                    ->isEqualTo('foo' . $variable . 'bar' . PHP_EOL)
        ;
    }

    public function testSetGetAutoIndent()
    {
        $this
            ->if($mockDump = new mockDump)
            ->and($output = new TestedClass($mockDump))
                ->object($output->setAutoIndent(true))
                    ->isIdenticalTo($output)
                ->boolean($output->getAutoIndent())
                    ->isTrue()

            ->if($parentOutput = new mockOutput($mockDump))
            ->and($output->setParentOutput($parentOutput))
                ->object($output->setAutoIndent(false))
                    ->isIdenticalTo($output)
                ->boolean($output->getAutoIndent())
                    ->isFalse()
                ->mock($parentOutput)
                    ->call('setAutoIndent')
                        ->twice() // init + from $output
                        ->withIdenticalArguments(true)  // init
                            ->once()
                        ->withIdenticalArguments(false) // from $output
                            ->once()
        ;
    }

    public function testSetGetCurrentPosition()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setCurrentPosition($position = rand(10, 20)))
                    ->isIdenticalTo($output)
                ->integer($output->getCurrentPosition())
                    ->isEqualTo($position)
        ;
    }

    public function testSetGetCurrentTemplate()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setCurrentTemplate($template = uniqid()))
                    ->isIdenticalTo($output)
                ->string($output->getCurrentTemplate())
                    ->isEqualTo($template)
        ;
    }

    public function testSetGetCurrentTemplateAddLnAfterLine()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setCurrentTemplateAddLnAfterLine(true))
                    ->isIdenticalTo($output)
                ->boolean($output->getCurrentTemplateAddLnAfterLine())
                    ->isTrue()
        ;
    }

    public function testSetGetCurrentTemplateIndent()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setCurrentTemplateIndent($indent = rand(10, 20)))
                    ->isIdenticalTo($output)
                ->integer($output->getCurrentTemplateIndent())
                    ->isEqualTo($indent)
        ;
    }

    public function testSetGetCurrentTemplateSource()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setCurrentTemplateSource($source = array(uniqid())))
                    ->isIdenticalTo($output)
                ->array($output->getCurrentTemplateSource())
                    ->isEqualTo($source)
        ;
    }

    public function testSetGetDumper()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setDumper($dumper = new mockDump))
                    ->isIdenticalTo($output)
                ->object($output->getDumper())
                    ->isIdenticalTo($dumper)
        ;
    }

    public function testSetGetIndent()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setIndent($indent = rand(10, 20)))
                    ->isIdenticalTo($output)
                ->integer($output->getIndent())
                    ->isEqualTo($indent)
        ;
    }

    public function testSetGetLevel()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setLevel($level = rand(10, 20)))
                    ->isIdenticalTo($output)
                ->integer($output->getLevel())
                    ->isEqualTo($level)
        ;
    }

    public function testSetGetParentOutput()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setParentOutput($parentOutput = new mockOutput(new mockDump)))
                    ->isIdenticalTo($output)
                ->object($output->getParentOutput())
                    ->isIdenticalTo($parentOutput)
        ;
    }

    public function testSetGetPrefix()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setPrefix($prefix = uniqid()))
                    ->isIdenticalTo($output)
                ->string($output->getPrefix())
                    ->isEqualTo($prefix)
        ;
    }

    public function testGetSpace()
    {
        $this
            ->given($output = new TestedClass(new mockDump))

            ->if( $output->setAutoIndent(false))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(0))
            ->and($output->setPrefix(''))
                ->string($output->getSpace())
                    ->isEqualTo('')

            ->if( $output->setAutoIndent(false))
            ->and($output->setCurrentPosition(10))
            ->and($output->setIndent(4))
            ->and($output->setLevel(0))
            ->and($output->setPrefix(''))
                ->string($output->getSpace())
                    ->isEqualTo('')

            ->if( $output->setAutoIndent(false))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(1))
            ->and($output->setPrefix(''))
                ->string($output->getSpace())
                    ->isEqualTo('')

            ->if( $output->setAutoIndent(false))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(0))
            ->and($output->setPrefix('-'))
                ->string($output->getSpace())
                    ->isEqualTo('')

            ->if( $output->setAutoIndent(true))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(0))
            ->and($output->setPrefix(''))
                ->string($output->getSpace())
                    ->isEqualTo('')

            ->if( $output->setAutoIndent(true))
            ->and($output->setCurrentPosition(3))
            ->and($output->setIndent(4))
            ->and($output->setLevel(0))
            ->and($output->setPrefix(''))
                ->string($output->getSpace())
                    ->isEqualTo('   ')

            ->if( $output->setAutoIndent(true))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(1))
            ->and($output->setPrefix(''))
                ->string($output->getSpace())
                    ->isEqualTo('    ')

            ->if( $output->setAutoIndent(true))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(1))
            ->and($output->setPrefix('-'))
                ->string($output->getSpace())
                    ->isEqualTo('-   ')

            ->if( $output->setAutoIndent(true))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(1))
            ->and($output->setPrefix('*-'))
                ->string($output->getSpace())
                    ->isEqualTo('*-  ')

            ->given($parentOutput = new TestedClass(new mockDump))
            ->given($output->setParentOutput($parentOutput))

            ->if( $parentOutput->setAutoIndent(true))
            ->and($parentOutput->setCurrentPosition(null))
            ->and($parentOutput->setIndent(4))
            ->and($parentOutput->setLevel(1))
            ->and($parentOutput->setPrefix('|'))
            ->and($output->setAutoIndent(true))
            ->and($output->setCurrentPosition(null))
            ->and($output->setIndent(4))
            ->and($output->setLevel(1))
            ->and($output->setPrefix('-'))
                ->string($output->getSpace())
                    ->isEqualTo('|   -   ')

            ->if( $output->setAutoIndent(false))
            ->and($parentOutput->setAutoIndent(true))
                ->string($output->getSpace())
                    ->isEqualTo('|   ')
        ;
    }

    public function testInitCurrentTemplate()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
                ->object($output->initCurrentTemplate())
                    ->isIdenticalTo($output)
                ->variable($output->getCurrentTemplateSource())
                    ->isNull()
                ->variable($output->getCurrentTemplateCompilation())
                    ->isNull()
        ;
    }

    public function testIsCurrentTemplateCompiled()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setCurrentTemplate(uniqid()))
            ->and($output->initCurrentTemplate())
                ->boolean($output->isCurrentTemplateCompiled())
                    ->isFalse()

            ->if($output->setCurrentTemplateCompilation(uniqid()))
                ->boolean($output->isCurrentTemplateCompiled())
                    ->isTrue()
        ;
    }

    public function testLoadTemplate()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->loadTemplate($template = 'css.html'))
                    ->isIdenticalTo($output)
                ->array($output->getCurrentTemplateSource())
                    ->isEqualTo(file(__DIR__ . '/../../../resources/templates/' . $template))
                ->variable($output->getCurrentTemplateCompilation())
                    ->isNull()
        ;
    }

    public function testRender()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->output(
                    function() use($output) {
                        $output->render(
                            'array.short.cli',
                            array(
                                'array' => new ArrayProxy(array(), new mockDump)
                            )
                        );
                    }
                )
                    ->isEqualTo('array()')
        ;
    }

    public function testReset()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->setAutoIndent(false))
            ->and($output->setCurrentPosition(42))
            ->and($output->setLevel(42))
                ->object($output->reset())
                    ->isIdenticalTo($output)
                ->boolean($output->getAutoIndent())
                    ->isTrue()
                ->variable($output->getCurrentPosition(42))
                    ->isEqualTo(null)
                ->integer($output->getLevel(42))
                    ->isEqualTo(0)
        ;
    }

    public function testTemplateExists()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->boolean($output->templateExists($template = uniqid()))
                    ->isFalse()

            ->if($output->setCurrentTemplate($template))
            ->if($output->initCurrentTemplate())
                ->boolean($output->templateExists($template))
                    ->isTrue()
        ;
    }

    public function testSetGetEnableDisableFontOptions()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setFontOptionsEnabled(true))
                    ->isIdenticalTo($output)
                ->boolean($output->getFontOptionsEnabled())
                    ->isTrue()
                ->boolean($output->isFontOptionsEnabled())
                    ->isTrue()
                ->boolean($output->isFontOptionsDisabled())
                    ->isFalse()

                ->object($output->setFontOptionsEnabled(false))
                    ->isIdenticalTo($output)
                ->boolean($output->getFontOptionsEnabled())
                    ->isFalse()
                ->boolean($output->isFontOptionsEnabled())
                    ->isFalse()
                ->boolean($output->isFontOptionsDisabled())
                    ->isTrue()

                ->object($output->enableFontOptions())
                    ->isIdenticalTo($output)
                ->boolean($output->getFontOptionsEnabled())
                    ->isTrue()

                ->object($output->disableFontOptions())
                    ->isIdenticalTo($output)
                ->boolean($output->getFontOptionsEnabled())
                    ->isFalse()
        ;
    }

    public function testGenerateFontOptions()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
            ->and($output->enableFontOptions())
                ->string($output->generateFontOptions('reset'))
                    ->isEqualTo("\033[0m")
                ->string($output->generateFontOptions('fgblack'))
                    ->isEqualTo("\033[30m")
                ->string($output->generateFontOptions('fgred'))
                    ->isEqualTo("\033[31m")
                ->string($output->generateFontOptions('fggreen'))
                    ->isEqualTo("\033[32m")
                ->string($output->generateFontOptions('fgyellow'))
                    ->isEqualTo("\033[33m")
                ->string($output->generateFontOptions('fgblue'))
                    ->isEqualTo("\033[34m")
                ->string($output->generateFontOptions('fgmagenta'))
                    ->isEqualTo("\033[35m")
                ->string($output->generateFontOptions('fgcyan'))
                    ->isEqualTo("\033[36m")
                ->string($output->generateFontOptions('fgwhite'))
                    ->isEqualTo("\033[37m")
                ->string($output->generateFontOptions('bgblack'))
                    ->isEqualTo("\033[40m")
                ->string($output->generateFontOptions('bgred'))
                    ->isEqualTo("\033[41m")
                ->string($output->generateFontOptions('bggreen'))
                    ->isEqualTo("\033[42m")
                ->string($output->generateFontOptions('bgyellow'))
                    ->isEqualTo("\033[43m")
                ->string($output->generateFontOptions('bgblue'))
                    ->isEqualTo("\033[44m")
                ->string($output->generateFontOptions('bgmagenta'))
                    ->isEqualTo("\033[45m")
                ->string($output->generateFontOptions('bgcyan'))
                    ->isEqualTo("\033[46m")
                ->string($output->generateFontOptions('bgwhite'))
                    ->isEqualTo("\033[47m")
                ->string($output->generateFontOptions('bold'))
                    ->isEqualTo("\033[1m")
                ->string($output->generateFontOptions('underscore'))
                    ->isEqualTo("\033[4m")
                ->string($output->generateFontOptions('blink'))
                    ->isEqualTo("\033[5m")
                ->string($output->generateFontOptions('reverse'))
                    ->isEqualTo("\033[7m")
                ->string($output->generateFontOptions('conceal'))
                    ->isEqualTo("\033[8m")

                ->string($output->generateFontOptions('fgblack;bgblack;bold'))
                    ->isEqualTo("\033[30;40;1m")

                ->exception(
                    function() use($output, &$fontOption) {
                        $output->generateFontOptions($fontOption = uniqid());
                    }
                )
                    ->isInstanceOf('OutOfRangeException')
                    ->hasMessage(
                        sprintf(
                            '"%s" is not a valid font option',
                            $fontOption
                        )
                    )
        ;
    }

    public function testSetGetPrefixFontOptions()
    {
        $this
            ->if($output = new TestedClass(new mockDump))
                ->object($output->setPrefixFontOptions($prefixFontOptions = uniqid()))
                    ->isIdenticalTo($output)
                ->string($output->getPrefixFontOptions())
                    ->isEqualTo($prefixFontOptions)
        ;
    }
}