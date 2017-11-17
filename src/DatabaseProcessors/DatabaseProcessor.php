<?php

namespace Eihen\JasperPHP;

/**
 * Database Processor
 *
 * Base for specific databases processors
 *
 * @package Eihen\JasperPHP
 */
abstract class DatabaseProcessor extends Processor
{
    /**
     * Set the Database Host
     *
     * @param string $host Host name
     *
     * @return $this
     */
    public function host($host)
    {
        $this->args['dbHost'] = !empty($host) ? "-H \"$host\"" : '';

        return $this;
    }

    /**
     * Set the Database Host Port
     *
     * @param string $port Host port
     *
     * @return $this
     */
    public function port($port)
    {
        $this->args['dbPort'] = !empty($port) ? "--db-port \"$port\"" : '';

        return $this;
    }

    /**
     * Set the Database Name
     *
     * @param string $name Database name
     *
     * @return $this
     */
    public function database($name)
    {
        $this->args['dbName'] = !empty($name) ? "-n \"$name\"" : '';

        return $this;
    }

    /**
     * Set the Database User
     *
     * @param string $user Database user
     *
     * @return $this
     */
    public function user($user)
    {
        $this->args['dbUser'] = !empty($user) ? "-u \"$user\"" : '';

        return $this;
    }

    /**
     * Set the Database Password
     *
     * @param string $password Database password
     *
     * @return $this
     */
    public function password($password)
    {
        $this->args['dbPassword'] = !empty($password) ? "-p \"$password\"" : '';

        return $this;
    }

    /**
     * Set the arguments for the database connection
     * Accepted keys are: host, port, database (or name), user (or username), password
     *
     * @param array $dbArgs Database configuration parameters
     *
     * @return $this
     */
    public function dbArgs(array $dbArgs)
    {
        if (isset($dbArgs['host'])) {
            $this->host($dbArgs['host']);
        }

        if (isset($dbArgs['port'])) {
            $this->port($dbArgs['port']);
        }

        if (isset($dbArgs['database'])) {
            $this->database($dbArgs['database']);
        }

        if (isset($dbArgs['name'])) {
            $this->database($dbArgs['name']);
        }

        if (isset($dbArgs['user'])) {
            $this->user($dbArgs['username']);
        }

        if (isset($dbArgs['username'])) {
            $this->user($dbArgs['username']);
        }

        if (isset($dbArgs['password'])) {
            $this->password($dbArgs['password']);
        }
        return $this;
    }
}
