<?php
namespace Consolidation\AnnotationCommand;

class CommandInfoTests extends \PHPUnit_Framework_TestCase
{
    function flattenArray($actualValue)
    {
        $result = [];
        foreach ($actualValue as $key => $value) {
          if (!is_string($value)) {
              $value = var_export($value, true);
          }
          $result[] = "{$key}=>{$value}";
        }
        return implode("\n", $result);
    }

    /**
     * Test CommandInfo command annotation parsing.
     */
    function testParsing()
    {
        $commandInfo = new CommandInfo('\Consolidation\TestUtils\TestCommandFile', 'testArithmatic');

        $this->assertEquals('test:arithmatic', $commandInfo->getName());
        $this->assertEquals(
            'This is the test:arithmatic command',
            $commandInfo->getDescription()
        );
        $this->assertEquals(
            "This command will add one and two. If the --negate flag\nis provided, then the result is negated.",
            $commandInfo->getHelp()
        );
        $this->assertEquals('arithmatic', implode(',', $commandInfo->getAliases()));
        $this->assertEquals(
            '2 2 --negate=>Add two plus two and then negate.',
            $this->flattenArray($commandInfo->getExampleUsages())
        );
        $this->assertEquals(
            'The first number to add.',
            $commandInfo->getArgumentDescription('one')
        );
        $this->assertEquals(
            'The other number to add.',
            $commandInfo->getArgumentDescription('two')
        );
        $this->assertEquals(
            'Whether or not the result should be negated.',
            $commandInfo->getOptionDescription('negate')
        );
    }
}