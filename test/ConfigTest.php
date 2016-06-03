<?php


namespace StartSSL_Test;


use StartSSL\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function provideData()
    {
        $r = [];
        foreach ([
                     false,
                     true,
                     'get',
                     'set',
                 ] as $p) {
            foreach ([
                         ['fooBar', 'fooBar'],
                         ['fooBar', 'foo-bar'],
                         ['fooBarBaz', 'foo-bar_baz'],
                         ['fooBarBaz', 'foo.bar Baz'],
                     ] as $d) {
                $r[] = [(is_bool($p) ? '' : $p) . ($p ? ucfirst($d[0]) : $d[0]), $d[1], $p];
            }
        }
        return $r;
    }

    /**
     * @dataProvider provideData
     * @param string $expected
     * @param string $offset
     * @param string|bool $prefix
     */
    public function testName($expected, $offset, $prefix = false)
    {
        $this->assertEquals($expected, Config::Name($offset, $prefix));
    }

    public function testRecurse()
    {
        $a = ['foo', 'bar','baz'=>['bax']];
        $b = [0, 1, 2];
        $c = ['a'=>&$a, 'b'=>&$b];
        $config = new Config($c);
        $ca = new Config($a);
        $cb = new Config($b);
        $this->assertEquals($ca, $config->a);
        $this->assertEquals($cb, $config->b);
        $this->assertEquals('bax', $config->a->baz[0]);
        $this->assertEquals($ca, $config['a']);
        $this->assertEquals($cb, $config['b']);
        $this->assertEquals('bax', $config['a']['baz'][0]);
        $this->assertNotEmpty($config->a->baz);
        unset($config->a->baz[0]);
        $this->assertEmpty($config->a->baz);
    }
}
