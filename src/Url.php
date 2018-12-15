<?php

/**
 * Class Url
 *
 * This class parses a URL and provides getters to fetch the various parts of the inserted URL.
 */
class Url
{
    /**
     * All string related identifiers we use to build the URL
     */
    const SCHEME_SEPARATOR = '://';
    const RELATIVE_SCHEME = '//';
    const USERPASS_SEPARATOR = ':';
    const PORT_SEPARATOR = ':';
    const SLASH = '/';
    const HOST_SEPARATOR = '@';
    const QUERY_SEPARATOR = '?';
    const ANCHOR_SEPARATOR = '#';

    /**
     * The default scheme we use when we have to use a work-around for parse_url
     * Options are: http, https, ftp
     */
    const DEFAULT_SCHEME = 'http';

    /**
     * These are our private variables which we can only set internally.
     * This makes sure they cannot be tampered with by outside sources.
     *
     * The names of these variables speak for themselves.
     */
    private $scheme;
    private $host;
    private $port;
    private $user;
    private $pass;
    private $path;
    private $query;
    private $fragment;
    /**
     * This is the URI that's sent to us in the constructor.
     * We use this to determine if we should use a work-around to fix parse_url
     */
    private $uri;

    /**
     * Url constructor.
     *
     * @param string $uri
     */
    public function __construct(string $uri)
    {
        $this->setUrlParts($uri);
    }

    /**
     * Returns the scheme
     *
     * @return mixed
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Returns the host
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Returns the port
     *
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Returns the user
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns the password
     *
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Returns the path
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns the query
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Returns the fragment
     *
     * @return mixed
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * This function makes sure a full URL is returned when the class is cast to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
        // Set up all the parts we might possibly have
            '%s%s%s%s%s%s%s%s%s%s%s%s%s%s',
            $this->getScheme(),
            // If we had a scheme, we should add the protocol identifier to the URL
            $this->getScheme() ? self::SCHEME_SEPARATOR : null,
            $this->getUser(),
            // If we have a user, we should add the separator to the URL
            $this->getUser() ? self::USERPASS_SEPARATOR : null,
            $this->getPass(),
            // If we have a password, we should add the separator to the URL
            ($this->getUser() || $this->getPass()) ? self::HOST_SEPARATOR : null,
            $this->getHost(),
            // If we have a host, we should add the port separator to the URL
            $this->getPort() ? self::PORT_SEPARATOR : null,
            $this->getPort(),
            $this->getPath(),
            // If we have a query, we should add the separator to the URL
            $this->getQuery() ? self::QUERY_SEPARATOR : null,
            $this->getQuery(),
            // If we have a fragment, we should add the separator to the URL
            $this->getFragment() ? self::ANCHOR_SEPARATOR : null,
            $this->getFragment()
        );
    }

    /**
     * Parses all URL parts into their respective parts
     *
     * @param string $uri
     */
    private function setUrlParts(string $uri)
    {
        // Store the original URI so we check against it later.
        $this->uri = trim($uri);

        // Check if the URI is missing a relative scheme or the scheme entirely
        // This is a work around for issues the parse_url function has
        if ($this->uriHasNoScheme() || $this->uriHasNoRelativeScheme()) {
            // Append a temporary scheme to the URI so it parses correctly.
            $uri = sprintf(
                '%s%s%s',
                self::DEFAULT_SCHEME,
                $this->uriHasNoRelativeScheme() ? self::PORT_SEPARATOR : self::SCHEME_SEPARATOR,
                $uri
            );
        }

        // Parse the URL with the default PHP function since this already deals with a lot of issues
        // you might encounter. It's also fully RFC 3986 compliant.
        // Writing your own version of this is probably a waste of time.
        $parsedUri = parse_url($uri);

        // Set the parsed parts to our respective variables
        // and nullify any parts we may not have found.
        // Special case: if we needed to use the work around for an incomplete URL,
        // we should not store the scheme.
        $this->scheme   =
            ! ($this->uriHasNoRelativeScheme() || $this->uriHasNoScheme()) ? $parsedUri['scheme'] ?? null : null;
        // Using the PHP7 null coalesce operator we can safely do this without having to use
        // various isset checks to see if the array has the right index.
        $this->host     = $parsedUri['host'] ?? null;
        $this->port     = $parsedUri['port'] ?? null;
        $this->user     = $parsedUri['user'] ?? null;
        $this->pass     = $parsedUri['pass'] ?? null;
        $this->path     = $parsedUri['path'] ?? null;
        $this->query    = $parsedUri['query'] ?? null;
        $this->fragment = $parsedUri['fragment'] ?? null;
    }

    /**
     * Checks if the URL starts with //
     *
     * @return bool
     */
    private function uriHasNoRelativeScheme(): bool
    {
        return substr($this->uri, 0, 2) === self::RELATIVE_SCHEME;
    }

    /**
     * Checks if the URL has :// in it
     *
     * @return bool
     */
    private function uriHasNoScheme(): bool
    {
        return strpos($this->uri, self::SCHEME_SEPARATOR) === false;
    }
}