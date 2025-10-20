<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Query;

/**
 * Query parser for converting named parameters to positional.
 * Handles DQL/SQL parsing and parameter binding.
 */
class Parser
{
    private const PARAMETER_PATTERN = '/:([a-zA-Z_][a-zA-Z0-9_]*)/';

    /**
     * Parse a query string with named parameters.
     */
    public function parse(string $query, array $parameters = []): ParserResult
    {
        $parameterMappings = [];
        $position = 1;

        // Replace named parameters with positional
        $sql = preg_replace_callback(
            self::PARAMETER_PATTERN,
            function ($matches) use (&$parameterMappings, &$position) {
                $name = $matches[1];
                $parameterMappings[$name] = $position++;
                return '?';
            },
            $query
        );

        $result = new ParserResult($sql, $parameters);

        foreach ($parameterMappings as $name => $pos) {
            $result->addParameterMapping($name, $pos);
        }

        return $result;
    }

    /**
     * Bind parameters to their positions.
     *
     * @param array<string|int, mixed> $parameters
     * @return array<int, mixed> Positional parameters
     */
    public function bindParameters(ParserResult $result, array $parameters): array
    {
        $bound = [];
        $mappings = $result->getParameterMappings();

        foreach ($parameters as $key => $value) {
            if (is_string($key) && isset($mappings[$key])) {
                // Named parameter
                $position = $mappings[$key];
                $bound[$position] = $value;
            } elseif (is_int($key)) {
                // Positional parameter
                $bound[$key] = $value;
            }
        }

        // Sort by position
        ksort($bound);

        return array_values($bound);
    }

    /**
     * Extract table names from a query.
     *
     * @return string[]
     */
    public function extractTables(string $query): array
    {
        $tables = [];

        // Match FROM clauses
        if (preg_match_all('/FROM\s+([a-zA-Z_][a-zA-Z0-9_]*)/i', $query, $matches)) {
            $tables = array_merge($tables, $matches[1]);
        }

        // Match JOIN clauses
        if (preg_match_all('/JOIN\s+([a-zA-Z_][a-zA-Z0-9_]*)/i', $query, $matches)) {
            $tables = array_merge($tables, $matches[1]);
        }

        return array_unique($tables);
    }

    /**
     * Validate query syntax.
     */
    public function validate(string $query): bool
    {
        // Basic validation: check for SQL injection patterns
        $dangerous = [
            '/;\s*DROP/i',
            '/;\s*DELETE\s+FROM/i',
            '/;\s*TRUNCATE/i',
            '/UNION.*SELECT/i',
        ];

        foreach ($dangerous as $pattern) {
            if (preg_match($pattern, $query)) {
                return false;
            }
        }

        return true;
    }
}
