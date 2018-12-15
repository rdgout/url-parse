<?php

use \PHPUnit\Framework\TestCase;

/**
 * Class UrlTest
 *
 * This class houses unit tests to check if our class is working correctly
 */
class UrlTest extends TestCase
{
    /**
     * This is the valid test URI we use to test all parts of the parsing
     */
    const COMPLETE_TEST_URI = 'https://user:password@www.testdomain.com:8080/page?query=testing&foo=bar#anchor';
    /**
     * This is a URI we can use that should yield some empty fields like scheme, user, pass, port, etc.
     */
    const INCOMPLETE_TEST_URI = '//www.something-else.net/index.php';
    /**
     * This is a URI we can use that should yield some empty fields like scheme, user, pass, port, etc.
     */
    const PARTIAL_TEST_URI = 'www.google.com/search?q=test';

    /**
     * Tests if the class instantiated is actually a Url class
     */
    public function testInstantiation(): void
    {
        // Simply check if the URI is accepted and an exception is not thrown anywhere.
        $this->assertInstanceOf(Url::class, (new Url(self::COMPLETE_TEST_URI)));
        $this->assertInstanceOf(Url::class, (new Url(self::INCOMPLETE_TEST_URI)));
        $this->assertInstanceOf(Url::class, (new Url(self::PARTIAL_TEST_URI)));
    }

    /**
     * Tests if the class correctly parses the scheme (protocol) from the URI
     */
    public function testIfTheSchemeIsParsedCorrectly(): void
    {
        // Check if the scheme is parsed correctly from the URI
        $this->assertEquals(
            'https',
            (new Url(self::COMPLETE_TEST_URI))->getScheme()
        );

        // Check if the scheme is correctly parsed to null
        $this->assertNull((new Url(self::INCOMPLETE_TEST_URI))->getScheme());
        // Check if the scheme is correctly parsed to null
        $this->assertNull((new Url(self::PARTIAL_TEST_URI))->getScheme());
    }

    /**
     * Tests if the class correctly parses the user from the URI
     */
    public function testIfTheUserIsParsedCorrectly(): void
    {
        // Check if the username is parsed correctly from the URI
        $this->assertEquals(
            'user',
            (new Url(self::COMPLETE_TEST_URI))->getUser()
        );

        // Check if the username is correctly parsed to null
        $this->assertNull((new Url(self::INCOMPLETE_TEST_URI))->getUser());
        // Check if the username is correctly parsed to null
        $this->assertNull((new Url(self::PARTIAL_TEST_URI))->getUser());
    }

    /**
     * Tests if the class correctly parses the password from the URI
     */
    public function testIfThePassIsParsedCorrectly(): void
    {
        // Check if the username is parsed correctly from the URI
        $this->assertEquals(
            'password',
            (new Url(self::COMPLETE_TEST_URI))->getPass()
        );

        // Check if the password is correctly parsed to null
        $this->assertNull((new Url(self::INCOMPLETE_TEST_URI))->getPass());
        // Check if the password is correctly parsed to null
        $this->assertNull((new Url(self::PARTIAL_TEST_URI))->getPass());
    }

    /**
     * Tests if the class instantiated is actually a Url class
     */
    public function testIfTheHostIsParsedCorrectly(): void
    {
        // Check if the hostname is parsed correctly from the URI
        $this->assertEquals(
            'www.testdomain.com',
            (new Url(self::COMPLETE_TEST_URI))->getHost()
        );

        // Check if the hostname is parsed correctly from the URI
        $this->assertEquals(
            'www.something-else.net',
            (new Url(self::INCOMPLETE_TEST_URI))->getHost()
        );

        // Check if the hostname is parsed correctly from the URI
        $this->assertEquals(
            'www.google.com',
            (new Url(self::PARTIAL_TEST_URI))->getHost()
        );
    }

    /**
     * Tests if the class correctly parses the port from the URI
     */
    public function testIfThePortIsParsedCorrectly(): void
    {
        // Check if the port is parsed correctly from the URI
        $this->assertEquals(
            '8080',
            (new Url(self::COMPLETE_TEST_URI))->getPort()
        );

        // Check if the port is correctly parsed to null
        $this->assertNull((new Url(self::INCOMPLETE_TEST_URI))->getPort());
        // Check if the port is correctly parsed to null
        $this->assertNull((new Url(self::PARTIAL_TEST_URI))->getPort());
    }

    /**
     * Tests if the class correctly parses the path from the URI
     */
    public function testIfThePathIsParsedCorrectly(): void
    {
        // Check if the path is parsed correctly from the URI
        $this->assertEquals(
            '/page',
            (new Url(self::COMPLETE_TEST_URI))->getPath()
        );

        // Check if the path is parsed correctly from the URI
        $this->assertEquals(
            '/index.php',
            (new Url(self::INCOMPLETE_TEST_URI))->getPath()
        );

        // Check if the path is parsed correctly from the URI
        $this->assertEquals(
            '/search',
            (new Url(self::PARTIAL_TEST_URI))->getPath()
        );
    }

    /**
     * Tests if the class correctly parses the query from the URI
     */
    public function testIfTheQueryIsParsedCorrectly(): void
    {
        // Check if the query is parsed correctly from the URI
        $this->assertEquals(
            'query=testing&foo=bar',
            (new Url(self::COMPLETE_TEST_URI))->getQuery()
        );

        // Check if the query is correctly parsed to null
        $this->assertNull((new Url(self::INCOMPLETE_TEST_URI))->getQuery());

        // Check if the query is parsed correctly from the URI
        $this->assertEquals(
            'q=test',
            (new Url(self::PARTIAL_TEST_URI))->getQuery()
        );
    }

    /**
     * Tests if the class correctly parses the fragment from the URI
     */
    public function testIfTheFragmentIsParsedCorrectly(): void
    {
        // Check if the fragment is parsed correctly from the URI
        $this->assertEquals(
            'anchor',
            (new Url(self::COMPLETE_TEST_URI))->getFragment()
        );

        // Check if the fragment is correctly parsed to null
        $this->assertNull((new Url(self::INCOMPLETE_TEST_URI))->getFragment());
        // Check if the fragment is correctly parsed to null
        $this->assertNull((new Url(self::PARTIAL_TEST_URI))->getFragment());
    }

    /**
     * Tests if we can use the class as a string
     * and if it returns the expected string
     */
    public function testCanBeUsedAsString(): void
    {
        // Check if the URI is correctly parsed and re-written as a string
        $this->assertEquals(
            self::COMPLETE_TEST_URI,
            (string)(new Url(self::COMPLETE_TEST_URI))
        );
        // Check if the URI is correctly parsed and re-written as a string
        $this->assertEquals(
            self::COMPLETE_TEST_URI,
            (string)(new Url(self::COMPLETE_TEST_URI))
        );
        // Check if the URI is correctly parsed and re-written as a string
        $this->assertEquals(
            self::COMPLETE_TEST_URI,
            (string)(new Url(self::COMPLETE_TEST_URI))
        );
    }
}