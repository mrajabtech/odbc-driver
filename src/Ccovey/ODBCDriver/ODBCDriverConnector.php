<?php namespace Ccovey\ODBCDriver;

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;
use PDO;

class ODBCDriverConnector extends Connector implements ConnectorInterface
{

    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        $configOptions = \Arr::get($config, 'options');
//        dd($configOptions);

        foreach ($configOptions as $k => $v) {
            $options[$k] = $v;
        }
//        $options = array_diff_key($configOptions, $options) + $options;
//        $options= array_merge($options, $configOptions);

//        dd($options);

        $connection = $this->createConnection($dsn, $config, $options);

        return $connection;
    }

    protected function getDsn(array $config) {
        extract($config);

//        $dsn = "odbc:{$dsn}; Uid={$username}; Pwd={$password}; Database={$database}";
        $dsn = "snowflake:{$dsn};insecure_mode=true"; // Uid={$username}; Pwd={$password}; Database={$database}

        return $dsn;
    }

    /**
     * Create a new PDO connection.
     *
     * @param  string  $dsn
     * @param  array   $config
     * @param  array   $options
     * @return \PDO
     */
    public function createConnection($dsn, array $config, array $options)
    {
        $username = \Arr::get($config, 'username');
        $password = \Arr::get($config, 'password');

        return new PDO($dsn, $username, $password, $options);
    }

}
