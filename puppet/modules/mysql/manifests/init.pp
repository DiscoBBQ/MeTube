class mysql 
{
    $mysqlPassword = "u5"
    $mysqlUser     = "u5"
    $databaseName  = "u5"
    $testDatabaseName = "metube_test"

    package 
    { 
        "mysql-server":
            ensure  => present,
            require => Exec['apt-get update']
    }

    service 
    { 
        "mysql":
            enable => true,
            ensure => running,
            require => Package["mysql-server"],
    }

    # Make sure that any previously setup boxes are gracefully 
    # transitioned to the new empty root password.
    exec
    {
    	"set-mysql-password":
            onlyif => "mysqladmin -uroot -proot status",
            command => "mysqladmin -uroot -proot password ",
            require => Service["mysql"],
    }

    exec{
        "create-user":
            unless => "/usr/bin/mysql -u$mysqlUser -p$mysqlPassword",
            command => "/usr/bin/mysql -uroot -e \"CREATE USER '$mysqlUser' IDENTIFIED BY '$mysqlPassword';\"",
            require => Service["mysql"],
    }

    exec 
    { 
        "create-default-db":
            unless => "/usr/bin/mysql -uroot $databaseName",
            command => "/usr/bin/mysql -uroot -e 'create database `$databaseName`;'",
            require => [Service["mysql"], Exec["set-mysql-password"]]
    }

    exec 
    { 
        "grant-default-db":
            command => "/usr/bin/mysql -uroot -e 'grant all on `$databaseName`.* to `root@localhost`;'",
            require => [Service["mysql"], Exec["create-default-db"]]
    }

    exec{
        "grand-user-db":
            command => "/usr/bin/mysql -uroot -e 'grant all on `$databaseName`.* to `$mysqlUser`;'",
            require => [Service["mysql"], Exec["create-default-db"], Exec["create-user"]]
    }

    exec 
    { 
        "create-test-db":
            unless => "/usr/bin/mysql -uroot $testDatabaseName",
            command => "/usr/bin/mysql -uroot -e 'create database `$testDatabaseName`;'",
            require => [Service["mysql"], Exec["set-mysql-password"]]
    }

    exec 
    { 
        "grant-test-db":
            command => "/usr/bin/mysql -uroot -e 'grant all on `$testDatabaseName`.* to `root@localhost`;'",
            require => [Service["mysql"], Exec["create-default-db"]]
    }

    exec 
    { 
        "grant-user-test-db":
            command => "/usr/bin/mysql -uroot -e 'grant all on `$testDatabaseName`.* to `$mysqlUser`;'",
            require => [Service["mysql"], Exec["create-default-db"], Exec["create-user"]]
    }
}
